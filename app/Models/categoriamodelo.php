<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\categoriaController;

class categoriamodelo extends Model
{
    protected $table = 'categoria';
    protected $fillabe = [
        'idcategoria',
        'descripcion'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idcategoria';
}
