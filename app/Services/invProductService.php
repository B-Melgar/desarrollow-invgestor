<?php

namespace App\Services;

use App\Models\productomodelo;

class productoService
{
    public function get()
    {
        $productomodelo = productomodelo::where('producto.status','=', '1')->get();
        $productoArray[''] = 'Seleccionar';
        foreach ($productomodelo as $product) {
            $productoArray[$product->idproducto] = $product->descripcionproducto;
        }
        return $productoArray;
    }
}