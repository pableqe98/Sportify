<?php

namespace App\Http\Controllers\Entidad\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{

    protected $guard = 'entidad';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:entidad')->except('logout');
    }


    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login',[
            'title' => 'Login Empresa',
            'loginRoute' => 'entidad.login',
            'forgotPasswordRoute' => 'entidad.password.request',
        ]);
    }

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {   
        

        $this->validator($request);
    
        if(Auth::guard('entidad')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authentication passed...
            
            return redirect()
                ->intended(route('entidad.home'))
                ->with('status','You are Logged in as Entidad!');
        }
       
        //Authentication failed...
        return $this->loginFailed();
    }

    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('entidad')->logout();
        return redirect()
            ->route('entidad.login')
            ->with('status','admin has been logged out!');
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
      //validation rules.

     
      $rules = [
        'email'    => 'required|email',
        'password' => 'required|string',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'El email no existe.',
        ];

        //validate the request.
        $request->validate($rules,$messages);

        
    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        $errors = new MessageBag(['email' => ['Email y/o contraseña incorrectos']]);

        return redirect()->back()->withErrors($errors)->withInput();
        
    }
}

