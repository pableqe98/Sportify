<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipamiento extends Model
{
    //
    public $timestamps = false;
    
    
    protected $table = 'equipamiento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_equipamiento','dia','hora','id_tematica','nombre_e','id_evento','id_entidad' 
    ];
}
