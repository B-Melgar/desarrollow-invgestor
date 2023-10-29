<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\proveedorController;

class clientemodelo extends Model
{
    protected $table = 'cliente';
    protected $fillabe = [
        'idcliente',
        'nit',
        'nombrecliente',
        'direccion',
        'telefono',
        'correo',
        'credito',
        'diascredito'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idcliente';
}