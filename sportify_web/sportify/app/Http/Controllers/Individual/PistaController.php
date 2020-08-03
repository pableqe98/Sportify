<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
Use Exception; 
use App\Pista;
use DateTime;
use DateInterval;

class PistaController extends Controller
{
    //


    public function showPistaReserva($id_evento,$id_entidad,$id_pista){

        $pistas =  DB::table('pista')->where(['id_pista' => $id_pista,'id_entidad' => $id_entidad, 'id_evento' => null])->get();

        $tematica = DB::table('tematica')->select('nombre_tematica')->where(['id_tematica' => $pistas[0]->id_tematica])->first();

        $entidad = DB::table('entidads')->where(['id_entidad' => $id_entidad])->first();
        
        

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('info_pista',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'pistas' => $pistas,
            'tematica' => $tematica,
            'entidad' => $entidad,
            'id_evento' => $id_evento
        ]);
    }

    public function accionPistaReservar($id_evento,$id_entidad,$pista){

        $request = request();

        $dia = $request['dia'];
        $hora = $request['hora'];

        DB::table('pista')
        ->where([
            'id_pista' => $pista,
            'dia' => $dia,
            'hora' => $hora,
            'id_entidad' => $id_entidad])
        ->update([
            'id_evento' => $id_evento
        ]);

        return app('App\Http\Controllers\Individual\EventsController')->showEvento($id_evento);
    }
}
