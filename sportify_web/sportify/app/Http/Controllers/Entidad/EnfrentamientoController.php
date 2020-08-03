<?php

namespace App\Http\Controllers\Entidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
Use Exception; 

class EnfrentamientoController extends Controller
{
    //
    public function showCrearEnfrentamiento($id){
        $request = request();

        $tipo_enfrentamiento = $request['tipo_enfrentamiento'];
        $tipo_participantes = $request['tipo_enfrentamiento'];

        if($tipo_participantes == 'EQUIPO'){
            $participantes_en =  DB::table('participa_en')->where(['id_evento' => $id])->get();
            $ids=[];
            foreach($participantes_en as $p){
                array_push($ids,$p->id_equipo);
            }

            $participantes = DB::table('equipo')->whereIn('id_equipo', $ids)->get();

        }
        else{
            //Tenemos participantes individuales
           $participantes_individual =  DB::table('participacion_individual')->where(['id_evento' => $id])->get();
           $ids=[];
           foreach($participantes_individual as $p){
               array_push($ids,$p->id_individual);
           }

           $participantes = DB::table('usuario')->whereIn('id_usuario', $ids)->get();

        }


        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('crear_enfrentamiento',[
            'nombre' => $user->nombre_u,
            'identificador' => $user->id_usuario,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'volver' => "entidad/evento/$id",
            'evento' => $id,
            'participantes' => $participantes,
            'tipo_enfrentamiento' => $tipo_enfrentamiento,
            'tipo_participantes' => $tipo_participantes
        ]);
    }

    public function crearEnfrentamiento($id){
        $this->validate(request(), [
            'participante1' => 'required',
            'participante2' => 'required',
            'fecha' => 'required',
        ]);

        $request = request();

        $tipo_enfrentamiento = $request['tipo_enfrentamiento'];
        $tipo_participantes = $request['tipo_participantes'];

        $id_participante1 = $request['participante1'];
        $id_participante2 = $request['participante2'];
        $fecha = $request['fecha'];

        if($tipo_participantes == 'EQUIPO'){
            DB::table('enfrentamiento_eq')->insert([
                'participante_1' => $id_participante1,
                'participante_2' => $id_participante2,
                'id_evento' => $id,
                'fecha' => $fecha,
                ]
            );

        }
        else{
            //Tenemos participantes individuales
            DB::table('enfrentamiento_in')->insert([
                'participante_1' => $id_participante1,
                'participante_2' => $id_participante2,
                'id_evento' => $id,
                'fecha' => $fecha,
                ]
            );

        }

        return $this->showCreationCompleted();
    }


    public function showCreationCompleted(){
        $errors = new MessageBag(['confirmed' => ['Enfrentamiento creado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }

    public function showModificarEnfrentamiento($id){

        $request = request();

        $tipo_enfrentamiento = $request['tipo_enfrentamiento'];
        $tipo_participantes = $request['tipo_participantes'];
        $participante1 = $request['particpante1'];
        $participante2 = $request['particpante2'];

        if($tipo_participantes == 'EQUIPO'){
            $participante1 = DB::table('equipo')->where('id_equipo',$participante1)->first();
            $participante2 = DB::table('equipo')->where('id_equipo',$participante2)->first();

        }
        else{
            $participante1 = DB::table('usuario')->where('id_usuario',$participante1)->first();
            $participante2 = DB::table('usuario')->where('id_usuario',$participante2)->first();

        }


        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('modificar_enfrentamiento',[
            'nombre' => $user->nombre_u,
            'identificador' => $user->id_usuario,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'volver' => "entidad/evento/$id",
            'evento' => $id,
            'participante1' => $participante1,
            'participante2' => $participante2,
            'tipo_enfrentamiento' => $tipo_enfrentamiento,
            'tipo_participantes' => $tipo_participantes
            
        ]);

    }

    
    public function modificarEnfrentamiento($id){

        $request = request();

        $tipo_enfrentamiento = $request['tipo_enfrentamiento'];
        $tipo_participantes = $request['tipo_participantes'];

        $puntuacion1 = $request['puntuacion1'];
        $puntuacion2 = $request['puntuacion2'];
        

        $participante1 = $request['participante1'];
        $participante2 = $request['participante2'];

        //Anoto el resultado
        if($tipo_participantes == 'EQUIPO'){
            //Anoto el resultado
            DB::table('enfrentamiento_eq')
            ->where([
                'participante_1' => $participante1,
                'participante_2' => $participante2,
                'id_evento' => $id
            ])
            ->update([
            'puntos_1' => $puntuacion1,
            'puntos_2' => $participante2,
            ]);
        }
        else{
            //Anoto el resultado
            DB::table('enfrentamiento_in')
            ->where([
                'participante_1' => $participante1,
                'participante_2' => $participante2,
                'id_evento' => $id
            ])
            ->update([
            'puntos_1' => $puntuacion1,
            'puntos_2' => $puntuacion2,
            ]);
        }

        if($tipo_enfrentamiento == 'LIGA'){
            if($tipo_participantes == 'EQUIPO')
                
                //Sumo los puntos
                if($puntuacion1 > $puntuacion2){
                    //Ha ganado el participante 1
                    DB::table('participa_en')
                    ->where([
                        'id_equipo' => $participante1,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 3')
                    ]);

                }
                elseif($puntuacion1 < $puntuacion2){
                    //Ha ganado el participante 2
                    DB::table('participa_en')
                    ->where([
                        'id_equipo' => $participante2,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 3')
                    ]);
                }
                elseif($puntuacion1 == $puntuacion2){
                    //Empate
                    DB::table('participa_en')
                    ->where([
                        'id_equipo' => $participante1,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 1')
                    ]);

                    DB::table('participa_en')
                    ->where([
                        'id_equipo' => $participante2,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 1')
                    ]);
                }
            else{
                

                //Sumo los puntos
                if($puntuacion1 > $puntuacion2){
                    //Ha ganado el participante 1
                    DB::table('participacion_individual')
                    ->where([
                        'id_individual' => $participante1,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 3')
                    ]);

                }
                elseif($puntuacion1 < $puntuacion2){
                    //Ha ganado el participante 2
                    DB::table('participacion_individual')
                    ->where([
                        'id_individual' => $participante2,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 3')
                    ]);
                }
                elseif($puntuacion1 == $puntuacion2){
                    //Empate
                    DB::table('participacion_individual')
                    ->where([
                        'id_individual' => $participante1,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 1')
                    ]);

                    DB::table('participacion_individual')
                    ->where([
                        'id_individual' => $participante2,
                        'id_evento' => $id
                    ])
                    ->update([
                        'puntos_e' => DB::raw('puntos_e + 1')
                    ]);
                }
            }

        }
        elseif($tipo_enfrentamiento == 'TORNEO'){
            //Obtengo las nuevas fases
            $fase1 = $request['fase1'];
            $fase2 = $request['fase2'];

            if($tipo_participantes == 'EQUIPO'){

                //Actualizo fase participante 1
                DB::table('participa_en')
                ->where([
                    'id_equipo' => $participante1,
                    'id_evento' => $id
                ])
                ->update([
                    'posicion_e' => $fase1
                ]);

                //Actualizo fase participante 2
                DB::table('participa_en')
                ->where([
                    'id_equipo' => $participante2,
                    'id_evento' => $id
                ])
                ->update([
                    'posicion_e' => $fase2
                ]);

            }
            else{
                //Actualizo fase participante 1
                DB::table('participacion_individual')
                ->where([
                    'id_individual' => $participante1,
                    'id_evento' => $id
                ])
                ->update([
                    'posicion_e' => $fase1
                ]);

                //Actualizo fase participante 2
                DB::table('participacion_individual')
                ->where([
                    'id_individual' => $participante2,
                    'id_evento' => $id
                ])
                ->update([
                    'posicion_e' => $fase2
                ]);
            }

        }
        else{   //Es un evento unico

            if($tipo_participantes == 'EQUIPO'){
                
                //Actualizo  participante 1
                DB::table('participa_en')
                ->where([
                    'id_equipo' => $participante1,
                    'id_evento' => $id
                ])
                ->update([
                    'anotados_e' => DB::raw('anotados_e + '.$puntuacion1)
                ]);

                //Actualizo  participante 2
                DB::table('participa_en')
                ->where([
                    'id_equipo' => $participante2,
                    'id_evento' => $id
                ])
                ->update([
                    'anotados_e' => DB::raw('anotados_e + '.$puntuacion2)
                ]);
            }
            else{
                
                //Actualizo  participante 1
                DB::table('participacion_individual')
                ->where([
                    'id_individual' => $participante1,
                    'id_evento' => $id
                ])
                ->update([
                    'anotados_e' => DB::raw('anotados_e + '.$puntuacion1)
                ]);
    
                //Actualizo  participante 2
                DB::table('participacion_individual')
                ->where([
                    'id_individual' => $participante2,
                    'id_evento' => $id
                ])
                ->update([
                    'anotados_e' => DB::raw('anotados_e + '.$puntuacion2)
                ]);
            }
            
        }

        return $this->showModificationCompleted();
    }



    public function showModificationCompleted(){
        $errors = new MessageBag(['confirmed' => ['Resultado establecido']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }
}
