<?php

namespace App\Services;

use App\Models\estadoordencompramodelo;

class estadoordencompraservicio
{
    public function get()
    {
        $estadoordencompra = estadoordencompramodelo::get();
        $estadoordencompraArray[''] = 'Seleccionar';
        foreach ($estadoordencompra as $estadoorden) {
            $estadoordencompraArray[$estadoorden->idestadoordencompra] = $estadoorden->descripcionordencompra;
        }
        return $estadoordencompraArray;
    }
}