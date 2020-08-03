<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\MessageBag;
use Validator;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('admin.home',[
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'imagen'=> null
        ]);
    }

    public function showProfile(){

        return view('admin.profile',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'email' => Auth::guard('admin')->user()->email,
            'tlf' => Auth::guard('admin')->user()->tlf_a,
            'imagen'=> null
            
        ]);
    }

    public function update(){
        $admin = Auth::guard('admin')->user();
        $id = $admin->id_admin;

        $this->validate(request(), [
            'email' => 'unique:admins,email,'.$id.',id_admin'
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
                $current_password = Auth::guard('admin')->user()->password;  
                //dd($current_password);     
                if(Hash::check($request_data['current-password'], $current_password))
                {                              
                
                    $admin->password = bcrypt($request['password']);
                    
                }
                else
                {           
                    $errors = new MessageBag(['incorrecto' => ['La contraseña antigua no es correcta.']]);

                    return redirect()->back()->withErrors($errors)->withInput();  
                }
            }    
        }

        //Actualizo individual
        $admin->tlf_a = $request['tlf'];
        $admin->email = $request['email'];
        $admin->save();

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

    public function showCrearAdmin(){

        return view('admin.register',[
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'imagen'=> null
        ]);
    }

    public function crearAdmin(){

    }

}
