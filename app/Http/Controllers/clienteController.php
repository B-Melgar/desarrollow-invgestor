<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\clienteFormRequest; //request validacion
use App\Models\clientemodelo;
use DB;

class clienteController extends Controller
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
            $cliente =DB::table('cliente')
            ->select('cliente.idcliente', 'cliente.nit', 'cliente.nombrecliente','cliente.direccion','cliente.telefono',
                    'cliente.correo', 'cliente.credito', 'cliente.diascredito',
                    DB::raw('(CASE WHEN cliente.credito = "1" THEN "Si" ELSE "No" END) AS credito'))
            ->where('cliente.nit','LIKE', '%'.$query.'%')
            ->orderBy('cliente.idcliente', 'desc')->paginate(10);
            return view ('inventario.cliente.index', ["cliente"=>$cliente, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("inventario.cliente.create");
    }

    //Guardar el objeto a BD para validar
    public function store(clienteFormRequest $request){
            //nuevo objeto
        $clientemodelo= new clientemodelo;
        $clientemodelo->nit=$request->get('nit');
        $clientemodelo->nombrecliente=$request->get('nombrecliente');
        $clientemodelo->direccion=$request->get('direccion');
        $clientemodelo->telefono=$request->get('telefono');
        $clientemodelo->correo=$request->get('correo');
        $clientemodelo->credito = (!request()->has('credito') == '1' ? '0' : '1'); 
        $clientemodelo->diascredito=$request->get('diascredito');
        $clientemodelo->save(); //Guardar o almacenar
        return Redirect::to('inventario/cliente'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idcliente){
        return view ('inventario.cliente.show', ["cliente"=>clientemodelo::findorfail($idcliente)]); //muestra por id de Categoria
    }

    public function edit($idcliente){
        return view ('inventario.cliente.edit', ["cliente"=>clientemodelo::findorfail($idcliente)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(clienteFormRequest $request, $idcliente){
        //dd($request->get('nit'));
        $clientemodelo=clientemodelo::findorfail($idcliente);
        $clientemodelo->nit=$request->get('nit');
        $clientemodelo->nombrecliente=$request->get('nombrecliente');
        $clientemodelo->direccion=$request->get('direccion');
        $clientemodelo->telefono=$request->get('telefono');
        $clientemodelo->correo=$request->get('correo');
        $clientemodelo->credito = (!request()->has('credito') == '1' ? '0' : '1'); 
        $clientemodelo->diascredito=$request->get('diascredito');
        $clientemodelo->update();
        return Redirect::to('inventario/cliente');
    }
     
    //Eliminar
    public function destroy($idcliente){
        clientemodelo::destroy($idcliente) ;
        return Redirect('inventario/cliente');
    }
}