<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','Api\Auth\LoginController@login');
Route::post('refresh','Api\Auth\LoginController@refresh');

Route::middleware('auth:api')->group(function() {

    Route::post('logout','Api\Auth\LoginController@logout');

    Route::get('eventos','Api\EventsController@showEvents');
    Route::get('mis-eventos','Api\EventsController@showMyEvents');
    Route::get('mis-equipos','Api\EquiposController@showMyEquipos');
    Route::post('evento','Api\EventsController@showEvento');
    Route::post('desapuntarse-evento','Api\EventsController@desapuntarseEvento');
    Route::post('apuntarse-evento','Api\EventsController@apuntarseEvento');
    Route::post('equipo','Api\EventsController@obtenerIntegrantesEquipo');
    Route::post('desapuntarse-equipo','Api\EventsController@desapuntarseEquipo');
    Route::get('chats','Api\ChatController@showChats');
    Route::post('chat-concreto','Api\ChatController@showChatConcreto');
    Route::post('publicar-mensaje','Api\ChatController@crearComentario');
});
