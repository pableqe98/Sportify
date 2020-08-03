<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    //
    public $timestamps = false;
    
    protected $primaryKey = 'id_tematica';
    protected $table = 'tematica';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tematica','nombre_tematica' 
    ];
}
