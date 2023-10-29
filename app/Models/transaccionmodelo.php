<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\transaccionController;

class transaccionmodelo extends Model
{
    protected $table = 'transaccion';
    protected $fillabe = [
        'idtransaccion',
        'iddepartamento',
        'idtipotransaccion',
        'idempleado',
        'idproveedor',
        'idcliente',
        'fecha',
        'total',
        'idestadotransaccion'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idtipotransaccion';

    Public function tipotransaccion(){
        return $this->belongsTo('App\Models\tipotransaccionamodelo','idtipotransaccion');
    }
    Public function empleado(){
        return $this->belongsTo('App\Models\empleadomodelo','idempleado');
    }
    Public function proveedor(){
        return $this->belongsTo('App\Models\proveedormodelo','idproveedor');
    }
    Public function cliente(){
        return $this->belongsTo('App\Models\clientemodelo','idcliente');
    }
    Public function estadotransaccion(){
        return $this->belongsTo('App\Models\estadotransaccionmodelo','idestadotransaccion');
    }
}