<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ordencompraFormRequest; //request validacion
use App\Models\ordencompramodelo;

use DB;
use Carbon\Carbon;


class ordencompraController extends Controller
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
            $_proveedor = trim($request->get('_proveedor'));
            $_estadoorden = trim($request->get('_estadoorden'));
            $ordencompra = null;
            $ordencompra = DB::table('ordencompra')
            ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
            ->leftJoin('empleado','ordencompra.idempleado', '=','empleado.idempleado')
            ->leftJoin('estadoordencompra','ordencompra.idestadoordencompra', '=','estadoordencompra.idestadoordencompra')
            ->select('ordencompra.idordencompra', 'ordencompra.fecha', DB::raw('FORMAT(ordencompra.total,2) as total'),
                    'ordencompra.idproveedor', 'proveedor.nombreproveedor', 'ordencompra.idempleado', 'empleado.nombres', 'empleado.apellidos',
                    'ordencompra.idestadoordencompra', 'estadoordencompra.descripcionordencompra')
            ->where('proveedor.nombreproveedor','LIKE', '%'.$query.'%');
            if (!empty($_proveedor)){
                $ordencompra = $orden->whereRaw('ordencompra.idproveedor = '.$_proveedor);
            } 
            if (!empty($_estadoorden)){
                $ordencompra = $ordencompra->whereRaw('ordencompra.idestadoordencompra = '.$_estadoorden);
            }   
            $ordencompra = $ordencompra->orderBy('ordencompra.idordencompra', 'desc')->paginate(10);
            return view ('inventario.ordencompra.index', ["ordencompra"=>$ordencompra, "searchText"=>$query, "_proveedor"=>$_proveedor, "_estadoorden" =>$_estadoorden]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("inventario.ordencompra.create");
    }

    //Guardar el objeto a BD para validar
    public function store(ordencompraFormRequest $request){
        //nuevo objeto
        $ordencompramodelo= new ordencompramodelo;
        $ordencompramodelo->idempleado=$request->get('idempleado');
        $ordencompramodelo->idproveedor=$request->get('idproveedor');
        $fechaorden = date('Y/m/d');
        $ordencompramodelo->fecha=$fechaorden;
        $ordencompramodelo->total="0.00";
        $ordencompramodelo->idestadoordencompra="1";
        $ordencompramodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/ordencompra'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idordencompra){
        return view ('inventario.ordencompra.show', ["ordencompra"=>ordencompramodelo::findorfail($idordencompra)]); //muestra por id de Categoria
    }

    public function edit($idordencompra){
        //dd("orden " . $idorden);
        $array = ordencompramodelo::findorfail($idordencompra);
        //var_dump($array);
        return view ('inventario.ordencompra.edit', ["ordencompra"=>ordencompramodelo::findorfail($idordencompra)]);//paramtero recibido id
    }
   
    //Actualizar el objeto formulario
    public function update(ordencompraFormRequest $request, $idordencompra){
        $ordencompramodelo=ordencompramodelo::findorfail($idordencompra);
        //dd($request->get('total'));
        $ordencompramodelo->idempleado=$request->get('idempleado');
        $ordencompramodelo->idproveedor=$request->get('idproveedor');
        //$ordencompramodelo->total=$request->get('total');
        $ordencompramodelo->update();
        return Redirect::to('inventario/ordencompra');
    }
     
    //Eliminar
    public function destroy($idordencompra){
        categoriamodelo::destroy($idordencompra);   
        return Redirect('inventario/ordencompra');
    }

    //Llena select o combo sub categorias
    public function getProveedor(Request $request){
        if(isset($request->texto)){
            $proveedor = proveedormodelo::whereidcategoria($request->texto)->get();
            return response()->json(
                [
                    'lista' => $proveedor,
                    'success' => true
                ]);
        }else{
            return response()->json(
            [
                'success' => false
            ]);
        }
    }





}