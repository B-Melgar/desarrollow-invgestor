<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\estadoordencompraController;

class estadoordencompramodelo extends Model
{
    protected $table = 'estadoordencompra';
    protected $fillabe = [
        'idestadoordencompra',
        'descripcionordencompra'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idestadoordencompra';
}
