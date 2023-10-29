<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\invTradeMarkFormRequest; //request validacion
use App\Models\invTradeMarkModel;
use DB;
use DateTime;
use PDF;

class reporteController extends Controller
{
    //Valida usuario logueado
    public function __construct()
    {
        $this -> middleware('auth'); //redirecciona a Login
    }

    //Consulta
    public function index(Request $request){
        if ($request){  
            return view ('panelreporte.panelreporte.index');
        }
    }

    // Generate PDF descarga producto
    public function imprimirinventarioproducto(Request $request) {
        $answer = "";
        $listaproducto =DB::table('producto')
            ->select('producto.idproducto',  'producto.codigoproducto', 'producto.descripcionproducto',
            DB::raw('FORMAT(producto.preciocosto,2) as preciocosto'),  DB::raw('FORMAT(producto.precioventa,2) as precioventa'), 
            'producto.compras', 'producto.ventas', 'producto.existencia',
            'producto.photo', 'producto.estado')
            ->where('producto.estado','=', '1')->get();
            $fechadescarga = '';
            $estadodescarga = '';
            
            $fechaImpresion = date('d/m/Y');
            $nombrelistado = "Inventario Producto";
            $data = compact('listaproducto','fechaImpresion', 'nombrelistado');
            $pdf = PDF::loadView('reportes.inventarioproducto', $data);
            $path = public_path('pdf/');
            $fileName =  'InventarioProducto_' . time() .'.pdf';
            $pdf->save($path . '/' . $fileName);
            $pdf = public_path('pdf/'.$fileName);
            $answer =  response()->download($pdf);
        return $answer;
      }

}