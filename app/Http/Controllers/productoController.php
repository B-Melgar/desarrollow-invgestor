<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\productoFormRequest; //request validacion
use App\Models\productomodelo;
use App\Models\categoriamodelo;
use App\Models\subcategoriamodelo;
use App\Models\productoStatusModel;
use App\Models\productoDetailStoreModel;

use DB;
use Carbon\Carbon;


class productoController extends Controller
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
            $_categoria = trim($request->get('_categoria'));
            $_subcategoria = trim($request->get('_subcategoria'));
            $producto = null;
            $producto = DB::table('producto')
            ->leftJoin('categoria','producto.idcategoria', '=','categoria.idcategoria')
            ->leftJoin('subcategoria','producto.idsubcategoria', '=','subcategoria.idsubcategoria')
            ->select('producto.idproducto', 'producto.codigoproducto', 'producto.descripcionproducto',
                    DB::raw('FORMAT(producto.preciocosto,2) as preciocosto'),  DB::raw('FORMAT(producto.precioventa,2) as precioventa'), 'producto.compras', 'producto.ventas', 'producto.existencia', 'producto.estado',
                    'producto.idcategoria', 'categoria.descripcion', 'producto.idsubcategoria', 
                    'subcategoria.descripcionsubcategoria', )
            ->where('producto.descripcionproducto','LIKE', '%'.$query.'%')   
            ->where('producto.estado','=', '1');
            if (!empty($_categoria)){
                $producto = $producto->whereRaw('producto.idcategoria = '.$_categoria);
            } 
            if (!empty($_subcategoria)){
                $producto = $producto->whereRaw('producto.idsubcategoria = '.$_subcategoria);
                dd("categoria ".$_subcategoria);
            }   
            $producto = $producto->orderBy('producto.idproducto', 'asc')->paginate(10);
            return view ('inventario.producto.index', ["producto"=>$producto, "searchText"=>$query, "_categoria"=>$_categoria, "_subcategoria" =>$_subcategoria]);
        }
    }

    public function viewRender(Request $request)
    {
        $viewRender = view('viewRend')->render();
    return response()->json(array('success' => true, 'html'=>$viewRender));
    }

    public function create(){	
        return view("inventario.producto.create");
    }

    //Guardar el objeto a BD para validar
    public function store(productoFormRequest $request){
        //nuevo objeto
        $productomodelo= new productomodelo;
        //$productomodelo->idproducto=$request->get('idproducto');
        $productomodelo->codigoproducto=$request->get('codigoproducto');
        $productomodelo->descripcionproducto=$request->get('descripcionproducto');
        $productomodelo->preciocosto=$request->get('preciocosto');
        $productomodelo->precioventa=$request->get('precioventa');
        $productomodelo->compras=$request->get('compras');
        $productomodelo->ventas=$request->get('ventas');
        $productomodelo->existencia=$request->get('existencia');
        $productomodelo->idcategoria=$request->get('idcategoria');
        $productomodelo->idsubcategoria=$request->get('idsubcategoria');
        $productomodelo->estado='1';
        $productomodelo->save(); //Guardar o almacenar
        $latestidproducto = $productomodelo->idproducto;
        $pathPhoto ='';
        if($request->hasFile('photo'))
        {
            $file=$request->file('photo');  //rutadonde movere      //metodo para poner nombre de archivo
            $file->move(public_path(). '/images/imagesproducto/', $latestidproducto .'_'.  time() .'_'. $file->getClientOriginalName());
            $pathPhoto = '/images/imagesproducto/'. $latestidproducto .'_'.  time() .'_'. $file->getClientOriginalName();
        }else{
            $pathPhoto ='';
        }
        DB::table('producto')->where('idproducto', $latestidproducto)->update(array('photo' => $pathPhoto));  
        return Redirect::to('inventario/producto'); //retorna al usuario a listado de grados a URL	
    }

    public function show($idproducto){
        return view ('inventario.producto.show', ["producto"=>productomodelo::findorfail($idproducto)]); //muestra por id de Categoria
    }

    public function edit($idproducto){
        return view ('inventario.producto.edit', ["producto"=>productomodelo::findorfail($idproducto)]);//paramtero recibido id
    }

   
    //Actualizar el objeto formulario
    public function update(productoFormRequest $request, $idproducto){
        // dd($request->get('existencia'),$request->get('idcategoria'),$request->get('idsubcategoria'));
        // dd($request->get('idsubcategoria'));
        // die();
        $productomodelo=productomodelo::findorfail($idproducto);
        $productomodelo->codigoproducto=$request->get('codigoproducto');
        $productomodelo->descripcionproducto=$request->get('descripcionproducto');
        $productomodelo->preciocosto=$request->get('preciocosto');
        $productomodelo->precioventa=$request->get('precioventa');
        $productomodelo->compras=$request->get('compras');
        $productomodelo->ventas=$request->get('ventas');
        $productomodelo->existencia=$request->get('existencia');
        $productomodelo->idcategoria=$request->get('idcategoria');
        $productomodelo->idsubcategoria=$request->get('idsubcategoria');
        $productomodelo->estado='1';
       
        if($request->hasFile('photo'))
        {
            //$file->move(public_path(). '/images/imagesproducto/', $idproducto .'_'.  time() .'_'. $file->getClientOriginalName());
            //$productomodelo->photo= '/images/imagesproducto/'. $idproducto .'_'.  time() .'_'. $file->getClientOriginalName();
        }
        $productomodelo->update();
        return Redirect::to('inventario/producto');
    }
     
    //Eliminar
    public function destroy($idproducto){
        $estado = '0';
        DB::table('producto')->where('idproducto', $idproducto)->update(array('estado' => $estado));  
        return Redirect('inventario/producto');
    }

    //Llena select o combo sub categorias
    public function getSubCategoria(Request $request){
        if(isset($request->texto)){
            $subCategorias = subcategoriamodelo::whereidcategoria($request->texto)->get();
            return response()->json(
                [
                    'lista' => $subCategorias,
                    'success' => true
                ]);
        }else{
            return response()->json(
            [
                'success' => false
            ]);
        }
        //return  view ('inventario.producto.create', compact("subcategorias"));
    }

    public function getSubCategoria1(Request $request){
        if($request->ajax()){
            $subCategoria = subCategoryModel::where('idcategoria', $request->idcategoria)->get();
            foreach($subCategoria as $subcategoria){
                $invSubCategoriesArray[$subcategoria->idsubcategoria] = $subcategoria->descripctionSubCategory;
            }
            return response()->json(invSubCategoriesArray);
        }
    }

    public function getSubCategoria2($idcategoria){
        $subcategoria =DB::table('subcategoria')
            ->where('idcategoria', '=', $idcategoria)
            ->orderBy('descripcion', 'asc')
            ->get();

        return response()->json(array('success' => true, 'data' => $subcategoria));
        }

        public function post(Request $request){
            $subcategoria = DB::table('subcategoria')
            ->leftJoin('categoria','subcategoria.idcategoria', '=','categoria.idcategoria')
            ->select('subcategoria.idcategoria', 'categoria.descripcion', 'subcategoria.idsubcategoria', 
            'subcategoria.descripcionsubcategoria')
            ->where('subcategoria.idcategoria','=', $request->message)   
            ->orderBy('subcategoria.descripcionsubcategoria', 'asc')
            ->get();

            $response = array(
                'status' => 'success',
                'lista' => $subcategoria,
            );
            return response()->json($response); 
         }

        public function productObsoleteCategory(Request $request){
           
            $subcategoria = DB::table('producto')
            ->leftJoin('categoria','producto.idcategoria', '=','categoria.idcategoria')
            ->select('producto.idproducto', 'producto.descripcionproducto', 'categoria.idcategoria', 
            'categoria.descripcion')
            ->where('producto.idcategoria','=', $request->message)   
            ->orderBy('producto.descripcionproducto', 'asc')
            ->get();

            $response = array(
                'status' => 'success',
                'lista' => $subcategoria,
            );
            return response()->json($response); 
         }
    
    }