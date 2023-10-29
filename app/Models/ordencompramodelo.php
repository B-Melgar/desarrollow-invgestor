<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\ordencompraController;

class ordencompramodelo extends Model
{
    protected $table = 'ordencompra';
    protected $fillabe = [
        'idordencompra',
        'idempleado',
        'idproveedor',
        'fecha',
        'total',
        'idestadoordencompra'
        ];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idordencompra';

    Public function estadoordencompra(){
        return $this->belongsTo('App\Models\estadoordencompramodelo','idestadoordencompra');
    }
}