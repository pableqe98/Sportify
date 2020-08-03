<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
Use Exception; 
use App\Equipamiento;
use DateTime;
use DateInterval;

class EquipamientoController extends Controller
{
    //
    
    public function showEquipamientoReserva($id_evento,$id_entidad,$id_equipamiento){

        $equipamientos =  DB::table('equipamiento')->where(['id_equipamiento' => $id_equipamiento,'id_entidad' => $id_entidad, 'id_evento' => null])->get();

        $tematica = DB::table('tematica')->select('nombre_tematica')->where(['id_tematica' => $equipamientos[0]->id_tematica])->first();

        $entidad = DB::table('entidads')->where(['id_entidad' => $id_entidad])->first();
        
        

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('info_equipamiento',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'equipamientos' => $equipamientos,
            'tematica' => $tematica,
            'entidad' => $entidad,
            'id_evento' => $id_evento
        ]);
    }

    public function accionEquipamientoReservar($id_evento,$id_entidad,$equipamiento){

        $request = request();

        $dia = $request['dia'];
        $hora = $request['hora'];

        DB::table('equipamiento')
        ->where([
            'id_equipamiento' => $equipamiento,
            'dia' => $dia,
            'hora' => $hora,
            'id_entidad' => $id_entidad])
        ->update([
            'id_evento' => $id_evento
        ]);

        return app('App\Http\Controllers\Individual\EventsController')->showEvento($id_evento);
    }
}
