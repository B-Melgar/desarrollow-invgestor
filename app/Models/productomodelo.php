<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\productoController;

class productomodelo extends Model
{
    protected $table = 'producto';
    protected $fillabe = [
        'idproducto',
        'codigoproducto',
        'descripcionproducto',
        'preciocosto',
        'precioventa',
        'compras',
        'ventas',
        'existencia',
        'photo',
        'idcategoria',
        'idsubcategoria',
        'estado',
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
}