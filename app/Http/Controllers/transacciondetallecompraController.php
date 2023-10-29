<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\transacciondetalleFormRequest; //request validacion
use App\Models\transacciondetallemodelo;
use App\Models\transaccionmodelo;
use App\Models\productomodelo;

use DB;
use Carbon\Carbon;


class transacciondetallecompraController extends Controller
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
            $_producto = trim($request->get('_producto'));
            $transacciondetalle = null;
            $transacciondetalle = DB::table('detalletransaccion')
            ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
            ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                    'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 'detalletransaccion.subtotal')
            ->where('producto.descripcionproducto','LIKE', '%'.$query.'%');
            if (!empty($_producto)){
                $transacciondetalle = $transacciondetalle->whereRaw('detalletransaccion.idproducto = '.$_producto);
            }  
            $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);
            return view ('inventario.detalletransaccion.index', ["detalletransaccion"=>$detalletransaccion, "searchText"=>$query, "_producto"=>$_producto]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("inventario.detalletransaccion.create");
    }

    //Guardar el objeto a BD para validar
    public function store(detalletransaccionFormRequest $request){
        //nuevo objeto
        $detalletransaccionmodelo= new detalletransaccionmodelo;
        $detalletransaccionmodelo->idordencompra=$request->get('idordencompra');
        $detalletransaccionmodelo->idordencompra=$request->get('idproducto');
        $detalletransaccionmodelo->cantidad=$request->get('cantidad');
        $detalletransaccionmodelo->precio=$request->get('precio');
        $detalletransaccionmodelo->subtotal=$request->get('subtotal');
        $detalletransaccionmodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/detalletransaccion'); //retorna al usuario a listado de grados a URL	
    }

    public function show($iddetalletransaccion){
        return view ('inventario.detalletransaccion.show', ["detalletransaccion"=>detalletransaccionmodelo::findorfail($iddetalletransaccion)]); //muestra por id de Categoria
    }
   
    //Actualizar el objeto formulario
    public function update(transaccionFormRequest $request, $iddetalletransaccion){
        $detalletransaccionmodelo=detalletransaccionmodelo::findorfail($iddetalletransaccion);
        $detalletransaccionmodelo->idtransaccion=$request->get('idtransaccion');
        $detalletransaccionmodelo->idproducto=$request->get('idproducto');
        $detalletransaccionmodelo->cantidad=$request->get('cantidad');
        $detalletransaccionmodelo->precio=$request->get('precio');
        $detalletransaccionmodelo->subtotal=$request->get('subtotal');
        $detalletransaccionmodelo->update();
        return Redirect::to('inventario/detalletransaccion');
    }
     
    //Eliminar
    public function destroy($iddetalletransaccion){
        detalletransaccionmodelo::destroy($iddetalletransaccion);    
        return Redirect('inventario/detalletransaccion');
    }

    //Llena select o combo productos
    public function getProducto(Request $request){
        if(isset($request->texto)){
            $producto = productomodelo::whereidproducto($request->texto)->get();
            return response()->json(
                [
                    'lista' => $producto,
                    'success' => true
                ]);
        }else{
            return response()->json(
            [
                'success' => false
            ]);
        }
    }



    public function edit(Request $request){
        $detalletransaccionmodelo = new transacciondetallemodelo;
        //dd($request->get('idtransaccion'));
        $idtransaccion = $request->get('idtransaccion');
        $detalletransaccionmodelo->idtransaccion=$request->get('idtransaccion');
        $detalletransaccionmodelo->idproducto=$request->get('idproducto');
        $detalletransaccionmodelo->cantidad=$request->get('cantidad');
        $detalletransaccionmodelo->precio=$request->get('precio');
        $detalletransaccionmodelo->subtotal=$request->get('subtotal');
        $detalletransaccionmodelo->save(); //Guardar o almacenar
        

        $transacciondetalle = null;
        $transacciondetalle = DB::table('detalletransaccion')
        ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
        ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
        ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 
                'detalletransaccion.subtotal', DB::raw('DATE_FORMAT(transaccion.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor','transaccion.idestadotransaccion')
        ->where('detalletransaccion.idtransaccion','=', $idtransaccion);
        $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);

        $fechatransaccion = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadotransaccion = 0;
        foreach ($transacciondetalle as $detalle) {
            $fechatransaccion =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadotransaccion =  $detalle->idestadotransaccion;
        }
        $msgbox = '';
        $data = array(
            'fechatransaccion'=>$fechatransaccion,
            'idtransaccion'=>$idtransaccion,
            'msg'=> $msgbox,
            'idestadotransaccion'=> $idestadotransaccion,
        );
        
        return view ('inventario.transaccioncompra.listadetalletransaccioncompra', ["transacciondetalle"=>$transacciondetalle, "searchText" =>$idtransaccion])->with($data);
    }

    //BORRAR DETALLE DE COMPRA
    public function borrardetallecompra(Request $request){
        $transacciondetallemodelo = new transacciondetallemodelo;
        $iddetalletransaccion=$request->get('iddetalletransaccion');
        $transacciondetallemodelo = transacciondetallemodelo::find($iddetalletransaccion); 
        $transacciondetallemodelo->delete();

        $transacciondetalle = null;
        $transacciondetalle = DB::table('detalletransaccion')
        ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
        ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
        ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 
                'detalletransaccion.subtotal', DB::raw('DATE_FORMAT(transaccion.fecha, "%d/%m/%Y") AS fecha'),  'proveedor.nombreproveedor','transaccion.idestadotransaccion')
        ->where('detalletransaccion.idtransaccion','=', $idtransaccion);
        $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);

        $fechatransaccion = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadotransaccion = 0;
        foreach ($transacciondetalle as $detalle) {
            $fechatransaccion =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadotransaccion = $detalle->idestadotransaccion;
        }

        $msgbox = '';
        $data = array(
            'fechatransaccion'=>$fechatransaccion,
            'idtransaccion'=>$idtransaccion,
            'msg'=> $msgbox,
            'nombreproveedor'=> $nombreproveedor,
            'idestadotransaccion'=> $idestadotransaccion,
        );
        
        return view ('inventario.transaccioncompra.listadetalletransaccioncompra', ["transacciondetalle"=>$transacciondetalle, "searchText" =>$idtransaccion])->with($data);
    }

    public function detalletransacciondata($idtransaccion){
        //dd($idtransaccion);
        if (isset($idtransaccion)){  
            $transacciondetalle = null;
            $transacciondetalle = DB::table('detalletransaccion')
            ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
            ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
            ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
            ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                    'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 
                    'detalletransaccion.subtotal', DB::raw('DATE_FORMAT(transaccion.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor','transaccion.idestadotransaccion')
            ->where('detalletransaccion.idtransaccion','=', $idtransaccion);
            $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);

            $transaccion = null;
            $transaccion = DB::table('transaccion')
            ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
            ->leftJoin('cliente','transaccion.idcliente', '=','cliente.idcliente')
            ->leftJoin('empleado','transaccion.idempleado', '=','empleado.idempleado')
            ->leftJoin('tipotransaccion','transaccion.idtipotransaccion', '=','tipotransaccion.idtipotransaccion')
            ->leftJoin('estadotransaccion','transaccion.idestadotransaccion', '=','estadotransaccion.idestadotransaccion')
            ->select('transaccion.idtransaccion', 'transaccion.fecha', 'transaccion.total',
                'transaccion.idproveedor', 'proveedor.nombreproveedor', 'transaccion.idempleado', 'empleado.nombres', 'empleado.apellidos',
                'transaccion.idtipotransaccion', 'tipotransaccion.descripciontipotransaccion',
                'transaccion.idestadotransaccion', 'estadotransaccion.descripcionestadotransaccion','cliente.nombrecliente')
            ->where('transaccion.idtransaccion','=', $idtransaccion);
            $transaccion = $transaccion->orderBy('transaccion.idtipotransaccion', 'asc')->paginate(10);


            $fechatransaccion = '';
            $message = ''; 
            $nombreproveedor = "";
            $idestadotransaccion  = 0;
            foreach ($transaccion as $detalle) {
                $fechatransaccion =  $detalle->fecha;
                $nombreproveedor =  $detalle->nombreproveedor;
                $idestadotransaccion = $detalle->idestadotransaccion;
            }
            $msgbox = '';
            $data = array(
                'fechatransaccion'=>$fechatransaccion,
                'idtransaccion'=>$idtransaccion,
                'msg'=> $msgbox,
                'nombreproveedor'=> $nombreproveedor,
                'idestadotransaccion'=> $idestadotransaccion,
            );
            //return Redirect::to('inventario/transaccioncompra/listadetalletransaccioncompra/'.$idtransaccion);
            return view ('inventario.transaccioncompra.listadetalletransaccioncompra', ["transacciondetalle"=>$transacciondetalle, "searchText" =>$idtransaccion])->with($data);
        }
    }

    public function agregardetallecompra(Request $request){
        $detalletransaccionmodelo = new transacciondetallemodelo;
        //dd($request->get('idtransaccion'));
        $idtransaccion = $request->get('idtransaccion');
        $detalletransaccionmodelo->idtransaccion=$request->get('idtransaccion');
        $detalletransaccionmodelo->idproducto=$request->get('idproducto');
        $detalletransaccionmodelo->cantidad=$request->get('cantidad');
        $detalletransaccionmodelo->precio=$request->get('precio');
        $detalletransaccionmodelo->subtotal=$request->get('subtotal');
        $detalletransaccionmodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/detalletransaccion'); //retorna al usuario a listado de grados a URL	

        $responseData = array(
            'status' => 'success',
            'lista' => $idtransaccion,
        );

        $transacciondetalle = null;
        $transacciondetalle = DB::table('detalletransaccion')
        ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
        ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
        ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 
                'detalletransaccion.subtotal', DB::raw('DATE_FORMAT(transaccion.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor')
        ->where('detalletransaccion.idtransaccion','=', $idtransaccion);
        $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);
        return view ('inventario.transaccioncompra.listadetalletransaccioncompra', ["transacciondetalle"=>$transacciondetalle, "searchText" =>$idtransaccion])->with($responseData);
     }

    //APLICAR DETALLE DE COMPRA
    public function aplicarcompra(Request $request){
        $idtransaccion=$request->get('idtransaccion');
        $detalleproductos = null;
        $detalleproductos = DB::table('detalletransaccion')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
               'detalletransaccion.cantidad', 'detalletransaccion.precio', 'detalletransaccion.subtotal')
        ->where('detalletransaccion.idtransaccion','=', $request->get('idtransaccion'))->get();
        $totaltransaccion = 0;
        $idpro = 0;
        //dd("id tra " . $idtransaccion);
        //dd(($detalleproductos));
        //dump($detalleproductos);
        //dd();
        //(var_dump($transacciondetalleproductos));
        foreach ($detalleproductos as $detpro) {
            $cantidad = 0;
            $precio = 0;
            $subtotal = 0;
            $idpro = $detpro->idproducto;
            //dd($idpro);
            $cantidad =  $detpro->cantidad;
            $precio =  $detpro->precio;
            $subtotal =  $detpro->subtotal;
            $totaltransaccion = $totaltransaccion + $subtotal;
            $producto = DB::table('producto')
            ->select('producto.idproducto', 'producto.codigoproducto', 'producto.descripcionproducto',
                    'producto.preciocosto', 'producto.precioventa', 'producto.compras', 'producto.ventas', 'producto.existencia', 'producto.estado')
            ->where('producto.idproducto','=', $idpro)->get();
            foreach ($producto as $prod) {
                $preciocosto = 0;
                $compras = 0;
                $existencia = 0;
                $idproductoactualizar =  $prod->idproducto;
                //dd($preciocosto);
                $compras =  $prod->compras;
                $existencia =  $prod->existencia;
                $productomodelo=productomodelo::findorfail($idproductoactualizar);
                $productomodelo->preciocosto=$precio;
                $compras = $compras + $cantidad;
                $productomodelo->compras=$compras;  
                $existencia = $existencia + $cantidad;
                $productomodelo->existencia=$existencia;
                $productomodelo->update();
            }

        } //FIN FOR DETALLE DE PRODUCTOS
      
        DB::table('transaccion')->where('idtransaccion', $idtransaccion)->update(array('total' => $totaltransaccion, 'idestadotransaccion' => "2"));  

        $transacciondetalle = null;
        $transacciondetalle = DB::table('detalletransaccion')
        ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
        ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
        ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 
                'detalletransaccion.subtotal', DB::raw('DATE_FORMAT(transaccion.fecha, "%d/%m/%Y") AS fecha'),  'proveedor.nombreproveedor','transaccion.idestadotransaccion')
        ->where('detalletransaccion.idtransaccion','=', $idtransaccion);
        $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);

        $fechatransaccion = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadotransaccion = 0;
        foreach ($transacciondetalle as $detalle) {
            $fechatransaccion =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadotransaccion = $detalle->idestadotransaccion;
        }

        $msgbox = $subtotal;
        $data = array(
            'fechatransaccion'=>$fechatransaccion,
            'idtransaccion'=>$idtransaccion,
            'msg'=> $msgbox,
            'nombreproveedor'=> $nombreproveedor,
            'idestadotransaccion'=> $idestadotransaccion,
        );
        
        return view ('inventario.transaccioncompra.listadetalletransaccioncompra', ["transacciondetalle"=>$transacciondetalle, "searchText" =>$idtransaccion])->with($data);
    }


     //APLICAR DETALLE DE COMPRA
     public function anularcompra(Request $request){
        $idtransaccion=$request->get('idtransaccion');
        $detalleproductos = null;
        $detalleproductos = DB::table('detalletransaccion')
        ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
               'detalletransaccion.cantidad', 'detalletransaccion.precio', 'detalletransaccion.subtotal', 'transaccion.idestadotransaccion')
        ->where('detalletransaccion.idtransaccion','=', $request->get('idtransaccion'))->get();
        $totaltransaccion = 0;
        $idpro = 0;
        $idestadotransaccion = 0;
        foreach ($detalleproductos as $detpro) {
            $cantidad = 0;
            $precio = 0;
            $subtotal = 0;
            $idpro = $detpro->idproducto;
            //dd($idpro);
            $cantidad =  $detpro->cantidad;
            $precio =  $detpro->precio;
            $subtotal =  $detpro->subtotal;
            $idestadotransaccion =  $detpro->idestadotransaccion;
            $totaltransaccion = $totaltransaccion + $subtotal;

            if($idestadotransaccion == 2){
                $producto = DB::table('producto')
                ->select('producto.idproducto', 'producto.codigoproducto', 'producto.descripcionproducto',
                        'producto.preciocosto', 'producto.precioventa', 'producto.compras', 'producto.ventas', 'producto.existencia', 'producto.estado')
                ->where('producto.idproducto','=', $idpro)->get();
                foreach ($producto as $prod) {
                    $preciocosto = 0;
                    $compras = 0;
                    $existencia = 0;
                    $idproductoactualizar =  $prod->idproducto;
                    //dd($preciocosto);
                    $compras =  $prod->compras;
                    $existencia =  $prod->existencia;
                    $productomodelo=productomodelo::findorfail($idproductoactualizar);
                    //$productomodelo->preciocosto=$precio;
                    $compras = $compras - $cantidad;
                    $productomodelo->compras=$compras;  
                    $existencia = $existencia - $cantidad;
                    $productomodelo->existencia=$existencia;
                    $productomodelo->update();
                }
            }
        } //FIN FOR DETALLE DE PRODUCTOS
      
        DB::table('transaccion')->where('idtransaccion', $idtransaccion)->update(array('total' => $totaltransaccion, 'idestadotransaccion' => "3"));  


        $transacciondetalle = null;
        $transacciondetalle = DB::table('detalletransaccion')
        ->leftJoin('producto','detalletransaccion.idproducto', '=','producto.idproducto')
        ->leftJoin('transaccion','detalletransaccion.idtransaccion', '=','transaccion.idtransaccion')
        ->leftJoin('proveedor','transaccion.idproveedor', '=','proveedor.idproveedor')
        ->select('detalletransaccion.iddetalletransaccion', 'detalletransaccion.idtransaccion', 'detalletransaccion.idproducto',
                'producto.descripcionproducto', 'detalletransaccion.cantidad', 'detalletransaccion.precio', 
                'detalletransaccion.subtotal', DB::raw('DATE_FORMAT(transaccion.fecha, "%d/%m/%Y") AS fecha'),  'proveedor.nombreproveedor','transaccion.idestadotransaccion')
        ->where('detalletransaccion.idtransaccion','=', $idtransaccion);
        $transacciondetalle = $transacciondetalle->orderBy('detalletransaccion.idproducto', 'asc')->paginate(10);

        $fechatransaccion = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadotransaccion = 0;
        foreach ($transacciondetalle as $detalle) {
            $fechatransaccion =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadotransaccion = $detalle->idestadotransaccion;
        }

        $msgbox = $subtotal;
        $data = array(
            'fechatransaccion'=>$fechatransaccion,
            'idtransaccion'=>$idtransaccion,
            'msg'=> $msgbox,
            'nombreproveedor'=> $nombreproveedor,
            'idestadotransaccion'=> $idestadotransaccion,
        );
        
        return view ('inventario.transaccioncompra.listadetalletransaccioncompra', ["transacciondetalle"=>$transacciondetalle, "searchText" =>$idtransaccion])->with($data);
    }

    
    }