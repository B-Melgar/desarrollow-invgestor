<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\tipotransaccionController;

class tipotransaccionmodelo extends Model
{
    protected $table = 'tipotransaccion';
    protected $fillabe = [
        'idtipotransaccion',
        'descripciontipotransaccion'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idtipotransaccion';
}
