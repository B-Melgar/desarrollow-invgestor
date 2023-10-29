<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
        //modelo
use App\User;
use Illuminate\Support\Facades\redirect;
        //archivo de solicitud
use App\Http\Requests\UsuarioFormRequest;
use DB;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this ->middleware ('auth');
    }

    public function index(Request $request)
    {
        if ($request) //al recibir solicitud
        {
            //cual sera el texto busquda   -que buscara lo ingresado en texto
            $query = trim($request->get('searchText'));
            //Variable :: La tabla         donde campo
            $usuarios =DB::table('users')->where('name','LIKE', '%'.$query.'%')->orderBy('id', 'desc')->paginate(10);
            //numero de elmentos mostrados por pagina     
            //Regresa la vista en folder.  //que paramtetros le enviare la variable previa					//que le enviamos como texto de busqueda la variable $query
            return view ('admin.usuario.index', ["usuarios"=>$usuarios, "searchText" =>$query]);
            }
     }

     public function create()
    {
            //Regresa la vista en folder.  //que paramtetros le enviare la variable previa					//que le enviamos como texto de busqueda la variable $query
            return view ('admin.usuario.create');
     }
                //recibe lo enviado dsd el formulario
     public function store(UsuarioFormRequest $request)
    {

            $Usuarios= new User;
            //Variable La tabla         donde campo
            $Usuarios->name=$request-> get('name');
            $Usuarios->email=$request-> get('email');
            $Usuarios->nombre=$request-> get('nombre');
            $Usuarios->apellido=$request-> get('apellido');
            $Usuarios->estado=$request-> get('estado');
            $Usuarios->tipo_Usuario=$request-> get('tipo_Usuario');
            $Usuarios->password=bcrypt($request-> get('password'));
            $Usuarios->save();

            //Regresa la vista en folder.  //que paramtetros le enviare la variable previa					//que le enviamos como texto de busqueda la variable $query
            return Redirect::to ('admin/usuario');
    }
                //envia parametro de usuario a modificar
        public function edit($id)
    {
                    return view ('admin.usuario.edit', ["usuarios"=>User::findorfail($id)]);
     }

                 //Actualizar        el objeto formulario y por medio del id a modificar
        public function update(UsuarioFormRequest $request, $id)
    {
    	$Usuarios=User::findorfail($id);
        $Usuarios->name=$request-> get('name');
        $Usuarios->email=$request-> get('email');
        $Usuarios->nombre=$request-> get('nombre');
        $Usuarios->apellido=$request-> get('apellido');
        $Usuarios->estado=$request-> get('estado');
        $Usuarios->password=bcrypt($request-> get('password')); //encriptar password
        $Usuarios->save();
    	
    	return Redirect::to('admin/usuario');
    }
     
        //Eliminar
        public function destroy($id)
    {
        $Usuarios= DB::table('users')->where('id', '=', $id)->delete();
        return Redirect('admin/usuario');
    }
}
