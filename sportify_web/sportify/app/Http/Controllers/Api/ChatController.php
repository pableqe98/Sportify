<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\MensajeGrupo;

class ChatController extends Controller
{
    public function showChats(){

        //Primero debo conseguir los ids de todos mis eventos, de ahi el de los chats
        $id_usuario = Auth::user()->id_individual;
        
        //Incluir cargar eventos en los que estoy apuntado
        $evts = DB::table('participacion_individual')->select('id_evento')->where(['id_individual' => $id_usuario])->get();
        $ids_individuales=[];
        foreach($evts as $evt){
            array_push($ids_individuales,$evt->id_evento);
        }

        //$eventos = DB::table('evento')->whereIn('id_evento', $ids)->get();

        //Busco los equipos
        $ids_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => $id_usuario])->get();
        
        $ids=[];
        foreach($ids_equipos as $tm){
            array_push($ids,$tm->id_equipo);
        }
        //Busco los eventos en los que participan estos equipos
        $ids_eventos = DB::table('participa_en')->select('id_evento')->whereIn('id_equipo', $ids)->get();
        
        $ids_eventos_equipos=[];
        foreach($ids_eventos as $tm){
            array_push($ids_eventos_equipos,$tm->id_evento);
        }
        //$eventos_equipos = DB::table('evento')->whereIn('id_evento', $ids)->get();
        foreach($ids_eventos_equipos as $evento){
            array_push($ids_individuales,$evento);
        }
            
        //En ids_individuales tengo los id de los chats

        $chats=DB::table('grupo_conversacion')->whereIn('id_grupo_conv',$ids_individuales)->get();
        //dd($chats);

        return response()->json(['data' => $chats],200,[], JSON_NUMERIC_CHECK);
    }

    public function showChatConcreto(Request $request){

        $id_grupo_conv = $request['id_grupo_conv'];

        
        $mensajes = DB::table('mensaje_grupo')->where(['id_grupo_conv' => $id_grupo_conv])->orderBy('id_mensaje', 'desc')->get();

        $mensajes_todo=array();
        $i=0;
        foreach($mensajes as $mensaje){
            $usuario = DB::table('usuario')->where(['id_usuario' => $mensaje->id_usuario_emisor])->first();
            $mensajes_todo[$i]['id_mensaje'] = $mensaje->id_mensaje;
            $mensajes_todo[$i]['fecha_m'] = $mensaje->fecha_m;
            $mensajes_todo[$i]['hora_m'] = $mensaje->hora_m;
            $mensajes_todo[$i]['contenido_m'] = $mensaje->contenido_m;
            $mensajes_todo[$i]['nombre_emisor'] = $usuario->nombre_u;
            $mensajes_todo[$i]['foto_usuario'] = $usuario->foto_perf;
            $i++;
        }

        return response()->json(['data' => $mensajes_todo],200,[], JSON_NUMERIC_CHECK);

    }

    public function crearComentario(Request $request){

        $id_usuario = Auth::user()->id_individual;

        $this->validate(request(), [
            'cuerpo_mensaje' => 'required|string',
            'id_grupo_conv' => 'required'
        ]);

       

        $comentario = new MensajeGrupo;

        $comentario->fecha_m = date('Y-m-d');
        $comentario->hora_m = date('H:i:s');
        $comentario->contenido_m = $request['cuerpo_mensaje'];
        $comentario->id_usuario_emisor = $id_usuario;
        $comentario->id_grupo_conv = $request['id_grupo_conv'];;

        $comentario->save();

        $respuesta = "correcto";
        return response()->json($respuesta,200,[], JSON_NUMERIC_CHECK);
    }
}
