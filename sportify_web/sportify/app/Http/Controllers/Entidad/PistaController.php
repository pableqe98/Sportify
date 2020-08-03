<?php

namespace App\Http\Controllers\Entidad;

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
    public function showPistas(){

        $pistas = DB::table('pista')->select('id_pista')->where([
            'id_entidad' => Auth::guard('entidad')->user()->id_entidad,
            'id_evento' => null
            ])->groupBy('id_pista')->get();

        

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('entidad.pistas',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'mis_pistas' => $pistas
        ]);


    }

    public function showCrearPista(){

        $tematicas = DB::table('tematica')->get();

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('entidad.crear_pista',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'tematicas' => $tematicas
        ]);
    }

    public function crearPista(){

        
        $this->validate(request(), [
            
            'tematica_elegida' => 'required'
        ]);

        DB::transaction(function()
       {
            $entidad = Auth::guard('entidad')->user();
            $id = $entidad->id_entidad;
            
            $request = request();

            $fecha_ini = DateTime::createFromFormat('Y-m-d H:i:s',$request['fecha_ini'].' 00:00:00');
            
            $fecha_fin = DateTime::createFromFormat('Y-m-d H:i:s',$request['fecha_fin'].' 00:00:00');
            
            $hora_ini = DateTime::createFromFormat('Y-m-d H:i',$request['fecha_ini'].$request['hora_ini']);
            
            $hora_fin = DateTime::createFromFormat('Y-m-d H:i',$request['fecha_ini'].$request['hora_fin']);
            $tematica = $request['tematica_elegida'];
            $n_pista = $request['n_pista'];
            $ubicacion = $request['ubicacion'];
             
            
            //Calculo el numero de dias y de horas
            $diff = $fecha_ini->diff($fecha_fin);
            $dias = $diff->days +1;
            $diff = $hora_ini->diff($hora_fin);
            $horas = $diff->h +1;

            
            //creo las pistas
            for ($i = 1; $i <= $dias; $i++) {
                for ($j = 1; $j <= $horas; $j++){
                    $pista = new Pista;
                    $pista->id_pista = $n_pista;
                    $pista->dia = $fecha_ini;
                    $pista->hora = $hora_ini;
                    $pista->id_evento=null;
                    $pista->id_tematica = $tematica;
                    $pista->ubicacion_pista = $ubicacion;
                    $pista->id_entidad = $id;
                    $pista->save();
                    $hora_ini->add(new DateInterval('PT1H'));
                    }

                $fecha_ini->add(new DateInterval('P1D'));
                $hora_ini = DateTime::createFromFormat('Y-m-d H:i',$fecha_ini->format('Y-m-d').$request['hora_ini']);
            }


       });

       return $this->showCreationCompleted();
    }


    public function showCreationCompleted(){
        $errors = new MessageBag(['confirmed' => ['Pista creada']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }

    public function showPista($id){
        $pistas =  DB::table('pista')->where(['id_pista' => $id])->get();

        $tematica = DB::table('tematica')->select('nombre_tematica')->where(['id_tematica' => $pistas[0]->id_tematica])->first();

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('info_pista',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'pistas' => $pistas,
            'tematica' => $tematica,
            'entidad' => Auth::guard('entidad')->user()
        ]);
    }

}
