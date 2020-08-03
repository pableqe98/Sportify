<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeGrupo extends Model
{
    //
    public $timestamps = false;
    
    protected $primaryKey = 'id_mensaje';
    protected $table = 'mensaje_grupo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_mensaje','fecha_m', 'hora_m', 'contenido_m','id_grupo_conv', 'id_usuario_emisor', 
    ];
}
