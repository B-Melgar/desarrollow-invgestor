<?php

namespace App\Services;

use App\Models\productomodelo;

class productoservicio
{
    public function get()
    {
        $productomodelo = productomodelo::where('producto.estado','=', '1')->get();
        $productoArray[''] = 'Seleccionar';
        foreach ($productomodelo as $product) {
            $productoArray[$product->idproducto] = $product->descripcionproducto;
        }
        return $productoArray;
    }
}