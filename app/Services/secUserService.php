<?php

namespace App\Services;

use App\Models\segusuariomodelo;
use DB;

class segusuarioService
{
    public function get()
    {
        $segusuariomodelo = segusuariomodelo::where('users.status','=', '1')->get();
        // $segusuariomodeloo =DB::table('users')->join('empleado','users.idempleado', '=','empleado.idempleado')
        // ->select('users.id','users.idempleado','empleado.nombres','empleado.apellidos', 'users.email');
        
        $segusuarioArray[''] = 'Seleccionar';
        
        foreach ($segusuariomodelo as $usuario) {
            $segusuarioArray[$usuario->id] =  $usuario->email; //($usuario->names .' '. $usuario->apellidos);
        }
        return $segusuarioArray;
    }
}