<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\ordencompraController;

class ordencompradetallemodelo extends Model
{
    protected $table = 'detalleordencompra';
    protected $fillabe = [
        'idordencompra',
        'idproducto',
        'cantidad',
        'precio',
        'subtotal'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'iddetalleordencompra';
}