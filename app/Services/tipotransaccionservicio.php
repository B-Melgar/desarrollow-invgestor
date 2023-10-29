<?php

namespace App\Services;

use App\Models\tipotransaccionmodelo;

class tipotransaccionservicio
{
    public function get()
    {
        $tipotransaccion = tipotransaccionmodelo::get();
        $tipotransaccionArray[''] = 'Seleccionar';
        foreach ($tipotransaccion as $ttransaccion) {
            $tipotransaccionArray[$ttransaccion->idcategoria] = $ttransaccion->descripciontipotransaccion;
        }
        return $tipotransaccionArray;
    }
}