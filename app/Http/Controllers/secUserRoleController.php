<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\segusuariorolFormRequest; //request validacion
use App\Models\segusuariorolModel;
use App\Models\segrolmodelo;
use DB;

class segusuariorolController extends Controller
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
            $segusuariorol =DB::table('segusuariorol')
            ->join('segrol','segusuariorol.idrol', '=','segrol.idrol')
            ->join('users','segusuariorol.users_id', '=','users.id')
            ->join('empleado','users.idempleado', '=','empleado.idempleado')
            ->select('segusuariorol.idUserRole','segusuariorol.idrol','segrol.descripcionrol','segusuariorol.users_id','users.name',
                'empleado.nombres', 'empleado.apellidos',
                DB::raw('DATE_FORMAT(segusuariorol.startDate, "%d/%m/%Y") AS startDate'),
                DB::raw('DATE_FORMAT(segusuariorol.endDate, "%d/%m/%Y") AS endDate'),
                DB::raw('(CASE WHEN segusuariorol.Active = "1" THEN "Si" ELSE "No" END) AS Active'))
            ->where('segrol.descripcionrol','LIKE', '%'.$query.'%')   
            ->where('segusuariorol.status','=', '1')   
            ->orderBy('segrol.idrol', 'asc')->paginate(10);
            return view ('security.segusuariorol.index', ["segusuariorol"=>$segusuariorol, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("security.segusuariorol.create");
    }

    //Guardar el objeto a BD para validar
    public function store(segusuariorolFormRequest $request){
        //nuevo objeto
        $segusuariorolModel= new segusuariorolModel;
        $segusuariorolModel->idrol=$request->get('idrol');
        $segusuariorolModel->users_id=$request->get('users_id');
        $segusuariorolModel->startDate=$request->get('startDate');
        $segusuariorolModel->endDate=$request->get('endDate');
        $segusuariorolModel->Active = (!request()->has('Active') == '1' ? '0' : '1'); 
        $segusuariorolModel->status='1';
        $segusuariorolModel->save(); //Guardar o almacenar
        return Redirect::to('security/segusuariorol'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idUserRole){
        return view ('security.segusuariorol.show', ["segusuariorol"=>segusuariorolModel::findorfail($idUserRole)]); //muestra por id de Categoria
    }

    public function edit($idUserRole){
        return view ('security.segusuariorol.edit', ["segusuariorol"=>segusuariorolModel::findorfail($idUserRole)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(segusuariorolFormRequest $request, $idUserRole){
        $segusuariorolModel=segusuariorolModel::findorfail($idUserRole);
        $segusuariorolModel->idrol=$request->get('idrol');
        $segusuariorolModel->users_id=$request->get('users_id');
        $segusuariorolModel->startDate=$request->get('startDate');
        $segusuariorolModel->endDate=$request->get('endDate');
        $segusuariorolModel->Active = (!request()->has('Active') == '1' ? '0' : '1'); 
        $segusuariorolModel->update();
        return Redirect::to('security/segusuariorol');
    }
     
    //Eliminar
    public function destroy($idUserRole){
        //segusuariorolModel::destroy($idUserRole)
        //->orderBy('segrol.idrol', 'asc');
        $segusuariorolModel=segusuariorolModel::findorfail($idUserRole);
        $segusuariorolModel->status='0';
        $segusuariorolModel->update();
        return Redirect('security/segusuariorol');
    }
}