<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\productoStatusFormRequest; //request validacion
use App\Models\productoStatusModel;
use DB;

class productoStatusController extends Controller
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
            $productoStatus =DB::table('productoStatus')
            ->where('descripcionproductoStatus','LIKE', '%'.$query.'%')
            ->where('status','=', '1')   
            ->orderBy('descripcionproductoStatus', 'asc')->paginate(10);
            return view ('catalogos.productoStatus.index', ["productoStatus"=>$productoStatus, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.productoStatus.create");
    }

    //Guardar el objeto a BD para validar
    public function store(productoStatusFormRequest $request){
            //nuevo objeto
        $productoStatusModel= new productoStatusModel;
        $productoStatusModel->descripcionproductoStatus=$request->get('descripcionproductoStatus');
        $productoStatusModel->status='1';
        $productoStatusModel->save(); //Guardar o almacenar
        return Redirect::to('catalogos/productoStatus'); //retorna al usuario a listado de grados a URL	
    }

    public function show($estado){
        return view ('catalogos.productoStatus.show', ["productoStatus"=>productoStatusModel::findorfail($estado)]); //muestra por id de Categoria
    }

    public function edit($estado){
        return view ('catalogos.productoStatus.edit', ["productoStatus"=>productoStatusModel::findorfail($estado)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(productoStatusFormRequest $request, $estado){
        $productoStatus=productoStatusModel::findorfail($estado);
        $productoStatus->descripcionproductoStatus=$request->get('descripcionproductoStatus');
        $productoStatus->update();
        return Redirect::to('catalogos/productoStatus');
    }
     
    //Eliminar
    public function destroy($estado){
        //productoStatusModel::destroy($estado)
        //->orderBy('descripcionproductoStatus', 'asc'); 
        // $productoStatusModel=productoStatusModel::findorfail($estado);
        // $productoStatusModel->status='0';
        // $productoStatusModel->update();
        $status = '0';
        DB::table('productoStatus')->where('estado', $estado)->update(array('status' => $status)); 
        return Redirect('catalogos/productoStatus');
    }
}