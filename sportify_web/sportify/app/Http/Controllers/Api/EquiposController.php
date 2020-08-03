<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EquiposController extends Controller
{
    //
    public function showMyEquipos(){

        $id_usuario = Auth::user()->id_individual;

        //Incluir cargar eventos en los que estoy apuntado
        $eqs = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => $id_usuario])->get();
        $ids=[];
        foreach($eqs as $eq){
            array_push($ids,$eq->id_equipo);
        }

        $equipos = DB::table('equipo')->whereIn('id_equipo', $ids)->get();

        return response()->json(['data' => $equipos],200,[], JSON_NUMERIC_CHECK);

    }
}
