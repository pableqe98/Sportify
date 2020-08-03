<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/pre-login', function () {
    return view('pre-login');
});
Route::get('/pre-register', function () {
    return view('pre-register');
});

Route::get('/eventos-info', function () {
    $eventos = DB::table('evento')->get();
        
    return view('eventos',[
        'eventos' => $eventos
    ]);
});

Route::get('/eventos-info/{id}', function ($id) {
    $evento = DB::table('evento')->where('id_evento',$id)->first();
    $tematica = DB::table('tematica')->where(['id_tematica' => $evento->id_tematica])->first();

    return view('evento_concreto',[
        'evento' => $evento,
        'tematica' => $tematica->nombre_tematica
    ]);
});

/* ----------------------- Individual Routes INI -------------------------------- */

Route::prefix('/individual')->name('individual.')->namespace('Individual')->group(function(){
    
    /**
     * Individual Auth Routes
     */
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Register Routes
        Route::get('/register','RegisterController@showRegistrationForm')->name('register');
        Route::post('/register','RegisterController@register');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

        
    });

    
    Route::get('/dashboard','HomeController@index')->name('home')->middleware('auth:individual');
    
    //Actualización del perfil
    Route::get('/profile','HomeController@showProfile')->name('profile');
    Route::post('/profile','HomeController@update')->name('update');

    //Muestrame mis eventos
    Route::get('/mis-eventos','EventsController@showEvents')->name('mis_eventos')->middleware('auth:individual');

    //Crear evento
    Route::get('/crear-evento','EventsController@showCrearEvento')->name('crear_evento')->middleware('auth:individual');
    Route::post('/crear-evento','EventsController@crearEvento')->name('accion_crear_evento')->middleware('auth:individual');

    //Ver información de evento concreto
    Route::get('/evento/{id}','EventsController@showEvento')->middleware('auth:individual');

    //Ver pagina para modificar el evento
    Route::get('/modificar-evento/{id}','EventsController@showEditarEvento')->middleware('auth:individual');
    //Modificar el evento
    Route::post('/modificar-evento/{id}','EventsController@editarEvento')->middleware('auth:individual');

    //Apuntarse a evento como individual
    Route::post('/evento/{id}','EventsController@apuntarseEvento')->name('apuntarse_evento')->middleware('auth:individual');
    //Apuntarse a evento como equipo
    Route::post('/evento-equipo/{id}','EventsController@apuntarEquipoEvento')->middleware('auth:individual');
    //Apuntarse a evento como individual
    Route::post('/desapuntar-evento/{id}','EventsController@desapuntarseEvento')->middleware('auth:individual');


    //Muestrame mis equipos
    Route::get('/mis-equipos','EquipoController@showEquipos')->name('mis_equipos')->middleware('auth:individual');

    //Crear equipo
    Route::get('/crear-equipo','EquipoController@showCrearEquipo')->name('crear_equipo')->middleware('auth:individual');
    Route::post('/crear-equipo','EquipoController@crearEquipo')->name('accion_crear_equipo')->middleware('auth:individual');
    //Ver información de equipo concreto
    Route::get('/equipo/{id}','EquipoController@showEquipo')->middleware('auth:individual');
    //Dejar Equipo
    Route::post('/equipo','EquipoController@dejarEquipo')->name('dejar_equipo')->middleware('auth:individual');
    //Invitar uuario a equipo
    Route::post('/invitar-equipo/{id}','EquipoController@invitarEquipo')->middleware('auth:individual');
    //Gestion de invitaciones (aceptar o denegar)
    Route::post('/invitaciones/{id}','EquipoController@gestionInvitacion')->middleware('auth:individual');


    //Cargar Calendario Usuario
    Route::get('/calendario','EventsController@showCalendario')->name('ver_calendario')->middleware('auth:individual');

    
    //Muestrame mis amigos
    Route::get('/amigos','AmigosController@showAmigos')->name('mis_amigos')->middleware('auth:individual');
    //Gestion de solicitudes (aceptar o denegar)
    Route::post('/solicitudes/{id}','AmigosController@gestionSolicitud')->middleware('auth:individual');
    //Invitar usuario como amigo
    Route::post('/invitar-amigo','AmigosController@invitarAmigo')->middleware('auth:individual');


    //Ver las tematicas de los foros
    Route::get('/foros','ForoController@showForos')->name('foros')->middleware('auth:individual');
    //Ver foro concreto
    Route::get('/foro/{id}','ForoController@showForo')->middleware('auth:individual');
    Route::post('/foro/{id}','ForoController@crearComentario')->name('accion_comentar')->middleware('auth:individual');

    //Ver chat/grupo concreto
    Route::get('/grupo/{id}','GrupoConversacionController@showGrupo')->middleware('auth:individual');
    Route::post('/grupo/{id}','GrupoConversacionController@crearComentario')->name('accion_escribir_grupo')->middleware('auth:individual');

    ///////////////////////////////////////////////////////

    //Puntuar usuario de evento acabado
    Route::post('/puntuar/{id}','EventsController@puntuarParticipante')->name('accion_puntuar')->middleware('auth:individual');

    ////////////////////////////////////////////////

    //Muestrame las entidades
    Route::get('/lista-entidades/{id}','EventsController@showListarEntidades')->middleware('auth:individual');
    //Muestrame las pistas de cierta entidad
    Route::get('/lista-entidades/{id_evento}/{id_entidad}','EventsController@showListarPistas')->name('mostrar_pistas_entidad')->middleware('auth:individual');
    //Muestrame la pistas de cierta entidad
    Route::get('/lista-entidades/{id_evento}/{id_entidad}/{id_pista}','PistaController@showPistaReserva')->name('reservar_pista')->middleware('auth:individual');
    //Accion de alquilar pista
    Route::post('/lista-entidades/{id_evento}/{id_entidad}/{pista}','PistaController@accionPistaReservar')->name('accion_alquilar_pista')->middleware('auth:individual');

    ///////////////////////////////////////////////

    //Muestrame equipamientos de cierta entidad
    Route::get('/lista-entidades-equipamiento/{id_evento}/{id_entidad}','EventsController@showListarEquipamiento')->name('mostrar_equipamiento_entidad')->middleware('auth:individual');
    //Muestrame equipamiento concreto  de cierta entidad
    Route::get('/lista-entidades-equipamiento/{id_evento}/{id_entidad}/{id_equipamiento}','EquipamientoController@showEquipamientoReserva')->name('reservar_equipamiento')->middleware('auth:individual');
    //Accion de alquilar equipamiento
    Route::post('/lista-entidades-equipamiento/{id_evento}/{id_entidad}/{equipamiento}','EquipamientoController@accionEquipamientoReservar')->name('accion_alquilar_equipamiento')->middleware('auth:individual');


    ///////////////////////////////////////////////////////////////
    
    //Ver crear enfrentamiento de evento concreto
    Route::get('/crear-enfrentamiento/{id}','EnfrentamientoController@showCrearEnfrentamiento')->middleware('auth:individual');
    //Crear enfrentamiento de evento concreto
    Route::post('/crear-enfrentamiento/{id}','EnfrentamientoController@crearEnfrentamiento')->name('accion_crear_enfrentamiento')->middleware('auth:individual');

    //Ver modificar enfrentamiento concreto
    Route::get('/modificar-enfrentamiento/{id}','EnfrentamientoController@showModificarEnfrentamiento')->middleware('auth:individual');
    //Modificar enfrentamiento concreto
    Route::post('/crear-enfrentamiento/{id}','EnfrentamientoController@modificarEnfrentamiento')->name('accion_modificar_enfrentamiento')->middleware('auth:individual');



});

/* ----------------------- Individual Routes FIN -------------------------------- */

/* ----------------------- Admin Routes INI -------------------------------- */
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    
    /**
     * Admin Auth Routes
     */
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Register Routes
        Route::get('/register','RegisterController@showRegistrationForm')->name('register');
        Route::post('/register','RegisterController@register');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

        
    });

    //Put all of your admin routes here...
    Route::get('/dashboard','HomeController@index')->name('home')->middleware('auth:admin');
    
    //Actualización del perfil
    Route::get('/profile','HomeController@showProfile')->name('profile')->middleware('auth:admin');
    
    Route::post('/profile','HomeController@update')->name('update')->middleware('auth:admin');

    /////////////////GESTION ADMINISTRADORES///////////////////////////////////
    
    //Mostrar los administradores
    Route::get('/administradores','AdminController@showAdmins')->name('admins')->middleware('auth:admin');

    //Eliminar el admin elegido
    Route::post('/eliminar','AdminController@eliminarAdmin')->name('eliminar_admin')->middleware('auth:admin');

    ////////////////GESTION TEMATICAS///////////////////////////////
    //Mostrar los administradores
    Route::get('/tematicas','TematicaController@showTematicas')->name('tematicas')->middleware('auth:admin');

    //Eliminar el admin elegido
    Route::post('/eliminar-tematica','TematicaController@eliminarTematica')->name('eliminar_tematica')->middleware('auth:admin');
    //Eliminar el admin elegido
    Route::post('/crear-tematica','TematicaController@crearTematica')->name('crear_tematica')->middleware('auth:admin');


    ////////////////GESTION EVENTOS///////////////////////////////
    //Mostrar los eventos
    Route::get('/eventos','EventsController@showEventos')->name('eventos')->middleware('auth:admin');

    //Eliminar el evento elegido
    Route::post('/eliminar-eventos','EventsController@eliminarEvento')->name('eliminar_evento')->middleware('auth:admin');


    ////////////////GESTION EQUIPOS///////////////////////////////
    //Mostrar los evenequipostos
    Route::get('/equipos','EquipoController@showEquipos')->name('equipos')->middleware('auth:admin');

    //Eliminar el equipo elegido
    Route::post('/eliminar-equipo','EquipoController@eliminarEquipo')->name('eliminar_equipo')->middleware('auth:admin');

    ////////////////GESTION USUARIOS///////////////////////////////
    //Mostrar los usuarios
    Route::get('/usuarios','UsuarioController@showUsuarios')->name('usuarios')->middleware('auth:admin');
    //Mostrar info usuario
    Route::get('/usuario/{id}','UsuarioController@showUsuario')->name('usuario')->middleware('auth:admin');
    //Eliminar el usuario
    Route::post('/eliminar-usuario','UsuarioController@eliminarUsuario')->name('eliminar_usuario')->middleware('auth:admin');

    
  });

  /* ----------------------- Admin Routes FIN -------------------------------- */

  /* ----------------------- Entidad Routes INI -------------------------------- */
Route::prefix('/entidad')->name('entidad.')->namespace('Entidad')->group(function(){
    
    /**
     * Entidad Auth Routes
     */
    Route::namespace('Auth')->group(function(){
        
        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');

        //Register Routes
        Route::get('/register','RegisterController@showRegistrationForm')->name('register');
        Route::post('/register','RegisterController@register');

        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');

        
    });

    //Put all of your admin routes here...
    Route::get('/dashboard','HomeController@index')->name('home')->middleware('auth:entidad');
    
    //Actualización del perfil
    Route::get('/profile','HomeController@showProfile')->name('profile');
    Route::post('/profile','HomeController@update')->name('update');

    /////////////////////////////////////////////////////////////////////////////

    //Muestrame mis eventos
    Route::get('/mis-eventos','EventsController@showEvents')->name('mis_eventos')->middleware('auth:entidad');
    //Crear evento
    Route::get('/crear-evento','EventsController@showCrearEvento')->name('crear_evento')->middleware('auth:entidad');
    Route::post('/crear-evento','EventsController@crearEvento')->name('accion_crear_evento')->middleware('auth:entidad');
    //Ver información de evento concreto
    Route::get('/evento/{id}','EventsController@showEvento')->middleware('auth:entidad');

    //Ver pagina para modificar el evento
    Route::get('/modificar-evento/{id}','EventsController@showEditarEvento')->middleware('auth:entidad');
    //Modificar el evento
    Route::post('/modificar-evento/{id}','EventsController@editarEvento')->middleware('auth:entidad');

    ///////////////////////////////////////////////////////////////////////

    //Cargar Calendario Usuario
    Route::get('/calendario','EventsController@showCalendario')->name('ver_calendario')->middleware('auth:entidad');

    ////////////////////////////////////////////////////////////////////

    //Ver chat/grupo concreto
    Route::get('/grupo/{id}','GrupoConversacionController@showGrupo')->middleware('auth:entidad');
    Route::post('/grupo/{id}','GrupoConversacionController@crearComentario')->name('accion_escribir_grupo')->middleware('auth:entidad');

    ///////////////////////////

    //Ver las tematicas de los foros
    Route::get('/foros','ForoController@showForos')->name('foros')->middleware('auth:entidad');
    //Ver foro concreto
    Route::get('/foro/{id}','ForoController@showForo')->middleware('auth:entidad');
    Route::post('/foro/{id}','ForoController@crearComentario')->name('accion_comentar')->middleware('auth:entidad');

    ///////////////////////////////////////////////////////////////////////

    //Muestrame mis pistas
    Route::get('/mis-pistas','PistaController@showPistas')->name('mis_pistas')->middleware('auth:entidad');
    //Ver información de pista concreta
    Route::get('/pista/{id}','PistaController@showPista')->middleware('auth:entidad');
    //Crear pista
    Route::get('/crear-pista','PistaController@showCrearPista')->name('crear_pista')->middleware('auth:entidad');
    Route::post('/crear-pista','PistaController@crearPista')->name('accion_crear_pista')->middleware('auth:entidad');

    /////////////////////////////////////////////////////////////

    //Muestrame mis equipamientos
    Route::get('/mis-equipamientos','EquipamientoController@showEquipamientos')->name('mis_equipamientos')->middleware('auth:entidad');
    //Ver información de equipamiento concreto
    Route::get('/equipamiento/{id}','EquipamientoController@showEquipamiento')->middleware('auth:entidad');
    //Crear equipamiento
    Route::get('/crear-equipamiento','EquipamientoController@showCrearEquipamiento')->name('crear_equipamiento')->middleware('auth:entidad');
    Route::post('/crear-equipamiento','EquipamientoController@crearEquipamiento')->name('accion_crear_equipamiento')->middleware('auth:entidad');


    ///////////////////////////////////////////////////////////////
    
    //Ver crear enfrentamiento de evento concreto
    Route::get('/crear-enfrentamiento/{id}','EnfrentamientoController@showCrearEnfrentamiento')->middleware('auth:entidad');
    //Crear enfrentamiento de evento concreto
    Route::post('/crear-enfrentamiento/{id}','EnfrentamientoController@crearEnfrentamiento')->name('accion_crear_enfrentamiento')->middleware('auth:entidad');

    //Ver modificar enfrentamiento concreto
    Route::get('/modificar-enfrentamiento/{id}','EnfrentamientoController@showModificarEnfrentamiento')->middleware('auth:entidad');
    //Modificar enfrentamiento concreto
    Route::post('/modificar-enfrentamiento/{id}','EnfrentamientoController@modificarEnfrentamiento')->name('accion_modificar_enfrentamiento')->middleware('auth:entidad');

  });

  /* ----------------------- Entidad Routes FIN -------------------------------- */




Route::get('/home', 'HomeController@index')->name('home');
