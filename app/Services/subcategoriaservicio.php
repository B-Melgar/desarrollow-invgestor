<?php

namespace App\Services;

use App\Models\subcategoriamodelo;
use DB;

class subcategoriaservicio
{

    public function get($idcategoria)
    {
        $subcategoria =DB::table('subcategoria')
        ->leftJoin('categoria','subcategoria.idcategoria', '=','categoria.idcategoria')
        ->select('subcategoria.idsubcategoria','subcategoria.descripcionsubcategoria',
                'subcategoria.idcategoria', 'categoria.descripcion')
        ->where('subcategoria.idcategoria','=', $idcategoria)  
        ->orderBy('subcategoria.idcategoria', 'asc')->get();
        return $subcategoria;
    }
}