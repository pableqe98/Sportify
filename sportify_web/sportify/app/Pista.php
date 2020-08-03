<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pista extends Model
{
    //
    public $timestamps = false;
    
    
    protected $table = 'pista';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pista','dia','hora','id_evento','deporte_pista','id_tematica','id_entidad' 
    ];
}
