<?php

namespace App\Http\Controllers\Individual;

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
        //Obtengo los eventos de las tematicas que interesqan al individual, para mostrarlos en su pagina principal

        $tematicas = DB::table('interesado')->select('id_tematica')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();

        $tem=[];
        foreach($tematicas as $tm){
            array_push($tem,$tm->id_tematica);
        }
        
        $eventos = DB::table('evento')->whereIn('id_tematica', $tem)->get();
        $todos = DB::table('evento')->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        
        
        return view('individual.home',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'eventos_interesado' => $eventos,
            'eventos_todos' => $todos
        ]);
    }

    public function showProfile(){
        //Obtengo la informacion de la tabla Usuario
        $id = Auth::guard('individual')->user()->id_individual;
        $user = DB::table('usuario')->where('id_usuario', $id )->first();

        $tematicas = DB::table('tematica')->get();

        $identificadores = DB::table('interesado')->where('id_individual',$id)->get();
        $elegidas=array();
        foreach($identificadores as $identificador){
            $elegidas[]=$identificador->id_tematica;
        }

        


        return view('individual.profile',[
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Empresa',
            'edit_profile' => 'individual.profile',
            'updateRoute' => 'individual.update',
            'imagen' => Auth::guard('individual')->user()->foto,
            'nombre_usuario' => $user->nombre_u,
            'n_completo' => Auth::guard('individual')->user()->name,
            'email' => $user->email,
            'password' => $user->password,
            'descripcion' => $user->descripcion_u,
            'tlf' => $user->tlf_u,
            'fecha' => Auth::guard('individual')->user()->fecha_nac_i,
            'tematicas' => $tematicas,
            'elegidas' => $elegidas
        ]);
    }

    public function update(){
        $individual = Auth::guard('individual')->user();
        $id = $individual->id_individual;

        $this->validate(request(), [
            'email' => 'unique:individuals,email,'.$individual->id_individual.',id_individual',
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
                $current_password = Auth::guard('individual')->user()->password;  
                //dd($current_password);     
                if(Hash::check($request_data['current-password'], $current_password))
                {                              
                
                    $individual->password = bcrypt($request['password']);
                    
                }
                else
                {           
                    $errors = new MessageBag(['incorrecto' => ['La contraseña antigua no es correcta.']]);

                    return redirect()->back()->withErrors($errors)->withInput();  
                }
            }    
        }
        
        $contraseña = $individual->password;

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

            $image_path = public_path().$individual->foto;  // Value is not URL but directory file path
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $individual->foto = $image;
        }

        $foto = $individual->foto;

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

    //Actualizo individual
        $individual->nombre_completo_i = $request['n_completo'];
        $individual->fecha_nac_i = $request['fecha'];
        $individual->email = $request['email'];
        
        //Actualizo las tematicas que le interesan
                //Elimino las filas que incluyen a este usuario
        DB::table('interesado')->where('id_individual', '=', $id)->delete();
                //Añado las seleccionadas
        $interesado = $request->interesado;

        foreach ($interesado as $tematica) {
            DB::table('interesado')->insert(
                ['id_individual' => $id, 'id_tematica' => $tematica]
            );
        }

        $individual->save();

        return $this->showUpdateCompleted();
        
    }

    public function validarCambioContraseña(array $data){

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

    public function showUpdateCompleted(){
        $errors = new MessageBag(['confirmed' => ['Perfil actualizado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
