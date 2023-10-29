<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\empleadoController;

class empleadomodelo extends Model
{
    protected $table = 'empleado';
    protected $fillabe = [
        'idempleado',
        'nombres',
        'apellidos',
        'direccion',
        'telefono',
        'correo'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idempleado';
}