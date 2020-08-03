<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Usuario;
use App\MensajeForo;

class ForoController extends Controller
{
    //

    public function showForos(){

        $foros = DB::table('foro')->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('individual.foros',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'foros' => $foros
        ]);

    }

    public function showForo($id){

        $foro =  DB::table('foro')->where(['id_foro' => $id])->first();

        $mensajes = DB::table('mensaje_foro')->where(['id_foro' => $id])->orderBy('id_mensaje', 'desc')->get();

        foreach($mensajes as $mensaje){
            $usuario = DB::table('usuario')->where(['id_usuario' => $mensaje->id_emisor])->first();
            $mensaje->nombre_usuario = $usuario->nombre_u;
            $mensaje->foto_usuario = $usuario->foto_perf;
        }

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('foro',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'foro' => $foro,
            'mensajes' => $mensajes,
            'rutaForos' => 'individual.foros',
            'rutaComentar' => 'individual.accion_comentar'
        ]);

    }

    public function crearComentario($id){

        $this->validate(request(), [
            'cuerpo_comentario' => 'required|string'
        ]);

        $request = request();

        $comentario = new MensajeForo;

        $comentario->fecha_m = date('Y-m-d');;
        $comentario->hora_m = date('H:i:s');
        $comentario->contenido_m = $request['cuerpo_comentario'];
        $comentario->id_emisor = Auth::guard('individual')->user()->id_individual;
        $comentario->id_foro = $id;

        $comentario->save();


        return $this->showForo($id);
    }


}
