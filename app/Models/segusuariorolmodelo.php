<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\segusuariorolController;

class segusuariorolModel extends Model
{
    protected $table = 'segusuariorol';
    protected $fillabe = [
        'idusuariorol',
        'idrol',
        'users_id',
        'estado'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idusuariorol';

    Public function role(){
        return $this->belongsTo('App\Models\segrolmodelo','idrol');
    }
    Public function usuario(){
        return $this->belongsTo('App\Models\segusuariomodeloo','users_id');
    }
}