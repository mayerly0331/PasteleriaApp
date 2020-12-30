<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name', 'email', 'password','condicion', 'id_rol'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function rol(){
        return $this->belongsTo('App\Rol');
    }

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
}
