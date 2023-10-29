<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\productoController;

class productomodelo extends Model
{
    protected $table = 'producto';
    protected $fillabe = [
        'idproducto',
        'descripcionproducto',
        'codigoproducto',
        'barcode',
        'idcategoria',
        'idsubcategoria',
        'estado',
        //'unitMeasure',
        'optimalQuantity',
        'photo',
        'freeFieldOne',
        'freeFieldTwo',
        'freeFieldThree',
        'status',
        'idTradeMark',
        'idUnitMeasurement',
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idproducto';

    Public function category(){
        return $this->belongsTo('App\Models\categoriamodelo','idcategoria');
    }
    Public function subcategory(){
        return $this->belongsTo('App\Models\subcategoriamodelo','idsubcategoria');
    }
    Public function Status(){
        return $this->belongsTo('App\Models\productoStatusModel','estado');
    }
    Public function TradeMark(){
        return $this->belongsTo('App\Models\invTradeMarkModel','idTradeMark');
    }
    Public function UnitMeasurement(){
        return $this->belongsTo('App\Models\invUnitMeasurementModel','idUnitMeasurement');
    }
}