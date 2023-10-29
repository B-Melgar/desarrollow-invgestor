<?php

namespace App\Services;

use App\Models\subcategoriamodelo;
use DB;

class segAsignacionOpcionServicio
{
    public function get($idrol)
    {
        $segasignacionopcion =DB::table('segopcion')->distinct()
        ->leftJoin('segasignacionopcion','segopcion.idopcion', '=','segasignacionopcion.idopcion')
        ->leftJoin('segmenu','segopcion.idmenu', '=','segmenu.idmenu')
        ->select('segasignacionopcion.idrol', 'segopcion.idmenu', 
                'segmenu.descripcionmenu', 'segmenu.iconomenu', 'segmenu.orden')
        ->where('segasignacionopcion.idrol','=', $idrol)  
        ->where('segopcion.estado','=', '1')
        ->orderBy('segmenu.orden', 'asc')->get();
        return $segasignacionopcion;
    }
}