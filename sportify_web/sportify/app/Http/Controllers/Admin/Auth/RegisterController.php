<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class RegisterController extends Controller
{

    public function __construct()
    {
            
    }

    public function showRegistrationForm()
    {
        return view('auth.register',[
            'user_type' => 'admin',
            'register_type' => 'Registrar Nuevo Administrador'
        ]);
    }
    
    public function register()
    {
        $this->validate(request(), [
            
            'email' => 'required|unique:admins,email',
            'password' => 'required|confirmed',
            'tlf' => 'required',
            
        ]);

        

        
        //Lo hago dentor d euna transaccion
        DB::transaction(function()
        {
            $request = request();            
            
            $admin = Admin::create([
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'tlf_a' => $request['tlf'],
                
            ]);
        });
        
        
        
        
        return $this->showRegistrationCompleted();
    }

    public function showRegistrationCompleted()
    {
        $errors = new MessageBag(['confirmed' => ['Administrador registrado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
