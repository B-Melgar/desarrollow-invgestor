<?php

namespace App\Services;

use App\Models\proveedormodelo;

class proveedorservicio
{
    public function get()
    {
        $proveedormodelo = proveedormodelo::get();
        $proveedorArray[''] = 'Seleccionar';
        foreach ($proveedormodelo as $proveedor) {
            $proveedorArray[$proveedor->idproveedor] = $proveedor->nombreproveedor;
        }
        return $proveedorArray;
    }
}