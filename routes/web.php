<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Auth/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', 'HomeController@index');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
Route::get('/{slug?}', 'HomeController@index'); //para controlar rutas ingresadas por usuario no existentes

Route::resource('admin/usuario', 'UsuarioController');
Route::resource('/admin/dash', 'DashbController');
// Route::get('admin/dash', 'App\Http\Controllers\DashbController@index');

//catalogos
Route::resource('catalogos/categoria', 'categoriaController');
Route::resource('catalogos/subcategoria', 'subcategoriaController');
Route::resource('catalogos/tipotransaccion', 'tipotransaccionController');

//proveedor
Route::resource('inventario/proveedor', 'proveedorController');

//COMPRA
Route::resource('inventario/transaccioncompra', 'transaccioncompraController');
Route::get('listadetalletransaccioncompra/{idtransaccion}','transacciondetallecompraController@detalletransacciondata');
Route::get('inventario/transaccioncompra/listadetalletransaccioncompra/{idtransaccion}','transacciondetallecompraController@detalletransacciondata');
Route::post('/postdetallecompra','transacciondetallecompraController@agregardetallecompra');
Route::post('/postdetallecompra','transacciondetallecompraController@edit');
Route::post('/postquitardetallecompra','transacciondetallecompraController@borrardetallecompra');
Route::post('/postaplicardetallecompra','transacciondetallecompraController@aplicarcompra');
Route::post('/postanulardetallecompra','transacciondetallecompraController@anularcompra');

//VENTA
Route::resource('inventario/transaccionventa', 'transaccionventaController');
Route::get('listadetalletransaccionventa/{idtransaccion}','transacciondetalleventaController@detalletransacciondataventa');
Route::get('inventario/transaccionventa/listadetalletransaccionventa/{idtransaccion}','transacciondetalleventaController@detalletransacciondataventa');
Route::post('/postdetalleventa','transacciondetalleventaController@agregardetalleventa');
Route::post('/postdetalleventaedit','transacciondetalleventaController@edit');
Route::post('/postquitardetalleventa','transacciondetalleventaController@borrardetalleventa');
Route::post('/postaplicardetalleventa','transacciondetalleventaController@aplicarventa');
Route::post('/postanulardetalleventa','transacciondetalleventaController@anularventa');


//ORDEN COMPRA
Route::resource('inventario/ordencompra', 'ordencompraController');
//Route::resource('inventario/ordencompra', 'ordencompraController@edit');
Route::get('listadetalleordencompra/{idordencompra}','ordencompradetalleController@detalleordencompradata');
Route::get('inventario/ordencompra/listadetalleordencompra/{idordencompra}','ordencompradetalleController@detalleordencompradata');
Route::post('/postdetalleordencompra','ordencompradetalleController@agregardetalleordencompra');
Route::post('/postdetalleordencompraedit','ordencompradetalleController@edit');
Route::post('/postquitardetalleordencompra','ordencompradetalleController@borrardetalleordencompra' );
Route::post('/postaplicardetalleordencompra','ordencompradetalleController@ aplicarordencompra');
Route::post('/postanulardetalleordencompra','ordencompradetalleController@anularordencompra');
Route::post('/postimprimirordencompra','ordencompradetalleController@imprimirordencompra');

//cliente
Route::resource('inventario/cliente', 'clienteController');
//ordenes compra
//Route::resource('ordenescompra/ordencompra', 'ordencompraController');

//Product
Route::put('inventario/producto',[App\Http\Controllers\productoController::class, 'getSubCategory']);
Route::resource('inventario/producto', 'productoController');
Route::post('/postajax','productoController@post');


//Security
Route::resource('seguridad/segrol', 'segrolController');
Route::resource('seguridad/empleado', 'empleadoController');
Route::resource('seguridad/segusuario', 'segusuarioController');
Route::resource('seguridad/segusuariorol', 'segusuariorolController');
Route::resource('seguridad/segmenu', 'segmenuController');
Route::resource('seguridad/segopcion', 'segopcionController');
Route::resource('seguridad/segasignacionopcion', 'segasignacionopcionController');

Route::get('/admin', function(){
    return 'InvGestor!!!';
});



//REPORTES
//Orden de Compra
Route::get('comPurchaseOrderList/{id}/createPurchaseOrder', 'comPurchaseOrderListController@createPurchaseOrder');

Route::resource('panelreporte/panelreporte', 'reporteController');

Route::post('/postimprimirinventarioproducto','reporteController@imprimirinventarioproducto');

