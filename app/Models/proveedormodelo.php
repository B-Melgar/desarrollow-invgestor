<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\proveedorController;

class proveedormodelo extends Model
{
    protected $table = 'proveedor';
    protected $fillabe = [
        'idproveedor',
        'nit',
        'nombreproveedor',
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
    protected $primaryKey = 'idproveedor';
}