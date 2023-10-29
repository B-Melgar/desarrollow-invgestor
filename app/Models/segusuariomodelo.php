<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\segusuariorolController;

class segusuariomodelo extends Model
{
    protected $table = 'users';
    protected $fillabe = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'idrol',
        'idempleado',
        'estado'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    Public function empleado(){
        return $this->belongsTo('App\Models\empleadomodelo','idempleado');
    }
    Public function rol(){
        return $this->belongsTo('App\Models\segrolmodelo','idrol');
    }
}