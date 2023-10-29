<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\subcategoriamodelo;

class commonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        return view('layouts.home');
    }

        //Llena select o combo sub categorias
        public function getSubCategory(Request $request){
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
    
}
