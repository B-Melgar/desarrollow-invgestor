<?php

namespace App\Services;

use App\Models\clientemodelo;

class clienteservicio
{
    public function get()
    {
        $clientemodelo = clientemodelo::get();
        $clienteArray[''] = 'Seleccionar';
        foreach ($clientemodelo as $cliente) {
            $clienteArray[$cliente->idcliente] = $cliente->nombrecliente;
        }
        return $clienteArray;
    }
}