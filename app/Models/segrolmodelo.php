<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\segrolController;

class segrolmodelo extends Model
{
    protected $table = 'segrol';
    protected $fillabe = [
        'idrol',
        'descripcionrol',
        'estado'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idrol';
}