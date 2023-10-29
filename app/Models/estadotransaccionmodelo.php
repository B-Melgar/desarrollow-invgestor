<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\estadotransaccionController;

class estadotransaccionmodelo extends Model
{
    protected $table = 'estadotransaccion';
    protected $fillabe = [
        'idestadotransaccion',
        'descripcionestadotransaccion'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idestadotransaccion';
}
