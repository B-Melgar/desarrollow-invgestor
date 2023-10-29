<?php

namespace App\Services;

use App\Models\segrolmodelo;

class segrolservicio
{
    public function get()
    {
        $segrolmodelo = segrolmodelo::get();
        $segrolArray[''] = 'Seleccionar';
        foreach ($segrolmodelo as $roles) {
            $segrolArray[$roles->idrol] = $roles->descripcionrol;
        }
        return $segrolArray;
    }
}