<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeForo extends Model
{
 
    public $timestamps = false;
    
    protected $primaryKey = 'id_mensaje';
    protected $table = 'mensaje_foro';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_mensaje','fecha_m', 'hora_m', 'contenido_m','id_emisor', 'id_foro', 
    ];
}
