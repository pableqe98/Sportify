<?php

namespace App\Http\Controllers\Individual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Str;
use App\Usuario;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class EquipoController extends Controller
{
    use UploadTrait;

    public function showEquipos(){

        //Incluir cargar eventos en los que estoy apuntado
        $eqs = DB::table('pertenece_equipo')->select('id_equipo')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();
        $ids=[];
        foreach($eqs as $eq){
            array_push($ids,$eq->id_equipo);
        }

        $equipos = DB::table('equipo')->whereIn('id_equipo', $ids)->get();

        //Busco si tengo alguna solicitud de equipos
        $id_solicitudes = DB::table('invita')->select('id_equipo')->where(['id_individual' => Auth::guard('individual')->user()->id_individual])->get();
        $ids_solicitudes=[];
        foreach($id_solicitudes as $eq){
            array_push($ids_solicitudes,$eq->id_equipo);
        }

        $invitaciones = DB::table('equipo')->whereIn('id_equipo', $ids_solicitudes)->get();

        
        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('individual.mis_equipos',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'mis_equipos' => $equipos,
            'invitaciones' => $invitaciones
        ]);


    }

    public function showCrearEquipo(){

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('individual.crear_equipo',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout'
        ]);
    }

    public function crearEquipo(){

        $this->validate(request(), [
            'nombre' => 'required',
            'foto' => 'required'
        ]);

        DB::transaction(function()
       {
            $individual = Auth::guard('individual')->user();
            $id = $individual->id_individual;
            
            $request = request();

            $nombre=$request['nombre'];
            $descripcion=$request['descripcion'];

           
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

            $id_equipo = DB::table('equipo')->orderBy('id_equipo', 'desc')->first();
            
            if ( $id_equipo == null){
                $id_equipo = $id_equipo + 1;
            }
            else{
                $id_equipo = $id_equipo->id_equipo + 1;
            }
            DB::table('equipo')->insert([
                'id_equipo' => $id_equipo,
                'nombre_equipo' => $nombre,
                'logo_equipo' => $image,
                'descripcion_equipo' => $descripcion,
                'n_miembros' => 1
                ]
            );

            //Ahora apunto al usuario creador, pues al crearlo, automaticamente se inscribe

            DB::table('pertenece_equipo')->insert([
                'id_individual' => $id,
                'id_equipo' => $id_equipo
            ]);

        });

        return $this->showCreationCompleted();
    }

    public function showCreationCompleted(){
        $errors = new MessageBag(['confirmed' => ['Equipo creado']]);

        return redirect()->back()->withErrors($errors)->withInput();
    }

    public function showEquipo($id_equipo){

        //obtengo la información del equipo
        $equipo =  DB::table('equipo')->where(['id_equipo' => $id_equipo])->first();

        //Obtengo los ids de los usuarios que componen el equipo
        $id_jugadores =  DB::table('pertenece_equipo')->select('id_individual')->where(['id_equipo' => $id_equipo])->get();
        $ids=[];
        foreach($id_jugadores as $eq){
            array_push($ids,$eq->id_individual);
        }
        //Obtengo la información de esos usuarios
        $jugadores = DB::table('usuario')->whereIn('id_usuario', $ids)->get();

        //Obtengo todos los usuarios individuales par apoder invitarlos
        $usuarios =  DB::table('usuario')->where(['tipo_u' => 'INDIVIDUAL'])->get();

        $user = Usuario::find(Auth::guard('individual')->user()->id_individual);

        return view('info_equipo',[
            'nombre' => $user->nombre_u,
            'cabecera_sidebar' => 'Menu Usuario',
            'edit_profile' => 'individual.profile',
            'imagen' => Auth::guard('individual')->user()->foto,
            'home' => 'individual.home',
            'logoutRoute' => 'individual.logout',
            'rutaInvitarEquipo' => "individual/invitar-equipo/$id_equipo",
            'rutaDejarEquipo' => 'individual.dejar_equipo',
            'equipo' => $equipo,
            'participantes' => $jugadores,
            'usuarios' => $usuarios
        ]);
    }

    public function invitarEquipo($id){

        $this->validate(request(), [
            'usuario_seleccionado' => 'required'
        ]);

        $request = request();

        $id_usuario = $request['usuario_seleccionado'];

        
        //Si me apunto como usuario individual
        DB::table('invita')->insert([
            'id_equipo' => $id,
            'id_individual' => $id_usuario,
            'confirma' => 'PENDIENTE',
        ]);

        
        return $this->showEquipo($id);
    }

    public function gestionInvitacion($id){

        
        $request = request();

        

        if($request['aceptar']){
            //Modifico la tabla de la invitacion
            DB::table('invita')
            ->where(['id_equipo' => $id,'id_individual' => Auth::guard('individual')->user()->id_individual])
            ->delete();

            //Me añado como participante del equipo
            DB::table('pertenece_equipo')->insert([
                'id_individual' => Auth::guard('individual')->user()->id_individual,
                'id_equipo' => $id
            ]);

            DB::table('equipo')->where('id_equipo', $id)
            ->update([
                'n_miembros' => DB::raw('n_miembros + 1')
            ]);
        }
        elseif($request['negar']){
            //Modifico la tabla de la invitacion
            DB::table('invita')
            ->where(['id_equipo' => $id,'id_individual' => Auth::guard('individual')->user()->id_individual])
            ->delete();


        }

        return $this->showEquipos();
    }

    public function dejarEquipo(){

        DB::transaction(function () {
            $request = request();

            $id_eliminar = $request['id_equipo'];


            $equipo = DB::table('pertenece_equipo')->where([
                'id_equipo' => $id_eliminar,
                'id_individual' => Auth::guard('individual')->user()->id_individual
                ])->delete();

            DB::table('equipo')->where('id_equipo', $id_eliminar)
            ->update([
                'n_miembros' => DB::raw('n_miembros - 1')
            ]);

        });
        
        return $this->showEquipos();

    }

}
