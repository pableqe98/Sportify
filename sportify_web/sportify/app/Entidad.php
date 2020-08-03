<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Node\Expr\FuncCall;

class Entidad extends Authenticatable
{
    use Notifiable;

    
    protected $guard = 'entidad';
    protected $primaryKey = 'id_entidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_entidad','name','direccion_ent', 'email', 'password','foto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getImageAttribute()
    {
        return $this->foto;
    }

}