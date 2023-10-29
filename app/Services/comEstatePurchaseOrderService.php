<?php

namespace App\Services;

use App\Models\comEstatePurchaseOrderModel;

class comEstatePurchaseOrderService
{
    public function get()
    {
        $comEstatePurchaseOrderModel = comEstatePurchaseOrderModel::where('comEstatePurchaseOrder.status','=', '1')->get();
        $comEstatePurchaseOrderArray[''] = 'Seleccionar';
        foreach ($comEstatePurchaseOrderModel as $estadoorden) {
            $comEstatePurchaseOrderArray[$estadoorden->idEstatePurchaseOrder] = $estadoorden->descriptionPurchaseOrder;
        }
        return $comEstatePurchaseOrderArray;
    }
}