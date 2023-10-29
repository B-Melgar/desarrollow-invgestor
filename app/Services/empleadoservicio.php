<?php

namespace App\Services;

use App\Models\empleadomodelo;

class empleadoservicio
{
    public function get()
    {
        $empleadomodelo = empleadomodelo::get();
        $empleadoArray[''] = 'Seleccionar';
        foreach ($empleadomodelo as $empleado) {
            $empleadoArray[$empleado->idempleado] = ($empleado->nombres . ' ' . $empleado->apellidos);
        }
        return $empleadoArray;
    }
}