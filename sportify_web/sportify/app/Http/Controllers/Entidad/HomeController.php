<?php

namespace App\Http\Controllers\Entidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Usuario;
use Str;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{

    use UploadTrait;
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $todos = DB::table('evento')->get();

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('entidad.home',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'eventos_todos' => $todos
        ]);
    }

    public function showProfile(){

        //Obtengo la informacion de la tabla Usuario
        $id = Auth::guard('entidad')->user()->id_entidad;
        $user = DB::table('usuario')->where('id_usuario', $id )->first();

        

        return view('entidad.profile',[
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'nombre' => Auth::guard('entidad')->user()->name,
            'cabecera_sidebar' => 'Menu Empresa',
            'edit_profile' => 'entidad.profile',
            'updateRoute' => 'entidad.update',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'nombre_usuario' => $user->nombre_u,
            'nombre_ent' => Auth::guard('entidad')->user()->name,
            'email' => $user->email,
            'password' => $user->password,
            'descripcion' => $user->descripcion_u,
            'tlf' => $user->tlf_u,
            'direccion' => Auth::guard('entidad')->user()->direccion_ent
        ]);
    }

    public function update(){

        $entidad = Auth::guard('entidad')->user();
        $id = $entidad->id_entidad;
        

        $this->validate(request(), [
            'email' => 'unique:entidads,email,'.$entidad->id_entidad.',id_entidad',
            'name' => 'unique:usuario,nombre_u,'.$id.',id_usuario'
        ]);
        
        
        $request = request();
        $request_data = $request->All();

        if($request['password'] != null || $request['current-password'] != null || $request['password-confirm'] != null){
            $validator = $this->validarCambioContraseña($request_data);
            if($validator->fails()){
                $errors = new MessageBag(['incorrecto' => ['Error en cambio de contraseña.']]);

                return redirect()->back()->withErrors($errors)->withInput();
            }
            else{  
                $current_password = Auth::guard('entidad')->user()->password;  
                //dd($current_password);     
                if(Hash::check($request_data['current-password'], $current_password))
                {                              
                    
                    $entidad->password = bcrypt($request['password']);
                    
                
                }
                else
                {           
                    $errors = new MessageBag(['incorrecto' => ['La contraseña antigua no es correcta.']]);

                    return redirect()->back()->withErrors($errors)->withInput();  
                }
            }    
        }   

        $contraseña = $entidad->password;

        //Si he cambiado la foto
        if ($request->has('foto')) {
            // Get image file
            $image = $request->file('foto');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $image = $filePath;

            $image_path = public_path().$entidad->foto;  // Value is not URL but directory file path
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $entidad->foto = $image;
        }

        $foto = $entidad->foto;
        //Actualizo usuario
        $affected = DB::table('usuario')
              ->where('id_usuario', $id)
              ->update([
                  'password' => $contraseña,
                  'nombre_u' => $request['name'],
                  'descripcion_u' => $request['descripcion'],
                  'foto_perf' => $foto,
                  'tlf_u' => $request['tlf'],
                  'email' => $request['email']
                  ]);

    //Actualizo entidad
        $entidad->name = $request['nombre_ent'];
        $entidad->direccion_ent = $request['direccion_ent'];
        $entidad->email = $request['email'];
        

        $entidad->save();

        return $this->showUpdateCompleted();
    }

    public function validarCambioContraseña(array $data)
    {
        $messages = [
            'current-password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'current-password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',     
        ], $messages);

        return $validator;
    }  

    public function showUpdateCompleted()
    {
        $errors = new MessageBag(['confirmed' => ['Perfil actualizado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }

}
