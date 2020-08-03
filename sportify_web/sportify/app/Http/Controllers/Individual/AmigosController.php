<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Usuario;

class AmigosController extends Controller
{
    //

    public function showAmigos(){

        //Cargo mis amigos/peticiones
        $amgs = DB::table('es_amigo')
            ->where(['id_usuario1' => Auth::guard('individual')->user()->id_individual])
            ->orWhere(['id_usuario2' => Auth::guard('individual')->user()->id_individual])
            ->get();

        $id_amigos=[];
        $id_solicitudes=[];
        foreach ($amgs as $amigo) {
            if($amigo->confirma_a == 'PENDIENTE'){
                if($amigo->id_usuario1 != Auth::guard('individual')->user()->id_individual)
                    array_push($id_solicitudes,$amigo->id_usuario1);
            }
            elseif($amigo->confirma_a == 'ACEPTADA'){

                if($amigo->id_usuario1 != Auth::guard('individual')->user()->id_individual)
                    array_push($id_amigos,$amigo->id_usuario1);
                elseif($amigo->id_usuario2 != Auth::guard('individual')->user()->id_individual)
                array_push($id_amigos,$amigo->id_usuario2);
            }
        }

        $amigos = DB::table('individuals')
            ->whereIn('id_individual', $id_amigos)
            ->get();
        $solicitudes = DB::table('individuals')
            ->whereIn('id_individual', $id_solicitudes)
            ->get();


        //Obtengo todos los usuarios individuales par apoder invitarlos
        $usuarios =  DB::table('usuario')->where(['tipo_u' => 'INDIVIDUAL'])->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('individual.amigos',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'rutaInvitarAmigo' => "individual/invitar-amigo",
            'mis_amigos' => $amigos,
            'solicitudes' => $solicitudes,
            'usuarios' => $usuarios
        ]);


    }

    public function invitarAmigo(){

        $this->validate(request(), [
            'seleccionado' => 'required'
        ]);

        $request = request();

        $id_usuario = $request['seleccionado'];

        
        //Si me apunto como usuario individual
        DB::table('es_amigo')->insert([
            'id_usuario1' => Auth::guard('individual')->user()->id_individual,
            'id_usuario2' => $id_usuario,
            'confirma_a' => 'PENDIENTE',
        ]);

        
        return $this->showAmigos();
    }

    
    public function gestionSolicitud($id){

        
        $request = request();

        

        if($request['aceptar']){
            //Modifico la tabla de la solicitud
            DB::table('es_amigo')
            ->where(['id_usuario1' => $id,'id_usuario2' => Auth::guard('individual')->user()->id_individual])
            ->update([
                'confirma_a' => 'ACEPTADA'
            ]);

        }
        elseif($request['negar']){
            //Modifico la tabla de la solicitud
            DB::table('es_amigo')
            ->where(['id_usuario1' => $id,'id_usuario2' => Auth::guard('individual')->user()->id_individual])
            ->delete();

        }

        return $this->showAmigos();
    }
}
