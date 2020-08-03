<?php

namespace App\Http\Controllers\Individual;

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

    public function showEvents(){

        //Incluir cargar eventos en los que estoy apuntado
        $evts = DB::table('participacion_individual')->select('id_evento')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();
        $ids=[];
        foreach($evts as $evt){
            array_push($ids,$evt->id_evento);
        }

        $eventos = DB::table('evento')->whereIn('id_evento', $ids)->get();

        //Busco los equipos
        $ids_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();
        
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


        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('individual.mis_eventos',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'mis_eventos' => $eventos
        ]);


    }

    public function showCrearEvento(){

        $tematicas = DB::table('tematica')->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('individual.crear_evento',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
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
            $individual = Auth::guard('individual')->user();
            $id = $individual->id_individual;
            
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

            $id_grupo_conv = DB::table('grupo_conversacion')->orderBy('id_grupo_conv', 'desc')->first();
            $id_grupo_conv = $id_grupo_conv->id_grupo_conv + 1;

            //crear grupo conversacion
            DB::table('grupo_conversacion')->insert([
                'id_grupo_conv' => $id_grupo_conv,
                'nombre_grupo' => "Grupo " . $titulo
            ]);

            $id_evento = DB::table('evento')->orderBy('id_evento', 'desc')->first();
            

            if ( $id_evento == null){
                $id_evento = $id_evento + 1;
            }
            else{
                $id_evento = $id_evento->id_evento + 1;
            }

            if($tipo_participantes == 'INDIVIDUAL'){
                $n_participantes = $n_participantes +1;
            }

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


            //Ahora apunto al usuario creador si es para individual, pues al crearlo, automaticamente se inscribe
            if($tipo_participantes == 'INDIVIDUAL'){
                DB::table('participacion_individual')->insert([
                    'id_individual' => $id,
                    'id_evento' => $id_evento,
                    'anotados_e' => 0,
                    'puntos_e' => 0,
                    'posicion_e' => ''
                ]);
            }

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
        
        //Compruebo si el usuario está apuntado
        $apuntado='no';
        if($tipo_participante=='INDIVIDUAL'){
            foreach($participantes_individual as $part){
                if($part->id_individual == Auth::guard('individual')->user()->id_individual){
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
            $id_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where('id_individual', Auth::guard('individual')->user()->id_individual)->get();

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

        //En caso de que haya, cargo la pista alquilada
        $pista =  DB::table('pista')->where(['id_evento' => $id])->first();
        
        $n_entidad='';
        if($pista != null){
            $n_entidad = DB::table('entidads')->select('name')->where('id_entidad',$pista->id_entidad)->first();
        }

        //En caso de que haya, cargo el equipamiento alquilado
        $equipamiento =  DB::table('equipamiento')->where(['id_evento' => $id])->first();


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

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('info_evento',[
            'nombre' => $user->nombre_u,
            'identificador' => $user->id_usuario,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'rutaApuntarse' => "individual/evento/$id",
            'rutaApuntarEquipo' => "individual/evento-equipo/$id",
            'rutaDesapuntarse' => "individual/desapuntar-evento/$id",
            'rutaChat' => "individual/grupo/$id",
            'rutaPuntuar' => "individual/puntuar/",
            'rutaListaEntidades' => "individual/lista-entidades/$id",
            'rutaCrearEnfrentamiento' => "individual/crear-enfrentamiento/$id",
            'rutaModificarEnfrentamiento' => "individual/modificar-enfrentamiento/$id",
            'edit_evento' => "individual/modificar-evento/$id",
            'evento' => $evento,
            'tematica' => $tematica->nombre_tematica,
            'tipo_integrantes' => $tipo_participante,
            'integrantes' => $participantes,
            'apuntado' => $apuntado,
            'equipos' => $equipos,
            'acabado' => $acabado,
            'empezado' => $empezado,
            'pista' => $pista,
            'entidad_pista' => $n_entidad,
            'equipamiento' => $equipamiento,
            'enfrentamientos' => $enfrentamientos
        ]);
    }

    public function apuntarseEvento($id){

        
        //Si me apunto como usuario individual
        DB::table('participacion_individual')->insert([
            'id_individual' => Auth::guard('individual')->user()->id_individual,
            'id_evento' => $id,
            'anotados_e' => 0,
            'puntos_e' => 0,
            'posicion_e' => ''
        ]);

        //Incremento el numero de apuntados al evento 
        DB::table('evento')
        ->where('id_evento', $id)
        ->update([
            'n_participantes' => DB::raw('n_participantes + 1')
        ]);


        return $this->showEvento($id);
    }

    public function apuntarEquipoEvento($id){

        
        $this->validate(request(), [
            'equipo_seleccionado' => 'required'
        ]);

        $request = request();

        $id_equipo = $request['equipo_seleccionado'];

        
        //Si me apunto como equipo
        DB::table('participa_en')->insert([
            'id_equipo' => $id_equipo,
            'id_evento' => $id,
            'anotados_e' => 0,
            'puntos_e' => 0,
            'posicion_e' => ''
        ]);

        //Incremento el numero de apuntados al evento 
        DB::table('evento')
        ->where('id_evento', $id)
        ->update([
            'n_participantes' => DB::raw('n_participantes + 1')
        ]);


        return $this->showEvento($id);
    }

    public function desapuntarseEvento($id){

        $this->validate(request(), [
            'tipo' => 'required'
        ]);

        $request = request();

        $tipo = $request['tipo'];

        if($tipo == "INDIVIDUAL"){
            DB::table('participacion_individual')->where([
                'id_individual' => Auth::guard('individual')->user()->id_individual,
                'id_evento' => $id
            ])->delete();
        }
        elseif($tipo == "EQUIPO"){
            //Busco los equipos
            $ids_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();
            
            $ids=[];
            foreach($ids_equipos as $tm){
                array_push($ids,$tm->id_equipo);
            }
            
            DB::table('participa_en')
                ->where( 'id_evento', '=', $id)
                ->whereIn('id_equipo', $ids)
                ->delete();
            
        }

        //Decremento el numero de apuntados al evento 
        DB::table('evento')
        ->where('id_evento', $id)
        ->update([
            'n_participantes' => DB::raw('n_participantes - 1')
        ]);

        return $this->showEvento($id);
    }
    
    public function showCalendario()
    {
        $ids_eventos = DB::table('participacion_individual')->select('id_evento')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();

        $ids=[];
        foreach($ids_eventos as $tm){
            array_push($ids,$tm->id_evento);
        }
        
        $eventos = DB::table('evento')->whereIn('id_evento', $ids)->get();

        //Busco los equipos
        $ids_equipos = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();
        
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
        
        //Uno los eventos donde participo individual y como equipo
        $eventos = $eventos->concat($eventos_equipos);

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);
        
        return view('individual.calendario',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'eventos' => $eventos
        ]);
    }

    public function puntuarParticipante($id){

        $this->validate(request(), [
            'nota' => 'required',
            'acumulado' => 'required',
            'evento' => 'required'
        ]);

        $request = request();

        $nota = $request['nota'];
        $acumulado = $request['acumulado'];

        $veces_puntuado = DB::table('valora')->where('id_individual2', $id)->get();

        //Obtengo cuantas veces se ha puntuado al usuario para actualizar la media
        $puntuacion_nueva = intval(($acumulado + $nota) / ($veces_puntuado->count() + 1));

        //Creo esa valoración
        try{
            DB::table('valora')->insert([
                'id_individual1' => Auth::guard('individual')->user()->id_individual,
                'id_individual2' => $id,
                'nota' => $nota,
            ]);
        }catch(Exception $e) {
            //exception handling
            $errors = new MessageBag(['error' => ['Puntuacion no válida']]);

            return redirect()->back()->withErrors($errors)->withInput();
        }

        

        //Actualizo la puntuacion del usuario
        DB::table('usuario')
        ->where('id_usuario', $id)
        ->update([
            'puntuacion' => $puntuacion_nueva
        ]);

        return $this->showEvento($request['evento']);
    }

    public function showListarEntidades($id){

        $this->validate(request(), [
            'tipo_eleccion' => 'required'
        ]);

        $request = request();

        $tipo_eleccion = $request['tipo_eleccion'];
        $evento = $request['evento'];

        if($tipo_eleccion == 'pista'){
            //Busco empresas con pistas de la tematica de este evento
            $ids_entidades = DB::table('pista')->select('id_entidad')->groupBy('id_entidad')->get();    
            $ids=[];
                foreach($ids_entidades as $id_e){
                    array_push($ids,$id_e->id_entidad);
                }
        }
        else{
            //Busco empresas con equipamientos de la tematica de este evento
            $ids_entidades = DB::table('equipamiento')->select('id_entidad')->groupBy('id_entidad')->get();    
            $ids=[];
                foreach($ids_entidades as $id_e){
                    array_push($ids,$id_e->id_entidad);
                }
        }
        $entidades = DB::table('entidads')->whereIn('id_entidad', $ids)->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

       
            return view('seleccion_entidad_reserva',[
                'nombre' => $user->nombre_u,
                'cabecera_sidebar' => 'Menu Usuario',
                'edit_profile' => 'individual.profile',
                'imagen' => Auth::guard('individual')->user()->foto,
                'home' => 'individual.home',
                'logoutRoute' => 'individual.logout',
                'tipo_eleccion' => $tipo_eleccion,
                'entidades' => $entidades,
                'id_evento' => $evento
            ]);
        
    }

    public function showListarPistas($id_evento,$id_entidad){

        $evento = DB::table('evento')->where(['id_evento' => $id_evento])->first();
        $entidad = DB::table('entidads')->where(['id_entidad' => $id_entidad])->first();
        $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();
        //Ahora busco las pistas de esas empresas que sean de la tematica del evento    

            
        $pistas = DB::table('pista')->select('id_pista','id_entidad')
            ->where('id_tematica',$tematica->id_tematica)
            ->where('id_entidad', $id_entidad)
            ->groupBy('id_pista','id_entidad')->get(); 

        
        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('seleccion_pista_reserva',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'pistas' => $pistas,
            'entidad' => $entidad,
            'id_evento' => $evento->id_evento
        ]);
    }

    public function showListarEquipamiento($id_evento,$id_entidad){

        $evento = DB::table('evento')->where(['id_evento' => $id_evento])->first();
        $entidad = DB::table('entidads')->where(['id_entidad' => $id_entidad])->first();
        $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();
        //Ahora busco las pistas de esas empresas que sean de la tematica del evento    

            
        $equipamientos = DB::table('equipamiento')->select('id_equipamiento','id_entidad','nombre_e')
            ->where('id_tematica',$tematica->id_tematica)
            ->where('id_entidad', $id_entidad)
            ->groupBy('id_equipamiento','id_entidad','nombre_e')->get(); 

        
        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('seleccion_equipamiento_reserva',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'equipamientos' => $equipamientos,
            'entidad' => $entidad,
            'id_evento' => $evento->id_evento
        ]);
    }

    public function showEditarEvento($id){
        $evento = DB::table('evento')->where('id_evento',$id)->first();
        $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();

        $tematicas = DB::table('tematica')->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);
        return view('editar_evento',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
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
