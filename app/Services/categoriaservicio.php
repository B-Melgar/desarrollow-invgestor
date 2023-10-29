<?php

namespace App\Services;

use App\Models\categoriamodelo;

class categoriaservicio
{
    public function get()
    {
        $categorias = categoriamodelo::get();
        $categoriasArray[''] = 'Seleccionar';
        foreach ($categorias as $categoria) {
            $categoriasArray[$categoria->idcategoria] = $categoria->descripcion;
        }
        return $categoriasArray;
    }
}