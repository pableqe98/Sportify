<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin;
use Auth;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    //

    public function showAdmins(){

        $admins = Admin::where('id_admin','!=', Auth::guard('admin')->user()->id_admin)->get();

        return view('admin.ver_administradores',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'rutaEliminarAdmin' => 'admin.eliminar_admin',
            'imagen'=> null,
            'administradores' => $admins            
            
        ]);
    }

    public function eliminarAdmin(){

        DB::transaction(function () {
            $request = request();

            $id_eliminar = $request['id_admin'];

            

            $admin = Admin::find($id_eliminar);

            $admin->delete();
        });
        
        return $this->showDeleteCompleted();

    }

    public function showDeleteCompleted(){
        $errors = new MessageBag(['confirmed' => ['Administrador eliminado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
