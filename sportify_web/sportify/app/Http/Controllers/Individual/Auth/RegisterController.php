<?php

namespace App\Http\Controllers\Individual\Auth;

use App\Http\Controllers\Controller;
use App\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Str;
use App\Traits\UploadTrait;
use PhpParser\Node\Expr\BinaryOp\Identical;

class RegisterController extends Controller
{
    use UploadTrait;

    public function __construct()
    {
            $this->middleware('guest:individual');
    }

    public function showRegistrationForm()
    {
        $tematicas = DB::table('tematica')->get();
        return view('auth.register',[
            'user_type' => 'individual',
            'register_type' => 'Registro Individual',
            'tematicas' => $tematicas
        ]);
    }
    
    public function register()
    {
        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'tlf' => 'required',
            'n_completo' => 'required|string',
            'foto'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'interesado' => 'required'
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
            $user->tipo_u = "INDIVIDUAL";
            $user->puntuacion = 0;

            $user->save();
          

            $individual = new Individual;
            $individual->id_individual = $user['id_usuario'];
            $individual->nombre_completo_i = $request['n_completo'];
            $individual->fecha_nac_i = $request['fecha'];
            $individual->email = $user['email'];
            $individual->password = $user['password'];
            $individual->foto = $image;
            
            $individual->save();

            //Temáticas que interesan al usuario
           $interesado = $request->interesado;

            foreach ($interesado as $tematica) {
                DB::table('interesado')->insert([
                    'id_individual' => $user['id_usuario'],
                    'id_tematica' => $tematica
                    ]
                );
            }
            
        });
        
        
        
        
        return redirect()->intended('/individual/login');
    }
}
