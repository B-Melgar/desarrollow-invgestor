<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\estadotransaccionFormRequest; //request validacion
use App\Models\estadotransaccionmodelo;
use DB;

class estadotransaccionController extends Controller
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
            $estadotransaccion =DB::table('estadotransaccion')
            ->where('descripcionestadotransaccion','LIKE', '%'.$query.'%')   
            ->orderBy('descripcionestadotransaccion', 'asc')->paginate(10);
            return view ('catalogos.estadotransaccion.index', ["estadotransaccion"=>$estadotransaccion, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.estadotransaccion.create");
    }

    //Guardar el objeto a BD para validar
    public function store(estadotransaccionFormRequest $request){
            //nuevo objeto
        $estadotransaccionmodelo= new estadotransaccionmodelo;
        $estadotransaccionmodelo->descripcionestadotransaccion=$request->get('descripcionestadotransaccion');
        $estadotransaccionmodelo->save(); //Guardar o almacenar
        return Redirect::to('catalogos/estadotransaccion'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idestadotransaccion){
        return view ('catalogos.estadotransaccion.show', ["estadotransaccion"=>estadotransaccionmodelo::findorfail($idestadotransaccion)]); //muestra por id de Categoria
    }

    public function edit($idestadotransaccion){
        return view ('catalogos.estadotransaccion.edit', ["estadotransaccion"=>estadotransaccionmodelo::findorfail($idestadotransaccion)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(estadotransaccionFormRequest $request, $idestadotransaccion){
        $estadotransaccion=estadotransaccionmodelo::findorfail($idestadotransaccion);
        $estadotransaccion->descripcionestadotransaccion=$request->get('descripcionestadotransaccion');
        $estadotransaccion->update();
        return Redirect::to('catalogos/estadotransaccion');
    }
     
    //Eliminar
    public function destroy($idestadotransaccion){
        estadotransaccionmodelo::destroy($idestadotransaccion);    
        return Redirect('catalogos/estadotransaccion');
    }

}