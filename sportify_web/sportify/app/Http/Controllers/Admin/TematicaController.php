<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tematica;
use Auth;
use Illuminate\Support\MessageBag;

class TematicaController extends Controller
{
    //

    public function showTematicas(){

        $tematicas = Tematica::all();

        return view('admin.ver_tematicas',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'rutaCrearTematica' => 'admin.crear_tematica',
            'rutaEliminarTematica' => 'admin.eliminar_tematica',
            'imagen'=> null,
            'tematicas' => $tematicas            
            
        ]);

    }

    public function eliminarTematica(){

        DB::transaction(function () {
            $request = request();

            $id_eliminar = $request['id_tematica'];

            

            $tematica = Tematica::find($id_eliminar);

            $tematica->delete();
        });
        
        return $this->showDeleteCompleted();

    }

    public function showDeleteCompleted(){
        $errors = new MessageBag(['confirmed' => ['Tematica eliminada']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }



    public function crearTematica(){
        $this->validate(request(), [
            
            'nombre_tematica' => 'required'
        ]);

        DB::transaction(function()
       {
            
            $request = request();

            $nombre_tematica = $request['nombre_tematica'];

            $tematica = new Tematica;
            $tematica->nombre_tematica = $nombre_tematica;
            $tematica->save();

            DB::table('foro')->insert([
                'id_foro' => $tematica->id_tematica,
                'nombre_foro' => 'Foro '. $nombre_tematica,
                'id_tematica' => $tematica->id_tematica,
                ]);

       });

       return $this->showCreationCompleted();
    }


    public function showCreationCompleted(){
        $errors = new MessageBag(['confirmed' => ['Tematica creada']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
