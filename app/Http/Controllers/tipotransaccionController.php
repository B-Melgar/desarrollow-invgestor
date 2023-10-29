<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\tipotransaccionFormRequest; //request validacion
use App\Models\tipotransaccionmodelo;
use DB;

class tipotransaccionController extends Controller
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
            $tipotransaccion =DB::table('tipotransaccion')
            ->where('descripciontipotransaccion','LIKE', '%'.$query.'%')   
            ->orderBy('descripciontipotransaccion', 'asc')->paginate(10);
            return view ('catalogos.tipotransaccion.index', ["tipotransaccion"=>$tipotransaccion, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.tipotransaccion.create");
    }

    //Guardar el objeto a BD para validar
    public function store(tipotransaccionFormRequest $request){
            //nuevo objeto
        $tipotransaccionmodelo= new tipotransaccionmodelo;
        $tipotransaccionmodelo->descripciontipotransaccion=$request->get('descripciontipotransaccion');
        $tipotransaccionmodelo->save(); //Guardar o almacenar
        return Redirect::to('catalogos/tipotransaccion'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idtipotransaccion){
        return view ('catalogos.tipotransaccion.show', ["tipotransaccion"=>tipotransaccionmodelo::findorfail($idtipotransaccion)]); //muestra por id de Categoria
    }

    public function edit($idtipotransaccion){
        return view ('catalogos.tipotransaccion.edit', ["tipotransaccion"=>tipotransaccionmodelo::findorfail($idtipotransaccion)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(tipotransaccionFormRequest $request, $idtipotransaccion){
        $tipotransaccion=tipotransaccionmodelo::findorfail($idtipotransaccion);
        $tipotransaccion->descripciontipotransaccion=$request->get('descripciontipotransaccion');
        $tipotransaccion->update();
        return Redirect::to('catalogos/tipotransaccion');
    }
     
    //Eliminar
    public function destroy($idtipotransaccion){
        tipotransaccionmodelo::destroy($idtipotransaccion);    
        return Redirect('catalogos/tipotransaccion');
    }

}