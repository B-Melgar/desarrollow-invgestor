<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\productoStatusController;

class productoStatusModel extends Model
{
    protected $table = 'productoStatus';
    protected $fillabe = [
        'descripcionproductoStatus',
        'status'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'estado';
}
