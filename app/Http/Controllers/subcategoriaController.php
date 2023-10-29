<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\subcategoriaFormRequest; //request validacion
use App\Models\subcategoriamodelo;
use App\Models\categoriamodelo;
use DB;

class subcategoriaController extends Controller
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
            $subcategoria =DB::table('subcategoria')->join('categoria','categoria.idcategoria', '=','subcategoria.idcategoria')
            ->select('subcategoria.idsubcategoria','subcategoria.descripcionsubcategoria','subcategoria.idcategoria','categoria.descripcion')
            ->where('subcategoria.descripcionsubcategoria','LIKE', '%'.$query.'%')   
            ->orderBy('subcategoria.idcategoria', 'asc')->paginate(10);
            return view ('catalogos.subcategoria.index', ["subcategoria"=>$subcategoria, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.subcategoria.create");
    }

    //Guardar el objeto a BD para validar
    public function store(subcategoriaFormRequest $request){
        //nuevo objeto
        $subcategoriamodelo= new subcategoriamodelo;
        $subcategoriamodelo->idcategoria=$request->get('idcategoria');
        $subcategoriamodelo->descripcionsubcategoria=$request->get('descripcionsubcategoria');
        $subcategoriamodelo->save(); //Guardar o almacenar
        return Redirect::to('catalogos/subcategoria'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idsubcategoria){
        return view ('catalogos.subcategoria.show', ["subcategoria"=>subcategoriamodelo::findorfail($idsubcategoria)]); //muestra por id de Categoria
    }

    public function edit($idsubcategoria){
        return view ('catalogos.subcategoria.edit', ["subcategoria"=>subcategoriamodelo::findorfail($idsubcategoria)]);//paramtero recibido id
    }
    
    //Actualizar el objeto formulario
    public function update(subcategoriaFormRequest $request, $idsubcategoria){
        $subcategoriamodelo=subcategoriamodelo::findorfail($idsubcategoria);
        $subcategoriamodelo->idcategoria=$request->get('idcategoria');
        $subcategoriamodelo->descripcionsubcategoria=$request->get('descripcionsubcategoria');
        $subcategoriamodelo->update();
        return Redirect::to('catalogos/subcategoria');
    }
     
    //Eliminar
    public function destroy($idsubcategoria){
        subcategoriamodelo::destroy($idsubcategoria);   
        return Redirect('catalogos/subcategoria');
    }

}