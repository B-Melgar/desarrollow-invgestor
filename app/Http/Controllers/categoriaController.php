<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\categoriaFormRequest; //request validacion
use App\Models\categoriamodelo;
use DB;

class categoriaController extends Controller
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
            $categoria =DB::table('categoria')
            ->where('descripcion','LIKE', '%'.$query.'%')   
    
            ->orderBy('descripcion', 'asc')->paginate(10);
            return view ('catalogos.categoria.index', ["categoria"=>$categoria, "searchText" =>$query]);
        }
    }

    public function create(){	
        return view("catalogos.categoria.create");
    }

    //Guardar el objeto a BD para validar
    public function store(categoriaFormRequest $request){
            //nuevo objeto
        $categoriamodelo= new categoriamodelo;
        $categoriamodelo->descripcion=$request->get('descripcion');
        $categoriamodelo->save(); //Guardar o almacenar
        return Redirect::to('catalogos/categoria'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idcategoria){
        return view ('catalogos.categoria.show', ["categoria"=>categoriamodelo::findorfail($idcategoria)]); //muestra por id de Categoria
    }

    public function edit($idcategoria){
        return view ('catalogos.categoria.edit', ["categoria"=>categoriamodelo::findorfail($idcategoria)]);//paramtero recibido id
    }

    //Actualizar el objeto formulario
    public function update(categoriaFormRequest $request, $idcategoria){
        $categoria=categoriamodelo::findorfail($idcategoria);
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('catalogos/categoria');
    }
     
    //Eliminar
    public function destroy($idcategoria){
        categoriamodelo::destroy($idcategoria);   
        // $categoria=categoria::findorfail($idcategoria);
        //$categoria->update();
        // $status = '0';
        // DB::table('categoria')->where('idcategoria', $idcategoria)->update(array('status' => $status)); 
        return Redirect('catalogos/categoria');
    }

      //Consulta de llave foranea 
      public function todasCategorias(){
        $categoria =DB::table('categoria')
        ->orderBy('descripcion', 'asc');
        return view ('catalogos.categoria.todasCategorias', ["categoria"=>$categoria]);
}
}