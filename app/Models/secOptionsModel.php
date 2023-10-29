<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\secOptionsController;

class secOptionsModel extends Model
{
    protected $table = 'secOptions';
    protected $fillabe = [
        'idOption',
        'idMenu',
        'DescriptionOption',
        'RouteOption',
        'IconOption',
        'status'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idOption';

    Public function menu(){
        return $this->belongsTo('App\Models\secMenuModel','idMenu');
    }
}