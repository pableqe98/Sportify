<?php

namespace App\Http\Controllers\Entidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Str;
use Calendar;
use App\Traits\UploadTrait;
use App\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
Use Exception; 

class EventsController extends Controller
{
    use UploadTrait;
    //
    public function showEvents(){

        $eventos = DB::table('evento')->where('id_usuario_creador', Auth::guard('entidad')->user()->id_entidad)->get();


        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('entidad.mis_eventos',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'mis_eventos' => $eventos
        ]);


    }

    public function showCrearEvento(){

        $tematicas = DB::table('tematica')->get();

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('entidad.crear_evento',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'tematicas' => $tematicas
        ]);
    }

    public function crearEvento(){

        

        $this->validate(request(), [
            'min_participantes' => 'required|lte:max_participantes',
            'max_participantes' => 'required|gte:min_participantes',
            'fecha_ini' => 'required|lte:fecha_fin',
            'fecha_fin' => 'required|gte:fecha_ini',
            'foto' => 'required'
        ]);

        DB::transaction(function()
       {
            $entidad = Auth::guard('entidad')->user();
            $id = $entidad->id_entidad;
            
           $request = request();

           
            if ($request->has('foto')) {
                // Get image file
                $image = $request->file('foto');
                // Make a image name based on user name and current timestamp
                $name = Str::slug($request->input('titulo')).'_'.time();
                // Define folder path
                $folder = '/uploads/images/';
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                // Upload image
                $this->uploadOne($image, $folder, 'public', $name);
                // Set user profile image path in database to filePath
                $image = $filePath;
            }

            $titulo=$request['titulo'];
            $descripcion=$request['descripcion'];
            $fecha_ini=$request['fecha_ini'];
            $fecha_fin=$request['fecha_fin'];
            $tipo_participantes=$request['tipo_part'];
            $min_participantes=$request['min_participantes'];
            $max_participantes=$request['max_participantes'];
            $n_participantes=0;

            if($request['n_participantes'] != 0){
                $n_participantes=$request['n_participantes'];
            }

            $tipo=$request['tipo'];
            $tematica=$request['tematica_elegida'];            

            $id_evento = DB::table('evento')->orderBy('id_evento', 'desc')->first();
            

            if ( $id_evento == null){
                $id_evento = $id_evento + 1;
            }
            else{
                $id_evento = $id_evento->id_evento + 1;
            }

            //crear grupo conversacion
            DB::table('grupo_conversacion')->insert([
                'id_grupo_conv' => $id_evento,
                'nombre_grupo' => "Grupo " . $titulo
            ]);

            DB::table('evento')->insert([
                'id_evento' => $id_evento,
                'titulo_e' => $titulo,
                'descripcion_e' => $descripcion,
                'fecha_ini' => $fecha_ini,
                'fecha_fin' => $fecha_fin,
                'min_participantes' => $min_participantes,
                'max_participantes' => $max_participantes,
                'n_participantes' => $n_participantes,
                'foto' => $image,
                'tipo' => $tipo,
                'latitud' => $request['lat'],
                'longitud' => $request['lng'],
                'estado' => 'ACTIVO',
                'id_grupo_conv' => $id_grupo_conv,
                'id_tematica' => $tematica,
                'id_usuario_creador' => $id,
                'tipo_participantes' => $tipo_participantes
                ]
            );

            //lo guardo en la tabla concreta según el tipo de evento
            $tabla_tipo="";
            $id_tipo="";
            if( $tipo == 'UNICO'){
                $tabla_tipo="unico";
                $id_tipo="id_unico";
            }
            elseif ($tipo == 'LIGA') {
                $tabla_tipo="liga";
                $id_tipo="id_liga";
            }
            else{
                $tabla_tipo="torneo";
                $id_tipo="id_torneo";
            }

            DB::table($tabla_tipo)->insert([
                $id_tipo => $id_evento
            ]);


        });

        return $this->showCreationCompleted();
    }


    public function showCreationCompleted(){
        $errors = new MessageBag(['confirmed' => ['Evento creado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }

    public function showEvento($id){
        $evento =  DB::table('evento')->where(['id_evento' => $id])->first();
            
        //Obtengo le nombre de la tematica
        $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();

        //Obtengo los participantes
        $tipo_participante=$evento->tipo_participantes;

        
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
                
                $participantes[$i]->anotados = $participantes_individual[$i]->anotados_e;
                $participantes[$i]->puntos = $participantes_individual[$i]->puntos_e;
                $participantes[$i]->posicion = $participantes_individual[$i]->posicion_e;
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
                
                $participantes[$i]->anotados = $participantes_en[$i]->anotados_e;
                $participantes[$i]->puntos = $participantes_en[$i]->puntos_e;
                $participantes[$i]->posicion = $participantes_en[$i]->posicion_e;
            }
        }
        
        $apuntado='no';
        if($evento->id_usuario_creador == Auth::guard('entidad')->user()->id_entidad)
            $apuntado='si';

        //Compruebo si aun no está lleno
        if($evento->n_participantes >= $evento->max_participantes){
            $apuntado='lleno';
        }
        

        $acabado='no';
        if(date('Y-m-d') > $evento->fecha_fin)
            $acabado='si';

        //Obtengo los enfrentamientos
        if($tipo_participante=='EQUIPO'){
            $enfrentamientos = DB::table('enfrentamiento_eq')->where(['id_evento' => $id])->get();
            //$ids=[];
           // foreach($ids_enfrentamientos as $p){
          //      array_push($ids,$p->id_enfrentamiento);
         //   }

         //   $enfrentamientos = DB::table('enfrentamientos_eq')->whereIn('', $ids)->get();
        }
        else{
            $enfrentamientos = DB::table('enfrentamiento_in')->where(['id_evento' => $id])->get();
          //  $ids=[];
          //  foreach($ids_enfrentamientos as $p){
          //      array_push($ids,$p->id_enfrentamiento);
         //   }

         //   $enfrentamientos = DB::table('enfrentamientos_in')->whereIn('id_equipo', $ids)->get();
        }

        foreach($enfrentamientos as $enfrentamiento){
            if($tipo_participante=='EQUIPO'){
                $nombre1= DB::table('equipo')->select('nombre_equipo')->where('id_equipo',$enfrentamiento->participante_1)->first();
                $nombre2= DB::table('equipo')->select('nombre_equipo')->where('id_equipo',$enfrentamiento->participante_2)->first();
                $enfrentamiento->nombre1=$nombre1->nombre_equipo;
                $enfrentamiento->nombre2=$nombre2->nombre_equipo;
            }
            else{
                $nombre1= DB::table('usuario')->select('nombre_u')->where('id_usuario',$enfrentamiento->participante_1)->first();
                $nombre2= DB::table('usuario')->select('nombre_u')->where('id_usuario',$enfrentamiento->participante_2)->first();
                $enfrentamiento->nombre1=$nombre1->nombre_u;
                $enfrentamiento->nombre2=$nombre2->nombre_u;
            }
        }

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);

        return view('info_evento',[
            'nombre' => $user->nombre_u,
            'identificador' => $user->id_usuario,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'rutaApuntarse' => "",
            'rutaApuntarEquipo' => "",
            'rutaDesapuntarse' => "",
            'rutaChat' => "entidad/grupo/$id",
            'rutaPuntuar' => "",
            'rutaCrearEnfrentamiento' => "entidad/crear-enfrentamiento/$id",
            'rutaModificarEnfrentamiento' => "entidad/modificar-enfrentamiento/$id",
            'edit_evento' => "entidad/modificar-evento/$id",
            'evento' => $evento,
            'tematica' => $tematica->nombre_tematica,
            'tipo_integrantes' => $tipo_participante,
            'integrantes' => $participantes,
            'apuntado' => $apuntado,
            'equipos' => "",
            'acabado' => $acabado,
            'enfrentamientos' => $enfrentamientos

        ]);
    }

    public function showCalendario()
    {
        
        $eventos = DB::table('evento')->where('id_usuario_creador', Auth::guard('entidad')->user()->id_entidad)->get();

        
        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);
        
        return view('entidad.calendario',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'eventos' => $eventos
        ]);
    }

    public function showEditarEvento($id){
        $evento = DB::table('evento')->where('id_evento',$id)->first();
        $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();

        $tematicas = DB::table('tematica')->get();

        $user = Usuario::find(Auth::guard('entidad')->user()->id_entidad);
        return view('editar_evento',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'entidad.profile',
            'imagen' => Auth::guard('entidad')->user()->foto,
            'home' => 'entidad.home',
            'logoutRoute' => 'entidad.logout',
            'evento' => $evento,
            'tematicas' => $tematicas
            
        ]);
    }

    public function editarEvento($id){
        
        $request = request();

        $titulo = $request['titulo'];
        $descripcion = $request['descripcion'];
        $fecha_ini = $request['fecha_ini'];
        $fecha_fin = $request['fecha_fin'];
        $tipo_part = $request['tipo_part'];
        $foto = $request['foto'];   
        $tipo = $request['tipo'];
        $tematica_elegida = $request['tematica_elegida'];

        if($foto != null){
            // Get image file
            $image = $request->file('foto');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('titulo')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $image = $filePath;

            DB::table('evento')->where('id_evento',$id)
                ->update([
                    'titulo_e' => $titulo,
                    'descripcion_e' => $descripcion,
                    'fecha_ini' => $fecha_ini,
                    'fecha_fin' => $fecha_fin,
                    'foto' => $image,
                    'tipo' => $tipo,
                    'tipo_participantes' => $tipo_part,
                    'id_tematica' => $tematica_elegida
                ]);

        }
        else{
            DB::table('evento')->where('id_evento',$id)
                ->update([
                    'titulo_e' => $titulo,
                    'descripcion_e' => $descripcion,
                    'fecha_ini' => $fecha_ini,
                    'fecha_fin' => $fecha_fin,
                    'tipo' => $tipo,
                    'tipo_participantes' => $tipo_part,
                    'id_tematica' => $tematica_elegida
                ]);
        }

        return $this->showEvento($id);
    }
}
