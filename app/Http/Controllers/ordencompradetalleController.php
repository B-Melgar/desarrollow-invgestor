<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ordencompradetalleFormRequest; //request validacion
use App\Models\ordencompradetallemodelo;
use App\Models\ordencompramodelo;
use App\Models\productomodelo;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use DateTime;
use Illuminate\Support\Facades\Auth;
use PDF;


class ordencompradetalleController extends Controller
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
            $ordencompradetalle = null;
            $ordencompradetalle = DB::table('detalleordencompra')
            ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
            ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                    'producto.descripcionproducto', 'detalleordencompra.cantidad')
            ->where('producto.descripcionproducto','LIKE', '%'.$query.'%');
            if (!empty($_producto)){
                $ordencompradetalle = $ordencompradetalle->whereRaw('detalleordencompra.idproducto = '.$_producto);
            }  
            $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);
            return view ('inventario.detalleordencompra.index', ["detalleordencompra"=>$detalleordencompra, "searchText"=>$query, "_producto"=>$_producto]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("inventario.detalleordencompra.create");
    }

    //Guardar el objeto a BD para validar
    public function store(detalleordencompraFormRequest $request){
        //nuevo objeto
        $ordencompradetallemodelo= new ordencompradetallemodelo;
        $ordencompradetallemodelo->idordencompra=$request->get('idordencompra');
        $ordencompradetallemodelo->idproducto=$request->get('idproducto');
        $ordencompradetallemodelo->cantidad=$request->get('cantidad');
        $ordencompradetallemodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/detalleordencompra'); //retorna al usuario a listado de grados a URL	
    }

    public function show($iddetalleordencompra){
        return view ('inventario.detalleordencompra.show', ["detalleordencompra"=>ordencompradetallemodelo::findorfail($iddetalleordencompra)]); //muestra por id de Categoria
    }
   
    //Actualizar el objeto formulario
    public function update(ordencompraFormRequest $request, $iddetalleordencompra){
        $ordencompradetallemodelo=ordencompradetallemodelo::findorfail($iddetalleordencompra);
        $ordencompradetallemodelo->idordencompra=$request->get('idordencompra');
        $ordencompradetallemodelo->idproducto=$request->get('idproducto');
        $ordencompradetallemodelo->cantidad=$request->get('cantidad');
        $ordencompradetallemodelo->update();
        return Redirect::to('inventario/detalleordencompra');
    }
     
    //Eliminar
    public function destroy($iddetalleordencompra){
        ordencompradetallemodelo::destroy($iddetalleordencompra);    
        return Redirect('inventario/detalleordencompra');
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
        $ordencompradetallemodelo = new ordencompradetallemodelo;
        //dd($request->get('idordencompra'));
        $idordencompra = $request->get('idordencompra');
        $ordencompradetallemodelo->idordencompra=$request->get('idordencompra');
        $ordencompradetallemodelo->idproducto=$request->get('idproducto');
        $ordencompradetallemodelo->cantidad=$request->get('cantidad');
        $ordencompradetallemodelo->save(); //Guardar o almacenar
        

        $ordencompradetalle = null;
        $ordencompradetalle = DB::table('detalleordencompra')
        ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
        ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
        ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                'producto.descripcionproducto', 'detalleordencompra.cantidad','detalleordencompra.precio', 
                'detalleordencompra.subtotal', DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
        ->where('detalleordencompra.idordencompra','=', $idordencompra);
        $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);

        $fechaordencompra = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadoordencompra = 0;
        foreach ($ordencompradetalle as $detalle) {
            $fechaordencompra =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadoordencompra =  $detalle->idestadoordencompra;
        }
        $msgbox = '';
        $data = array(
            'fechaordencompra'=>$fechaordencompra,
            'idordencompra'=>$idordencompra,
            'msg'=> $msgbox,
            'idestadoordencompra'=> $idestadoordencompra,
        );
        
        return view ('inventario.ordencompra.listadetalleordencompra', ["ordencompradetalle"=>$ordencompradetalle, "searchText" =>$idordencompra])->with($data);
    }

    //BORRAR DETALLE DE COMPRA
    public function borrardetalleordencompra(Request $request){
        $ordencompradetallemodelo = new ordencompradetallemodelo;
        $iddetalleordencompra=$request->get('iddetalleordencompra');
        $ordencompradetallemodelo = ordencompradetallemodelo::find($iddetalleordencompra); 
        $ordencompradetallemodelo->delete();

        $ordencompradetalle = null;
        $ordencompradetalle = DB::table('detalleordencompra')
        ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
        ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
        ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                'producto.descripcionproducto', 'detalleordencompra.cantidad', 'detalleordencompra.precio', 
                'detalleordencompra.subtotal', DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'),  'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
        ->where('detalleordencompra.idordencompra','=', $idordencompra);
        $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);

        $fechaordencompra = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadoordencompra = 0;
        foreach ($ordencompradetalle as $detalle) {
            $fechaordencompra =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadoordencompra = $detalle->idestadoordencompra;
        }

        $msgbox = '';
        $data = array(
            'fechaordencompra'=>$fechaordencompra,
            'idestadoordencompra'=>$idestadoordencompra,
            'idordencompra'=>$idordencompra,
            'nombreproveedor'=> $nombreproveedor,
        );
        
        return view ('inventario.ordencompra.listadetalleordencompra', ["ordencompradetalle"=>$ordencompradetalle, "searchText" =>$idordencompra])->with($data);
    }

    public function detalleordencompradata($idordencompra){
        //dd($idordencompra);
        if (isset($idordencompra)){  
            $ordencompradetalle = null;
            $ordencompradetalle = DB::table('detalleordencompra')
            ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
            ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
            ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
            ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                    'producto.descripcionproducto', 'detalleordencompra.cantidad', 'detalleordencompra.precio', 
                    'detalleordencompra.subtotal', DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
            ->where('detalleordencompra.idordencompra','=', $idordencompra);
            $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);

            $ordencompra = null;
            $ordencompra = DB::table('ordencompra')
            ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
            ->leftJoin('empleado','ordencompra.idempleado', '=','empleado.idempleado')
            ->leftJoin('estadoordencompra','ordencompra.idestadoordencompra', '=','estadoordencompra.idestadoordencompra')
            ->select('ordencompra.idordencompra', 'ordencompra.fecha', 'ordencompra.total',
                'ordencompra.idproveedor', 'proveedor.nombreproveedor', 'ordencompra.idempleado', 'empleado.nombres', 'empleado.apellidos',
                'ordencompra.idestadoordencompra', 'estadoordencompra.descripcionordencompra')
            ->where('ordencompra.idordencompra','=', $idordencompra);
            $ordencompra = $ordencompra->orderBy('ordencompra.idordencompra', 'desc')->paginate(10);


            $fechaordencompra = '';
            $message = ''; 
            $nombreproveedor = "";
            $idestadoordencompra  = 0;
            foreach ($ordencompra as $detalle) {
                $fechaordencompra =  $detalle->fecha;
                $nombreproveedor =  $detalle->nombreproveedor;
                $idestadoordencompra = $detalle->idestadoordencompra;
            }
            $msgbox = '';
            $data = array(
                'fechaordencompra'=>$fechaordencompra,
                'idestadoordencompra'=>$idestadoordencompra,
                'idordencompra'=>$idordencompra,
                'nombreproveedor'=> $nombreproveedor,
            );
            return view ('inventario.ordencompra.listadetalleordencompra', ["ordencompradetalle"=>$ordencompradetalle, "searchText" =>$idordencompra])->with($data);
        }
    }

    public function agregardetalleordencompra(Request $request){
        $ordencompradetallemodelo = new ordencompradetallemodelo;
        //dd($request->get('idordencompra'));
        $idordencompra = $request->get('idordencompra');
        $ordencompradetallemodelo->idordencompra=$request->get('idordencompra');
        $ordencompradetallemodelo->idproducto=$request->get('idproducto');
        $ordencompradetallemodelo->cantidad=$request->get('cantidad');
        $ordencompradetallemodelo->precio=$request->get('precio');
        $cantidad = $request->get('cantidad');
        $precio = $request->get('precio');
        $subtotal =  $cantidad * $precio;
        $ordencompradetallemodelo->subtotal= $subtotal;
        $ordencompradetallemodelo->save(); //Guardar o almacenar
        //return Redirect::to('inventario/detalleordencompra'); //retorna al usuario a listado de grados a URL	

        $responseData = array(
            'status' => 'success',
            'lista' => $idordencompra,
        );

        $ordencompradetalle = null;
        $ordencompradetalle = DB::table('detalleordencompra')
        ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
        ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
        ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                'producto.descripcionproducto', 'detalleordencompra.cantidad', 'detalleordencompra.precio', 
                'detalleordencompra.subtotal', DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
        ->where('detalleordencompra.idordencompra','=', $idordencompra);
        $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);
        $fechaordencompra = '';
        $message = ''; 
        $nombreproveedor = "";
        $nombrecliente = "";
        $idestadoordencompra = 0;
        foreach ($ordencompradetalle as $detalle) {
            $fechaordencompra =  $detalle->fecha;
            $idestadoordencompra =  $detalle->idestadoordencompra;
            $nombreproveedor =  $detalle->nombreproveedor;
        }
        $msgbox = '';
        $data = array(
            'fechaordencompra'=>$fechaordencompra,
            'idestadoordencompra'=>$idestadoordencompra,
            'idordencompra'=>$idordencompra,
            'nombreproveedor'=> $nombreproveedor,
        );
        return view ('inventario.ordencompra.listadetalleordencompra', ["ordencompradetalle"=>$ordencompradetalle, "searchText" =>$idordencompra])->with($data);
     }

    //APLICAR DETALLE DE COMPRA
    public function aplicarordencompra(Request $request){
        $idordencompra=$request->get('idordencompra');
        $detalleproductos = null;
        $detalleproductos = DB::table('detalleordencompra')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
               'detalleordencompra.cantidad', 'detalleordencompra.precio', 'detalleordencompra.subtotal')
        ->where('detalleordencompra.idordencompra','=', $request->get('idordencompra'))->get();
        $totalordencompra = 0;
        $idpro = 0;
        //dd("id tra " . $idordencompra);
        //dd(($detalleproductos));
        //dump($detalleproductos);
        //dd();
        //(var_dump($ordencompradetalleproductos));
        foreach ($detalleproductos as $detpro) {
            $cantidad = 0;
            $precio = 0;
            $subtotal = 0;
            $idpro = $detpro->idproducto;
            //dd($idpro);
            $cantidad =  $detpro->cantidad;
            $precio =  $detpro->precio;
            $subtotal =  $detpro->subtotal;
            $totalordencompra = $totalordencompra + $subtotal;
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
      
        DB::table('ordencompra')->where('idordencompra', $idordencompra)->update(array('total' => $totalordencompra, 'idestadoordencompra' => "2"));  

        $ordencompradetalle = null;
        $ordencompradetalle = DB::table('detalleordencompra')
        ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
        ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
        ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                'producto.descripcionproducto', 'detalleordencompra.cantidad', 'detalleordencompra.precio', 
                'detalleordencompra.subtotal', DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'),  'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
        ->where('detalleordencompra.idordencompra','=', $idordencompra);
        $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);

        $fechaordencompra = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadoordencompra = 0;
        foreach ($ordencompradetalle as $detalle) {
            $fechaordencompra =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadoordencompra = $detalle->idestadoordencompra;
        }

        $msgbox = $subtotal;
        $data = array(
            'fechaordencompra'=>$fechaordencompra,
            'idordencompra'=>$idordencompra,
            'msg'=> $msgbox,
            'nombreproveedor'=> $nombreproveedor,
            'idestadoordencompra'=> $idestadoordencompra,
        );
        
        return view ('inventario.ordencompra.listadetalleordencompra', ["ordencompradetalle"=>$ordencompradetalle, "searchText" =>$idordencompra])->with($data);
    }


     //APLICAR DETALLE DE COMPRA
     public function anularordencompra(Request $request){
        $idordencompra=$request->get('idordencompra');
        $detalleproductos = null;
        $detalleproductos = DB::table('detalleordencompra')
        ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
               'detalleordencompra.cantidad', 'detalleordencompra.precio', 'detalleordencompra.subtotal', 'ordencompra.idestadoordencompra')
        ->where('detalleordencompra.idordencompra','=', $request->get('idordencompra'))->get();
        $totalordencompra = 0;
        $idpro = 0;
        $idestadoordencompra = 0;
        foreach ($detalleproductos as $detpro) {
            $cantidad = 0;
            $precio = 0;
            $subtotal = 0;
            $idpro = $detpro->idproducto;
            //dd($idpro);
            $cantidad =  $detpro->cantidad;
            $precio =  $detpro->precio;
            $subtotal =  $detpro->subtotal;
            $idestadoordencompra =  $detpro->idestadoordencompra;
            $totalordencompra = $totalordencompra + $subtotal;

            if($idestadoordencompra == 2){
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
      
        DB::table('ordencompra')->where('idordencompra', $idordencompra)->update(array('total' => $totalordencompra, 'idestadoordencompra' => "3"));  


        $ordencompradetalle = null;
        $ordencompradetalle = DB::table('detalleordencompra')
        ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
        ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
        ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
        ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
                'producto.descripcionproducto', 'detalleordencompra.cantidad', 'detalleordencompra.precio', 
                'detalleordencompra.subtotal', DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'),  'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
        ->where('detalleordencompra.idordencompra','=', $idordencompra);
        $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->paginate(10);

        $fechaordencompra = '';
        $message = ''; 
        $nombreproveedor = "";
        $idestadoordencompra = 0;
        foreach ($ordencompradetalle as $detalle) {
            $fechaordencompra =  $detalle->fecha;
            $nombreproveedor =  $detalle->nombreproveedor;
            $idestadoordencompra = $detalle->idestadoordencompra;
        }

        $msgbox = $subtotal;
        $data = array(
            'fechaordencompra'=>$fechaordencompra,
            'idordencompra'=>$idordencompra,
            'msg'=> $msgbox,
            'nombreproveedor'=> $nombreproveedor,
            'idestadoordencompra'=> $idestadoordencompra,
        );
        
        return view ('inventario.ordencompra.listadetalleordencompra', ["ordencompradetalle"=>$ordencompradetalle, "searchText" =>$idordencompra])->with($data);
    }


        // Generate PDF descarga producto
public function imprimirordencompra(Request $request) {
    $idordencompra = $request->get('idordencompra');
    $ordencompradetalle = null;
    $ordencompradetalle = DB::table('detalleordencompra')
    ->leftJoin('producto','detalleordencompra.idproducto', '=','producto.idproducto')
    ->leftJoin('ordencompra','detalleordencompra.idordencompra', '=','ordencompra.idordencompra')
    ->leftJoin('proveedor','ordencompra.idproveedor', '=','proveedor.idproveedor')
    ->select('detalleordencompra.iddetalleordencompra', 'detalleordencompra.idordencompra', 'detalleordencompra.idproducto',
            'producto.descripcionproducto', 'detalleordencompra.cantidad', DB::raw('FORMAT(detalleordencompra.precio,2) as precio'),
            DB::raw('FORMAT(detalleordencompra.subtotal,2) as subtotal'), DB::raw('DATE_FORMAT(ordencompra.fecha, "%d/%m/%Y") AS fecha'), 'proveedor.nombreproveedor','ordencompra.idestadoordencompra')
    ->where('detalleordencompra.idordencompra','=', $idordencompra);
    $ordencompradetalle = $ordencompradetalle->orderBy('detalleordencompra.idproducto', 'asc')->get();
    
    $fechaordencompra = '';
    $message = ''; 
    $nombreproveedor = "";
    $idestadoordencompra = 0;
    $subtotal = 0;
    foreach ($ordencompradetalle as $detalle) {
        $fechaordencompra =  $detalle->fecha;
        $nombreproveedor =  $detalle->nombreproveedor;
        $idestadoordencompra = $detalle->idestadoordencompra;
        $subtotal = $detalle->subtotal;
    }

    $ordencompradetalleT = DB::table('detalleordencompra')
    ->select(DB::raw('FORMAT(sum(detalleordencompra.subtotal),2) as subtotal'))
    ->where('detalleordencompra.idordencompra','=', $idordencompra);
    $ordencompradetalleT = $ordencompradetalleT->get();
    
    
    $totalOrden = 0;
    $subtotal = 0;
    foreach ($ordencompradetalleT as $detalleT) {
        $totalOrden = $detalleT->subtotal;
    }

    $fechaimpresion = date('d/m/Y');
    $data = compact('ordencompradetalle','idordencompra','fechaimpresion','fechaordencompra' ,'nombreproveedor','totalOrden');
    $pdf = PDF::loadView('reportes.ordencompra', $data);
    $path = public_path('pdf/');
    $fileName =  'OrdenCompra_No_' .$idordencompra .  time() .'.pdf';
    $pdf->save($path . '/' . $fileName);
    $pdf = public_path('pdf/'.$fileName);
    $answer =  response()->download($pdf);
    return $answer;
  }

    
}