<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\segusuarioFormRequest; //request validacion
use App\Models\segusuariomodelo;
use App\Models\empleadomodelo;
use DB;

class segusuarioController extends Controller
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
            $segusuario =DB::table('users')
            ->join('empleado','users.idempleado', '=','empleado.idempleado')
            ->join('segrol','users.idrol', '=','segrol.idrol')
            ->select('users.id','users.name','users.email','empleado.nombres','empleado.apellidos','users.password',
                'users.idrol','segrol.descripcionrol')
            ->where('empleado.nombres','LIKE', '%'.$query.'%')  
            ->where('users.estado','=', '1') 
            ->orderBy('users.id', 'asc')->paginate(10);
            return view ('seguridad.segusuario.index', ["segusuario"=>$segusuario, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("seguridad.segusuario.create");
    }

    //Guardar el objeto a BD para validar
    public function store(segusuarioFormRequest $request){
        //nuevo objeto
        $segusuariomodelo= new segusuariomodelo;
        $segusuariomodelo->email=$request->get('email');
        $segusuariomodelo->name=$request->get('email');
        //$segusuariomodelo->email_verified_at=$request->get('email');
        //$segusuariomodelo->password=$request->get('password');
        $segusuariomodelo->password=bcrypt($request-> get('password'));
        $segusuariomodelo->idempleado=$request->get('idempleado');
        $segusuariomodelo->idrol=$request->get('idrol');
        $segusuariomodelo->estado='1';
        $segusuariomodelo->save(); //Guardar o almacenar
        return Redirect::to('seguridad/segusuario'); //retorna al usuario a listado de grados a URL	
    }

    public function show($id){
        return view ('seguridad.segusuario.show', ["segusuario"=>segusuariomodelo::findorfail($id)]); //muestra por id de Categoria
    }

    public function edit($id){
        return view ('seguridad.segusuario.edit', ["segusuario"=>segusuariomodelo::findorfail($id)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(segusuarioFormRequest $request, $id){
        $segusuariomodelo=segusuariomodelo::findorfail($id);
        //$segusuariomodelo->password=$request->get('password');
        $segusuariomodelo->password=bcrypt($request-> get('password'));
        $segusuariomodelo->idrol=$request->get('idrol');
        $segusuariomodelo->update();
        return Redirect::to('seguridad/segusuario');
    }
     
    //Eliminar
    public function destroy($id){
        //segusuariomodelo::destroy($id)
        //->orderBy('users.id', 'asc'); 
        $segusuariomodelo=segusuariomodelo::findorfail($id);
        $segusuariomodelo->estado='0';
        $segusuariomodelo->update();
        return Redirect('seguridad/segusuario');
    }

}