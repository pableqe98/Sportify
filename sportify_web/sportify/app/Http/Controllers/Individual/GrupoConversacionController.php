<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Usuario;
use App\MensajeGrupo;

class GrupoConversacionController extends Controller
{
    //

    

    public function showGrupo($id){

        $grupo =  DB::table('grupo_conversacion')->where(['id_grupo_conv' => $id])->first();

        $mensajes = DB::table('mensaje_grupo')->where(['id_grupo_conv' => $id])->orderBy('id_mensaje', 'desc')->get();

        foreach($mensajes as $mensaje){
            $usuario = DB::table('usuario')->where(['id_usuario' => $mensaje->id_usuario_emisor])->first();
            $mensaje->nombre_usuario = $usuario->nombre_u;
            $mensaje->foto_usuario = $usuario->foto_perf;
        }

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('grupo_conversacion',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'grupo' => $grupo,
            'mensajes' => $mensajes,
            'rutaEvento' => "individual/evento/$id",
            'rutaPublicarComentario' => 'individual.accion_escribir_grupo'
        ]);

    }

    public function crearComentario($id){

        $this->validate(request(), [
            'cuerpo_mensaje' => 'required|string'
        ]);

        $request = request();

        $comentario = new MensajeGrupo;

        $comentario->fecha_m = date('Y-m-d');
        $comentario->hora_m = date('H:i:s');
        $comentario->contenido_m = $request['cuerpo_mensaje'];
        $comentario->id_usuario_emisor = Auth::guard('individual')->user()->id_individual;
        $comentario->id_grupo_conv = $id;

        $comentario->save();


        return $this->showGrupo($id);
    }


}
