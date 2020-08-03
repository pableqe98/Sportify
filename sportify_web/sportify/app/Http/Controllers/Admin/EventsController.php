<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin;
use Auth;
use Illuminate\Support\MessageBag;

class EventsController extends Controller
{
    //
    public function showEventos(){

        $eventos = DB::table('evento')->get();

        return view('admin.ver_eventos',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'rutaEliminarEvento' => 'admin.eliminar_evento',
            'imagen'=> null,
            'eventos' => $eventos            
            
        ]);
    }

    public function eliminarEvento(){

        DB::transaction(function () {
            $request = request();

            $id_eliminar = $request['id_evento'];


            $evento = DB::table('evento')->where('id_evento','=',$id_eliminar)->delete();

            $grupo_conv = DB::table('grupo_conversacion')->where('id_grupo_conv','=',$id_eliminar)->delete();

        });
        
        return $this->showDeleteCompleted();

    }

    public function showDeleteCompleted(){
        $errors = new MessageBag(['confirmed' => ['Evento eliminado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
