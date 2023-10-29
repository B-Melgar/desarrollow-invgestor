<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\secMenuFormRequest; //request validacion
use App\Models\secMenuModel;
use DB;

class secMenuController extends Controller
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
            $secMenu =DB::table('secMenu')
            ->select('secMenu.idMenu','secMenu.DescriptionMenu','secMenu.IconMenu','secMenu.orden')
            ->where('DescriptionMenu','LIKE', '%'.$query.'%')   
            ->orderBy('orden', 'asc')->paginate(10);
            return view ('security.secMenu.index', ["secMenu"=>$secMenu, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("security.secMenu.create");
    }

    //Guardar el objeto a BD para validar
    public function store(secMenuFormRequest $request){
            //nuevo objeto
        $secMenuModel= new secMenuModel;
        $secMenuModel->DescriptionMenu=$request->get('DescriptionMenu');
        $secMenuModel->IconMenu=$request->get('IconMenu');
        $secMenuModel->orden=$request->get('orden');
        $secMenuModel->save(); //Guardar o almacenar
        return Redirect::to('security/secMenu'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idMenu){
        return view ('security.secMenu.show', ["secMenu"=>secMenuModel::findorfail($idMenu)]); //muestra por id de Categoria
    }

    public function edit($idMenu){
        return view ('security.secMenu.edit', ["secMenu"=>secMenuModel::findorfail($idMenu)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(secMenuFormRequest $request, $idMenu){
        $secMenuModel=secMenuModel::findorfail($idMenu);
        $secMenuModel->DescriptionMenu=$request->get('DescriptionMenu');
        $secMenuModel->IconMenu=$request->get('IconMenu');
        $secMenuModel->orden=$request->get('orden');
        $secMenuModel->update();
        return Redirect::to('security/secMenu');
    }
     
    //Eliminar
    // public function destroy($idMenu){
    //     $secMenuModel=secMenuModel::findorfail($idMenu);
    //     $secMenuModel->status='0';
    //     $secMenuModel->update();
    //     return Redirect('security/secMenu');
    // }
}