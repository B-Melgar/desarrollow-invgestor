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

class reportController extends Controller
{
    //Valida usuario logueado
    public function __construct()
    {
        $this -> middleware('auth'); //redirecciona a Login
    }

    //Consulta
    public function index(Request $request){
        if ($request){  
            return view ('reportspanel.panelreports.index');
        }
    }

    // Generate PDF descarga producto
public function printproductbranchlist(Request $request) {
    $idBranch = $request->idBranch;
    $answer = '';
    $productBranchList =DB::table('productodetailstore')
        ->leftJoin('producto','productodetailstore.idproducto', '=','producto.idproducto')
        ->leftJoin('gralBranch','productodetailstore.idBranch', '=','gralBranch.idBranch')
        ->select('productodetailstore.idproductoDetailStore', 'productodetailstore.idproducto', 'producto.descripcionproducto',
        'productodetailstore.idBranch', 'gralBranch.name as nameBranch', 'productodetailstore.optimalQuantity', 
        'productodetailstore.initialExistence', 'productodetailstore.purchase', 'productodetailstore.returns',
        'productodetailstore.inService', 'productodetailstore.obsolete as descargas', 
        'productodetailstore.existence', 'productodetailstore.status')
        ->where('productodetailstore.idBranch','=', $idBranch)
        ->where('productodetailstore.status','=', '1')->get();   
        $nameBranch = '';
        $dateDownload = '';
        $statusDownload = '';
        foreach ($productBranchList as $productBranch) {
            $nameBranch = $productBranch->nameBranch;
        }
        $fechaImpresion = date('d/m/Y');
        $data = compact('productBranchList','fechaImpresion', 'nameBranch');
        $pdf = PDF::loadView('report.inventaryproductbranch', $data);
        $path = public_path('pdf/');
        $fileName =  'InventaryProductSucursal_'.$nameBranch.'_'.  time() .'.pdf';
        $pdf->save($path . '/' . $fileName);
        $pdf = public_path('pdf/'.$fileName);
        $answer =  response()->download($pdf);
    return $answer;
  }

}