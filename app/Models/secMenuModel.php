<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\secMenuController;

class secMenuModel extends Model
{
    protected $table = 'secMenu';
    protected $fillabe = [
        'idMenu',
        'DescriptionMenu',
        'IconMenu',
        'orden'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idMenu';
}