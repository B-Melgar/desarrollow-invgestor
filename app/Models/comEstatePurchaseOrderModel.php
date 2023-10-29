<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Auth\comEstatePurchaseOrderController;

class comEstatePurchaseOrderModel extends Model
{
    protected $table = 'comEstatePurchaseOrder';
    protected $fillabe = [
        'idEstatePurchaseOrder',
        'descriptionPurchaseOrder',
        'status'];

    /**
    * The primary key for the model.
    *
    * @var string
    */
    protected $primaryKey = 'idEstatePurchaseOrder';
}