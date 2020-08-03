<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Individual;
use App\Entidad;
use Auth;
use Illuminate\Support\MessageBag;

class UsuarioController extends Controller
{
    //
    public function showUsuarios(){

        $usuarios = DB::table('usuario')->get();

        return view('admin.ver_usuarios',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'rutaEliminarUsuario' => 'admin.eliminar_usuario',
            'rutaVerUsuario' => "/admin/usuario/",
            'imagen'=> null,
            'usuarios' => $usuarios            
            
        ]);
    }

    public function eliminarUsuario(){

        DB::transaction(function () {
            $request = request();

            $id_eliminar = $request['id_usuario'];


            $usuario = DB::table('usuario')->where('id_usuario','=',$id_eliminar)->delete();

        });
        
        return $this->showDeleteCompleted();

    }

    public function showDeleteCompleted(){
        $errors = new MessageBag(['confirmed' => ['Usuario eliminado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }

    public function showUsuario($id){

        $usuario = DB::table('usuario')->where('id_usuario','=',$id)->first();

        if($usuario->tipo_u == 'INDIVIDUAL'){
            $individual = Individual::find($id);
            $usuario->nombre_completo = $individual->nombre_completo_i;
            $usuario->fecha_nac = $individual->fecha_nac_i;
        }
        else{
            $entidad = Entidad::find($id);
            $usuario->nombre_completo = $entidad->name;
            $usuario->direccion = $entidad->direccion_ent;
        }
        

        return view('admin.info_usuario',[
            'home' => 'admin.home',
            'logoutRoute' => 'admin.logout',
            'nombre' => 'Admin ' . Auth::guard('admin')->user()->id_admin,
            'cabecera_sidebar' => 'Menu Administrador',
            'edit_profile' => 'admin.profile',
            'updateRoute' => 'admin.update',
            'imagen'=> null,
            'usuario' => $usuario            
            
        ]);
    }
}
