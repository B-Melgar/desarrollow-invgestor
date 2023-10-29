<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\transaccionFormRequest; //request validacion
use App\Models\transaccionmodelo;
use App\Models\categoriamodelo;
use App\Models\subcategoriamodelo;

use DB;
use Carbon\Carbon;


class transaccioncompraController extends Controller
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
            $_estadotransaccion = trim($request->get('_estadotransaccion'));
            $transaccion = null;
            $transaccion = DB::table('transaccion')
            ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
            ->leftJoin('empleado','transaccion.idempleado', '=','empleado.idempleado')
            ->leftJoin('tipotransaccion','transaccion.idtipotransaccion', '=','tipotransaccion.idtipotransaccion')
            ->leftJoin('estadotransaccion','transaccion.idestadotransaccion', '=','estadotransaccion.idestadotransaccion')
            ->select('transaccion.idtransaccion', 'transaccion.fecha', DB::raw('FORMAT(transaccion.total,2) as total'),
                    'transaccion.idproveedor', 'proveedor.nombreproveedor', 'transaccion.idempleado', 'empleado.nombres', 'empleado.apellidos',
                    'transaccion.idtipotransaccion', 'tipotransaccion.descripciontipotransaccion',
                    'transaccion.idestadotransaccion', 'estadotransaccion.descripcionestadotransaccion')
            ->where('proveedor.nombreproveedor','LIKE', '%'.$query.'%');
            if (!empty($_proveedor)){
                $transaccion = $transaccion->whereRaw('transaccion.idproveedor = '.$_proveedor);
            } 
            if (!empty($_estadotransaccion)){
                $transaccion = $transaccion->whereRaw('transaccion.idestadotransaccion = '.$_estadotransaccion);
            }   
            $transaccion = $transaccion->orderBy('transaccion.idtransaccion', 'desc')->paginate(10);
            return view ('inventario.transaccioncompra.index', ["transaccion"=>$transaccion, "searchText"=>$query, "_proveedor"=>$_proveedor, "_estadotransaccion" =>$_estadotransaccion]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("inventario.transaccioncompra.create");
    }

    //Guardar el objeto a BD para validar
    public function store(transaccionFormRequest $request){
        //nuevo objeto
        $transaccionmodelo= new transaccionmodelo;
        //$transaccionmodelo->iddepartamento="";
        $transaccionmodelo->idtipotransaccion="1";
        $transaccionmodelo->idempleado=$request->get('idempleado');
        $transaccionmodelo->idproveedor=$request->get('idproveedor');
        //$transaccionmodelo->idcliente="";
        $fechaTransaccion = date('Y/m/d');
        $transaccionmodelo->fecha=$fechaTransaccion;
        $transaccionmodelo->total="0.00";
        $transaccionmodelo->idestadotransaccion="1";
        $transaccionmodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/transaccioncompra'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idtransaccion){
        return view ('inventario.transaccioncompra.show', ["transaccion"=>transaccionmodelo::findorfail($idtransaccion)]); //muestra por id de Categoria
    }

    public function edit($idtransaccion){
        return view ('inventario.transaccioncompra.edit', ["transaccion"=>transaccionmodelo::findorfail($idtransaccion)]);//paramtero recibido id
    }

   
    //Actualizar el objeto formulario
    public function update(transaccionFormRequest $request, $idtransaccion){
        $transaccionmodelo=transaccionmodelo::findorfail($idtransaccion);
        //$transaccionmodelo->iddepartamento="";
        //$transaccionmodelo->idtipotransaccion="1";
        $transaccionmodelo->idempleado=$request->get('idempleado');
        $transaccionmodelo->idproveedor=$request->get('idproveedor');
        //$transaccionmodelo->idcliente="";
        //$transaccionmodelo->fecha=$request->get('fecha');
        $transaccionmodelo->total=$request->get('total');
        $transaccionmodelo->idestadotransaccion=$request->get('idestadotransaccion');
        $transaccionmodelo->update();
        return Redirect::to('inventario/transaccioncompra');
    }
     
    //Eliminar
    public function destroy($idtransaccion){
        $estado = '1';
        DB::table('transaccion')->where('idtransaccion', $idtransaccion)->update(array('idestadotransaccion' => $estado));  
        return Redirect('inventario/transaccioncompra');
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