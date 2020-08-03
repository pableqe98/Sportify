<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin;
use Auth;
use Illuminate\Support\MessageBag;

class EquipoController extends Controller
{
    //
    public function showEquipos(){

        $equipos = DB::table('equipo')->get();

        return view('admin.ver_equipos',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'rutaEliminarEquipo' => 'admin.eliminar_equipo',
            'imagen'=> null,
            'equipos' => $equipos            
            
        ]);
    }

    public function eliminarEquipo(){

        DB::transaction(function () {
            $request = request();

            $id_eliminar = $request['id_equipo'];


            $equipo = DB::table('equipo')->where('id_equipo','=',$id_eliminar)->delete();

        });
        
        return $this->showDeleteCompleted();

    }

    public function showDeleteCompleted(){
        $errors = new MessageBag(['confirmed' => ['Equipo eliminado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
