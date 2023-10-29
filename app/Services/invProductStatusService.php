<?php

namespace App\Services;

use App\Models\productoStatusModel;

class productoStatusService
{
    public function get()
    {
        $statusProduct = productoStatusModel::where('productoStatus.status','=', '1')->get();
        $statusProductArray[''] = 'Seleccionar';
        foreach ($statusProduct as $status) {
            $statusProductArray[$status->estado] = $status->descripcionproductoStatus;
        }
        return $statusProductArray;
    }
}