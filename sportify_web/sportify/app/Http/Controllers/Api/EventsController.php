<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    //

    public function showEvents(){
        $eventos = DB::table('evento')->get();

        foreach($eventos as $evento){
            $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();
            $evento->tematica = $tematica->nombre_tematica;
        }

        return response()->json(['data' => $eventos],200,[], JSON_NUMERIC_CHECK);
    }

    public function showMyEvents(){
        $id_usuario = Auth::user()->id_individual;
        
        //Incluir cargar eventos en los que estoy apuntado
        $evts = DB::table('participacion_individual')->select('id_evento')->where(['id_individual' => $id_usuario])->get();
        $ids=[];
        foreach($evts as $evt){
            array_push($ids,$evt->id_evento);
        }

        $eventos = DB::table('evento')->whereIn('id_evento', $ids)->get();

        //Busco los equipos
        $ids_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => $id_usuario])->get();
        
        $ids=[];
        foreach($ids_equipos as $tm){
            array_push($ids,$tm->id_equipo);
        }
        //Busco los eventos en los que participan estos equipos
        $ids_eventos = DB::table('participa_en')->select('id_evento')->whereIn('id_equipo', $ids)->get();
        
        $ids=[];
        foreach($ids_eventos as $tm){
            array_push($ids,$tm->id_evento);
        }
        $eventos_equipos = DB::table('evento')->whereIn('id_evento', $ids)->get();
        
        $eventos = $eventos->concat($eventos_equipos);

        foreach($eventos as $evento){
            $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();
            $evento->tematica = $tematica->nombre_tematica;
        }

        return response()->json(['data' => $eventos],200,[], JSON_NUMERIC_CHECK);
    }


    public function showEvento(Request $request){

        $id_usuario = Auth::user()->id_individual;

        $id = $request['id_evento'];
        $evento =  DB::table('evento')->where(['id_evento' => $id])->first();
        //Obtengo le nombre de la tematica
        $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();

        //Obtengo los participantes
        $tipo_participante=$evento->tipo_participantes;

        $participantes_final=array();
       // $participantes_final[0]=array();
        if($tipo_participante=='INDIVIDUAL'){
           //Tenemos participantes individuales
           $participantes_individual =  DB::table('participacion_individual')->where(['id_evento' => $id])->get();
            $ids=[];
            foreach($participantes_individual as $p){
                array_push($ids,$p->id_individual);
            }

            $participantes = DB::table('usuario')->whereIn('id_usuario', $ids)->get();
            
            //Añado 'anotados/puntos/posicon' al participante
            for($i=0 ; $i < $participantes->count() ; $i++){
                //dd(($participantes->get($i))->nombre_u);
               // $participantes_final[$i]=array();
                $participantes_final[$i]['nombre'] = ($participantes->get($i))->nombre_u;
                $participantes_final[$i]['anotados'] = $participantes_individual[$i]->anotados_e;
                $participantes_final[$i]['puntos'] = $participantes_individual[$i]->puntos_e;
                $participantes_final[$i]['posicion'] = $participantes_individual[$i]->posicion_e;
                $participantes_final[$i]['extra'] = ($participantes->get($i))->puntuacion;
            }

        }
        elseif($tipo_participante=='EQUIPO'){
            //Tenemos participantes equipo
            $participantes_en =  DB::table('participa_en')->where(['id_evento' => $id])->get();
            $ids=[];
            foreach($participantes_en as $p){
                array_push($ids,$p->id_equipo);
            }

            $participantes = DB::table('equipo')->whereIn('id_equipo', $ids)->get();
            
            //Añado 'anotados/puntos/posicon' al participante
            for($i=0 ; $i < $participantes->count() ; $i++){
                //$participantes_final[$i]=array();
                $participantes_final[$i]['nombre'] = ($participantes->get($i))->nombre_equipo;
                $participantes_final[$i]['anotados'] = $participantes_en[$i]->anotados_e;
                $participantes_final[$i]['puntos'] = $participantes_en[$i]->puntos_e;
                $participantes_final[$i]['posicion'] = $participantes_en[$i]->posicion_e;
                $participantes_final[$i]['extra'] = ($participantes->get($i))->n_miembros;
            }


        }

        
        
        
        //Compruebo si el usuario está apuntado
        $apuntado='no';
        if($tipo_participante=='INDIVIDUAL'){
            foreach($participantes_individual as $part){
                if($part->id_individual == $id_usuario){
                    $apuntado = 'si';
                    break;
                }
            }
        }

        //Compruebo si aun no está lleno
        if($evento->n_participantes >= $evento->max_participantes){
            $apuntado='lleno';
        }
        
        //Si no estoy apuntado, cargo la lista de mis equipos
        $equipos=null;
        if($tipo_participante == 'EQUIPO'){
            $id_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where('id_individual', $id_usuario)->get();

            $ids=[];
            foreach($id_equipos as $eq){
                array_push($ids,$eq->id_equipo);
            }

            $equipos = DB::table('equipo')->whereIn('id_equipo', $ids)->get();

        }


        //Compruebo si un equipo al que pertenece está apuntado
        if($equipos != null){
            $participaciones =  DB::table('participa_en')->select('id_equipo')->where(['id_evento' => $id])->get();
            foreach($id_equipos as $equipo){
                if($participaciones->contains($equipo)){
                    $apuntado='si';
                }
            }
        }

        $acabado='no';
        if(date('Y-m-d') > $evento->fecha_fin)
            $acabado='si';

        $empezado='no';
        if(date('Y-m-d') >= $evento->fecha_ini)
            $empezado='si';

        

        //Obtengo los enfrentamientos
        if($tipo_participante=='EQUIPO'){
            $enfrentamientos = DB::table('enfrentamiento_eq')->where(['id_evento' => $id])->get();
        }
        else{
            $enfrentamientos = DB::table('enfrentamiento_in')->where(['id_evento' => $id])->get();
        }

        $enfrentamientos_final=array();
        $j=0;
        //$enfrentamientos_final[$j]=array();
        foreach($enfrentamientos as $enfrentamiento){
            if($tipo_participante=='EQUIPO'){
                
                $nombre1= DB::table('equipo')->select('nombre_equipo')->where('id_equipo',$enfrentamiento->participante_1)->first();
                $nombre2= DB::table('equipo')->select('nombre_equipo')->where('id_equipo',$enfrentamiento->participante_2)->first();
                $enfrentamientos_final[$j]['participante_1']=$enfrentamiento->participante_1;
                $enfrentamientos_final[$j]['participante_2']=$enfrentamiento->participante_2;
                $enfrentamientos_final[$j]['id_evento']=$enfrentamiento->id_evento;
                $enfrentamientos_final[$j]['fecha']=$enfrentamiento->fecha;
                $enfrentamientos_final[$j]['puntos_1']=$enfrentamiento->puntos_1;
                $enfrentamientos_final[$j]['puntos_2']=$enfrentamiento->puntos_2;
                $enfrentamientos_final[$j]['nombre1']=$nombre1->nombre_equipo;
                $enfrentamientos_final[$j]['nombre2']=$nombre2->nombre_equipo;
                
            }
            else{
                $nombre1= DB::table('usuario')->select('nombre_u')->where('id_usuario',$enfrentamiento->participante_1)->first();
                $nombre2= DB::table('usuario')->select('nombre_u')->where('id_usuario',$enfrentamiento->participante_2)->first();
                $enfrentamientos_final[$j]['participante_1']=$enfrentamiento->participante_1;
                $enfrentamientos_final[$j]['participante_2']=$enfrentamiento->participante_2;
                $enfrentamientos_final[$j]['id_evento']=$enfrentamiento->id_evento;
                $enfrentamientos_final[$j]['fecha']=$enfrentamiento->fecha;
                $enfrentamientos_final[$j]['puntos_1']=$enfrentamiento->puntos_1;
                $enfrentamientos_final[$j]['puntos_2']=$enfrentamiento->puntos_2;
                $enfrentamientos_final[$j]['nombre1']=$nombre1->nombre_u;
                $enfrentamientos_final[$j]['nombre2']=$nombre2->nombre_u;
                
            }
            $j++;
        }

        $concreto;

        $j=0;
        if(empty($enfrentamientos_final)){
            $enfrentamientos_final[$j]['participante_1']=-1;
            $enfrentamientos_final[$j]['participante_2']=-1;
            $enfrentamientos_final[$j]['id_evento']=-1;
            $enfrentamientos_final[$j]['fecha']="";
            $enfrentamientos_final[$j]['puntos_1']=-1;
            $enfrentamientos_final[$j]['puntos_2']=-1;
            $enfrentamientos_final[$j]['nombre1']="";
            $enfrentamientos_final[$j]['nombre2']="";
            
        }

        if(empty($participantes_final)){
            $participantes_final[$j]['nombre']="";
            $participantes_final[$j]['anotados']=-1;
            $participantes_final[$j]['puntos']=-1;
            $participantes_final[$j]['posicion']="";
            $participantes_final[$j]['extra']=-1;
            
        }

        //dd($enfrentamientos_final);
        $concreto['enfrentamientos'] = $enfrentamientos_final;
        $concreto['empezado'] = $empezado;
        $concreto['acabado'] = $acabado;
        $concreto['apuntado'] = $apuntado;
        $concreto['equipos'] = $equipos;
        $concreto['participantes'] = $participantes_final;
        $concreto['tipo_participante'] = $tipo_participante;

        return response()->json(['data' => $concreto],200,[], JSON_NUMERIC_CHECK);
    }

    public function desapuntarseEvento(Request $request){

        $id_usuario = Auth::user()->id_individual;

        
        $this->validate(request(), [
            'tipo' => 'required',
            'id_evento' => 'required'
        ]);

        $id_evento = $request['id_evento'];
        $tipo = $request['tipo'];

        

        if($tipo == "INDIVIDUAL"){
            DB::table('participacion_individual')->where([
                'id_individual' => $id_usuario,
                'id_evento' => $id_evento
            ])->delete();
        }
        elseif($tipo == "EQUIPO"){
            //Busco los equipos
            $ids_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => $id_usuario])->get();
            
            $ids=[];
            foreach($ids_equipos as $tm){
                array_push($ids,$tm->id_equipo);
            }
            
            DB::table('participa_en')
                ->where( 'id_evento', '=', $id_evento)
                ->whereIn('id_equipo', $ids)
                ->delete();
            
        }

        //Decremento el numero de apuntados al evento 
        DB::table('evento')
        ->where('id_evento', $id_evento)
        ->update([
            'n_participantes' => DB::raw('n_participantes - 1')
        ]);

        $respuesta = "correcto";
        return response()->json($respuesta,200,[], JSON_NUMERIC_CHECK);
    }

    public function apuntarseEvento(Request $request){
        $id_usuario = Auth::user()->id_individual;

        $this->validate(request(), [
            'tipo_participante' => 'required',
            'id_evento' => 'required'
        ]);

        $id_evento = $request['id_evento'];
        $tipo_participante = $request['tipo_participante'];
        $id_equipo = $request['id_equipo'];

        if($tipo_participante == 'INDIVIDUAL'){
            //Me apunto de forma individual
            DB::table('participacion_individual')->insert([
                'id_individual' => $id_usuario,
                'id_evento' => $id_evento,
                'anotados_e' => 0,
                'puntos_e' => 0,
                'posicion_e' => ''
            ]);
    
            //Incremento el numero de apuntados al evento 
            DB::table('evento')
            ->where('id_evento', $id_evento)
            ->update([
                'n_participantes' => DB::raw('n_participantes + 1')
            ]);

        }
        else{
            //Me apunto como equipo
            DB::table('participa_en')->insert([
                'id_equipo' => $id_equipo,
                'id_evento' => $id_evento,
                'anotados_e' => 0,
                'puntos_e' => 0,
                'posicion_e' => ''
            ]);
    
            //Incremento el numero de apuntados al evento 
            DB::table('evento')
            ->where('id_evento', $id_evento)
            ->update([
                'n_participantes' => DB::raw('n_participantes + 1')
            ]);

        }



        $respuesta = "correcto";
        return response()->json($respuesta,200,[], JSON_NUMERIC_CHECK);

    }


    public function obtenerIntegrantesEquipo(Request $request){

        $id_usuario = Auth::user()->id_individual;

        $this->validate(request(), [
            'id_equipo' => 'required'
        ]);

        $id_equipo=$request['id_equipo'];

        //Obtengo los ids de los usuarios que componen el equipo
        $id_jugadores =  DB::table('pertenece_equipo')->select('id_individual')->where(['id_equipo' => $id_equipo])->get();
        $ids=[];
        foreach($id_jugadores as $eq){
            array_push($ids,$eq->id_individual);
        }
        //Obtengo la información de esos usuarios
        $jugadores = DB::table('usuario')->select('nombre_u','email')->whereIn('id_usuario', $ids)->get();

        $jugadores_final=array();
        $i=0;
        foreach($jugadores as $jugador){
           
            $jugadores_final[$i]['nombre_u']=$jugador->nombre_u;
            $jugadores_final[$i]['email']=$jugador->email;

            $i++;
        }

        if(empty($jugadores_final)){
            $jugadores_final[0]['nombre_u']="";
            $jugadores_final[0]['email']="";
            
        }

        //$respuesta['participantes']=$jugadores_final;
        return response()->json(['data' => $jugadores_final],200,[], JSON_NUMERIC_CHECK);
    }

    public function desapuntarseEquipo(Request $request){
        $id_usuario = Auth::user()->id_individual;
   
        $request = request();

        $id_eliminar = $request['id_equipo'];


        $equipo = DB::table('pertenece_equipo')->where([
            'id_equipo' => $id_eliminar,
            'id_individual' => $id_usuario
            ])->delete();

        DB::table('equipo')->where('id_equipo', $id_eliminar)
        ->update([
            'n_miembros' => DB::raw('n_miembros - 1')
        ]);

        $respuesta = "correcto";
        return response()->json($respuesta,200,[], JSON_NUMERIC_CHECK);

    }
}

