<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\empleadoFormRequest; //request validacion
use App\Models\empleadomodelo;
use DB;

class empleadoController extends Controller
{
    //Valida usuario logueado
    public function __construct()
    {
        $this -> middleware('auth'); //redirecciona a Login
    }

    //Consulta
    public function index(Request $request){
        if ($request){  
            $query = trim($request->get('searchText'));
            $empleado =DB::table('empleado')
            ->select('empleado.idempleado', 'empleado.nombres', 'empleado.apellidos',
                     'empleado.direccion', 'empleado.telefono', 'empleado.correo')
            ->where('empleado.nombres','LIKE', '%'.$query.'%')    
            ->orderBy('nombres', 'asc')->paginate(10);
            return view ('seguridad.empleado.index', ["empleado"=>$empleado, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("seguridad.empleado.create");
    }

    //Guardar el objeto a BD para validar
    public function store(empleadoFormRequest $request){
            //nuevo objeto
        $empleadomodelo= new empleadomodelo;
        $empleadomodelo->nombres=$request->get('nombres');
        $empleadomodelo->apellidos=$request->get('apellidos');
        $empleadomodelo->direccion=$request->get('direccion');
        $empleadomodelo->telefono=$request->get('telefono');
        $empleadomodelo->correo=$request->get('correo');
        $empleadomodelo->save(); //Guardar o almacenar
        return Redirect::to('seguridad/empleado'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idempleado){
        return view ('seguridad.empleado.show', ["empleado"=>empleadomodelo::findorfail($idempleado)]); //muestra por id de Categoria
    }

    public function edit($idempleado){
        return view ('seguridad.empleado.edit', ["empleado"=>empleadomodelo::findorfail($idempleado)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(empleadoFormRequest $request, $idempleado){
        $empleadomodelo=empleadomodelo::findorfail($idempleado);
        $empleadomodelo->nombres=$request->get('nombres');
        $empleadomodelo->apellidos=$request->get('apellidos');
        $empleadomodelo->direccion=$request->get('direccion');
        $empleadomodelo->telefono=$request->get('telefono');
        $empleadomodelo->correo=$request->get('correo');
        $empleadomodelo->update();
        return Redirect::to('seguridad/empleado');
    }
     
    //Eliminar
    public function destroy($idempleado){      
        empleadomodelo::destroy($idempleado);   
        return Redirect('seguridad/empleado');
    }
}