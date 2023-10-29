<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\secOptionsFormRequest; //request validacion
use App\Models\secOptionsModel;
use DB;

class secOptionsController extends Controller
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
            $secOptions =DB::table('secOptions')
            ->join('secMenu','secOptions.idMenu', '=','secMenu.idMenu')
            ->select('secOptions.idOption','secOptions.idMenu','secMenu.DescriptionMenu',
            'secOptions.DescriptionOption','secOptions.RouteOption','secOptions.IconOption','secOptions.status')
            ->where('DescriptionOption','LIKE', '%'.$query.'%')   
            ->where('status','=', '1')
            ->orderBy('DescriptionMenu', 'asc')->paginate(10);
            return view ('security.secOptions.index', ["secOptions"=>$secOptions, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("security.secOptions.create");
    }

    //Guardar el objeto a BD para validar
    public function store(secOptionsFormRequest $request){
            //nuevo objeto
        $secOptionsModel= new secOptionsModel;
        $secOptionsModel->idMenu=$request->get('idMenu');
        $secOptionsModel->DescriptionOption=$request->get('DescriptionOption');
        $secOptionsModel->RouteOption=$request->get('RouteOption');
        $secOptionsModel->IconOption=$request->get('IconOption');
        $secOptionsModel->status='1';
        $secOptionsModel->save(); //Guardar o almacenar
        return Redirect::to('security/secOptions'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idOption){
        return view ('security.secOptions.show', ["secOptions"=>secOptionsModel::findorfail($idOption)]); //muestra por id de Categoria
    }

    public function edit($idOption){
        return view ('security.secOptions.edit', ["secOptions"=>secOptionsModel::findorfail($idOption)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(secOptionsFormRequest $request, $idOption){
        $secOptionsModel=secOptionsModel::findorfail($idOption);
        $secOptionsModel->DescriptionOption=$request->get('DescriptionOption');
        $secOptionsModel->RouteOption=$request->get('RouteOption');
        $secOptionsModel->IconOption=$request->get('IconOption');
        $secOptionsModel->update();
        return Redirect::to('security/secOptions');
    }
     
    //Eliminar
    public function destroy($idOption){
        //segrolmodelo::destroy($idrol)
        //->orderBy('descripcionrol', 'asc');
        $secOptionsModel=secOptionsModel::findorfail($idOption);
        $secOptionsModel->status='0';
        $secOptionsModel->update();
        return Redirect('security/secOptions');
    }
}