<?php

namespace App\Services;

use App\Models\estadotransaccionmodelo;

class estadotransaccionservicio
{
    public function get()
    {
        $estadotransaccion = estadotransaccionmodelo::get();
        $estadotransaccionArray[''] = 'Seleccionar';
        foreach ($estadotransaccion as $ttransaccion) {
            $estadotransaccionArray[$ttransaccion->idestadotransaccion] = $ttransaccion->descripcionestadotransaccion;
        }
        return $estadotransaccionArray;
    }
}