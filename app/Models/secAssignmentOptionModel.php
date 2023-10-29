<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\secAssignmentOptionController;

class secAssignmentOptionModel extends Model
{
    protected $table = 'secAssignmentOption';
    protected $fillabe = [
        'idAssignmentOption',
        'idrol',
        'idOption',
        'status'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idAssignmentOption';

    Public function role(){
        return $this->belongsTo('App\Models\segrolmodelo','idrol');
    }
    Public function options(){
        return $this->belongsTo('App\Models\secOptionsModel','idOption');
    }

}