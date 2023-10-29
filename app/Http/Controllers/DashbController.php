<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

//se agrega modelo
use Illuminate\Support\Facades\Redirect;

//mencionamos el formulario a utilizar y su ubicación
//use DB;


class DashbController extends Controller
{
	//constructor se usa para validar acceso
    public function __construct()
    {
		$this -> middleware('auth'); //redirecciona a Login
    }

        public function index(Request $request)
    {
    	if ($request) //si existe obtener registros de BD
		{
			return view ('admin.dash.index');
    		}
    }

        //Mostrar
        public function show()
    {
    		return view ('admin.dash.show'); //muestra por id de grado

    }

}
