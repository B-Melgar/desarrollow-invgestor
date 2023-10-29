<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\proveedorFormRequest; //request validacion
use App\Models\proveedormodelo;
use DB;

class proveedorController extends Controller
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
            $proveedor =DB::table('proveedor')
            ->select('proveedor.idproveedor', 'proveedor.nit', 'proveedor.nombreproveedor','proveedor.direccion','proveedor.telefono',
                    'proveedor.correo', 'proveedor.credito', 'proveedor.diascredito',
                    DB::raw('(CASE WHEN proveedor.credito = "1" THEN "Si" ELSE "No" END) AS credito'))
            ->where('proveedor.nit','LIKE', '%'.$query.'%')
            ->orderBy('proveedor.idproveedor', 'desc')->paginate(10);
            return view ('inventario.proveedor.index', ["proveedor"=>$proveedor, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("inventario.proveedor.create");
    }

    //Guardar el objeto a BD para validar
    public function store(proveedorFormRequest $request){
            //nuevo objeto
        $proveedormodelo= new proveedormodelo;
        $proveedormodelo->nit=$request->get('nit');
        $proveedormodelo->nombreproveedor=$request->get('nombreproveedor');
        $proveedormodelo->direccion=$request->get('direccion');
        $proveedormodelo->telefono=$request->get('telefono');
        $proveedormodelo->correo=$request->get('correo');
        $proveedormodelo->credito = (!request()->has('credito') == '1' ? '0' : '1'); 
        $proveedormodelo->diascredito=$request->get('diascredito');
        $proveedormodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/proveedor'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idproveedor){
        return view ('inventario.proveedor.show', ["proveedor"=>proveedormodelo::findorfail($idproveedor)]); //muestra por id de Categoria
    }

    public function edit($idproveedor){
        return view ('inventario.proveedor.edit', ["proveedor"=>proveedormodelo::findorfail($idproveedor)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(proveedorFormRequest $request, $idproveedor){
        $proveedormodelo=proveedormodelo::findorfail($idproveedor);
        $proveedormodelo->nit=$request->get('nit');
        $proveedormodelo->nombreproveedor=$request->get('nombreproveedor');
        $proveedormodelo->direccion=$request->get('direccion');
        $proveedormodelo->telefono=$request->get('telefono');
        $proveedormodelo->correo=$request->get('correo');
        $proveedormodelo->credito = (!request()->has('credito') == '1' ? '0' : '1'); 
        $proveedormodelo->diascredito=$request->get('diascredito');
        $proveedormodelo->update();
        return Redirect::to('inventario/proveedor');
    }
     
    //Eliminar
    public function destroy($idproveedor){
        proveedormodelo::destroy($idproveedor) ;
        return Redirect('inventario/proveedor');
    }
}