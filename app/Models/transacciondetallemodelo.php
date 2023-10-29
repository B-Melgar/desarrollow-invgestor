<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\transaccionController;

class transacciondetallemodelo extends Model
{
    protected $table = 'detalletransaccion';
    protected $fillabe = [
        'iddetalletransaccion',
        'idtransaccion',
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
    protected $primaryKey = 'iddetalletransaccion';

    Public function transaccion(){
        return $this->belongsTo('App\Models\transaccionmodelo','idtransaccion');
    }
    Public function producto(){
        return $this->belongsTo('App\Models\productomodelo','idproducto');
    }
}