<?php

namespace App\Http\Controllers\Entidad\Auth;

use App\Traits\UploadTrait;
use App\Http\Controllers\Controller;
use App\Entidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Str;


class RegisterController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
            $this->middleware('guest:entidad');
    }

    public function showRegistrationForm()
    {
        return view('auth.register',[
            'user_type' => 'entidad',
            'register_type' => 'Regsitro Empresa'
        ]);
    }
    
    public function register()
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'nombre_ent' => 'required|string',
            'direccion_ent' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'tlf' => 'required',
            'foto'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        //Lo hago dentor d euna transaccion
        DB::transaction(function()
        {
            $request = request();
        
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
                
            }
            
            $user = new Usuario;

            $user->password = bcrypt($request['password']);
            $user->nombre_u = $request['name'];
            $user->descripcion_u = $request['descripcion'];
            $user->foto_perf = $image;
            $user->tlf_u = $request['tlf'];
            $user->email = $request['email'];
            $user->tipo_u = "ENTIDAD";
            $user->puntuacion = 0;

            $user->save();
            
            $entidad = new Entidad;
            $entidad->id_entidad = $user['id_usuario'];
            $entidad->name = $request['nombre_ent'];
            $entidad->direccion_ent = $request['direccion_ent'];
            $entidad->email = $user['email'];
            $entidad->password = $user['password'];
            $entidad->foto = $image;

            $entidad->save();

        });
        
        
        
        
        return redirect()->intended('/entidad/login');
    }
}
