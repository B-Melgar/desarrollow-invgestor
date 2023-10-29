<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\segrolFormRequest; //request validacion
use App\Models\segrolmodelo;
use DB;

class segrolController extends Controller
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
            $segrol =DB::table('segrol')
            ->where('descripcionrol','LIKE', '%'.$query.'%')   
            ->where('estado','=', '1')
            ->orderBy('descripcionrol', 'asc')->paginate(10);
            return view ('seguridad.segrol.index', ["segrol"=>$segrol, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("seguridad.segrol.create");
    }

    //Guardar el objeto a BD para validar
    public function store(segrolFormRequest $request){
            //nuevo objeto
        $segrolmodelo= new segrolmodelo;
        $segrolmodelo->descripcionrol=$request->get('descripcionrol');
        $segrolmodelo->estado='1';
        $segrolmodelo->save(); //Guardar o almacenar
        return Redirect::to('seguridad/segrol'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idrol){
        return view ('seguridad.segrol.show', ["segrol"=>segrolmodelo::findorfail($idrol)]); //muestra por id de Categoria
    }

    public function edit($idrol){
        return view ('seguridad.segrol.edit', ["segrol"=>segrolmodelo::findorfail($idrol)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(segrolFormRequest $request, $idrol){
        $segrolmodelo=segrolmodelo::findorfail($idrol);
        $segrolmodelo->descripcionrol=$request->get('descripcionrol');
        $segrolmodelo->update();
        return Redirect::to('seguridad/segrol');
    }
     
    //Eliminar
    public function destroy($idrol){
        $segrolmodelo=segrolmodelo::findorfail($idrol);
        $segrolmodelo->estado='0';
        $segrolmodelo->update();
        return Redirect('seguridad/segrol');
    }
}