<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    

    
    protected $primaryKey = 'id_usuario';
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password','nombre_u', 'descripcion_u', 'foto_perf','tlf_u', 'email','tipo_u','puntuacion', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
