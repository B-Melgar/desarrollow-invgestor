<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\subcategoriaController;

class subcategoriamodelo extends Model
{
    protected $table = 'subcategoria';
    protected $fillabe = [
        'idsubcategoria',
        'idcategoria',
        'descripcionsubcategoria'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idsubcategoria';

    Public function categoria(){
        return $this->belongsTo('App\Models\categoriamodelo','idcategoria');
    }
}