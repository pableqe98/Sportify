<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Individual extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $guard = 'individual';
    protected $primaryKey = 'id_individual';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_individual','nombre_completo_i','fecha_nac_i', 'email', 'password','foto'
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