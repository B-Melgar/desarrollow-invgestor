<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\secAssignmentOptionFormRequest; //request validacion
use App\Models\secAssignmentOptionModel;
use DB;

class secAssignmentOptionController extends Controller
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
            $secAssignmentOption =DB::table('secAssignmentOption')
            ->join('segrol','secAssignmentOption.idrol', '=','segrol.idrol')
            ->join('secOptions','secAssignmentOption.idOption', '=','secOptions.idOption')
            ->select('secAssignmentOption.idAssignmentOption','secAssignmentOption.idrol','segrol.descripcionrol',
            'secAssignmentOption.idOption','secOptions.DescriptionOption','secAssignmentOption.status')
            ->where('secOptions.DescriptionOption','LIKE', '%'.$query.'%')   
            ->where('secAssignmentOption.status','=', '1')
            ->orderBy('segrol.descripcionrol', 'asc')->paginate(10);
            return view ('security.secAssignmentOption.index', ["secAssignmentOption"=>$secAssignmentOption, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("security.secAssignmentOption.create");
    }

    //Guardar el objeto a BD para validar
    public function store(secAssignmentOptionFormRequest $request){
            //nuevo objeto
        $secAssignmentOptionModel= new secAssignmentOptionModel;
        $secAssignmentOptionModel->idrol=$request->get('idrol');
        $secAssignmentOptionModel->idOption=$request->get('idOption');
        $secAssignmentOptionModel->status='1';
        $secAssignmentOptionModel->save(); //Guardar o almacenar
        return Redirect::to('security/secAssignmentOption'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idAssignmentOption){
        return view ('security.secAssignmentOption.show', ["secAssignmentOption"=>secAssignmentOptionModel::findorfail($idAssignmentOption)]); //muestra por id de Categoria
    }

    public function edit($idAssignmentOption){
        return view ('security.secAssignmentOption.edit', ["secAssignmentOption"=>secAssignmentOptionModel::findorfail($idAssignmentOption)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(secAssignmentOptionFormRequest $request, $idAssignmentOption){
        $secAssignmentOptionModel=secAssignmentOptionModel::findorfail($idAssignmentOption);
        $secAssignmentOptionModel->idrol=$request->get('idrol');
        $secAssignmentOptionModel->idOption=$request->get('idOption');
        $secAssignmentOptionModel->update();
        return Redirect::to('security/secAssignmentOption');
    }
     
    //Eliminar
    public function destroy($idAssignmentOption){
        $secAssignmentOptionModel=secAssignmentOptionModel::findorfail($idAssignmentOption);
        $secAssignmentOptionModel->status='0';
        $secAssignmentOptionModel->update();
        return Redirect('security/secAssignmentOption');
    }
}