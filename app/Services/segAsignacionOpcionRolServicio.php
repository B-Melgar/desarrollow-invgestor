<?php

namespace App\Services;

use App\Models\subcategoriamodelo;
use DB;

class segAsignacionOpcionRolServicio
{
    public function get($idrol,$idmenu)
    {
        $segasignacionopcion =DB::table('segasignacionopcion')
        ->leftJoin('segrol','segasignacionopcion.idrol', '=','segrol.idrol')
        ->leftJoin('segopcion','segasignacionopcion.idopcion', '=','segopcion.idopcion')
        ->leftJoin('segmenu','segopcion.idmenu', '=','segmenu.idmenu')
        ->select('segasignacionopcion.idasignacionopcion', 'segasignacionopcion.idrol', 'segrol.descripcionrol',
                'segasignacionopcion.idopcion', 'segopcion.descripcionopcion', 
                'segopcion.ruta','segopcion.iconoopcion', 'segasignacionopcion.estado',
                'segopcion.idmenu', 'segmenu.descripcionmenu','segmenu.iconomenu')
        ->where('segasignacionopcion.idrol','=', $idrol)  
        ->where('segopcion.idmenu','=', $idmenu)  
        ->where('segasignacionopcion.estado','=', '1')
        ->orderBy('segmenu.orden', 'asc')->get();
        return $segasignacionopcion;
    }
}