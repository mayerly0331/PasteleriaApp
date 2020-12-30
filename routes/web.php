<?php

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

// Route::get('/', function () {
//     return view('contenido/contenido');
// });

Route::group(['middleware' => ['guest']], function () { //Para los que no se han autenticado
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});


Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    // Route::get('/dashboard', 'DashboardController');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Vendedor']], function () {

        Route::get('/cliente', 'ClientesController@index');
        Route::get('/cliente/selectCli', 'ClientesController@selectCli');
        Route::post('/cliente/registrar', 'ClientesController@store');
        Route::put('/cliente/actualizar', 'ClientesController@update');
        Route::post('/cliente/eliminar', 'ClientesController@destroy');


        Route::get('/factura', 'FacturasController@index');
        Route::post('/factura/registrar', 'FacturasController@store');
        Route::put('/factura/desactivar', 'FacturasController@desactivar');
        Route::get('/factura/obtenerDatos', 'FacturasController@obtenerDatos');
        Route::get('/factura/obtenerDetalles', 'FacturasController@obtenerDetalles');

        Route::get('/encargos', 'EncargosController@index');
        Route::get('/encargos/obtenerDatos', 'EncargosController@obtenerDatos');
        Route::get('/encargos/obtenerDetalles', 'EncargosController@obtenerDetalles');
        Route::post('/encargos/registrar', 'EncargosController@store');
        Route::put('/encargos/desactivarEncargo', 'EncargosController@desactivar');
        
        Route::get('/producto', 'ProductosController@index');
        Route::get('/producto/buscarProducto', 'ProductosController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductosController@listarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductosController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductosController@listarProductoVenta');
        Route::post('/producto/registrar', 'ProductosController@store');
        Route::post('/producto/eliminar', 'ProductosController@destroy');
        Route::put('/producto/actualizar', 'ProductosController@update');
    });
    Route::group(['middleware' => ['Administrador']], function () {

        Route::get('/cliente', 'ClientesController@index');
        Route::get('/cliente/selectCli', 'ClientesController@selectCli');
        Route::post('/cliente/registrar', 'ClientesController@store');
        Route::put('/cliente/actualizar', 'ClientesController@update');
        Route::post('/cliente/eliminar', 'ClientesController@destroy');
        
        Route::get('/factura', 'FacturasController@index');
        Route::post('/factura/registrar', 'FacturasController@store');
        Route::put('/factura/desactivar', 'FacturasController@desactivar');
        Route::get('/factura/obtenerDatos', 'FacturasController@obtenerDatos');
        Route::get('/factura/obtenerDetalles', 'FacturasController@obtenerDetalles');

        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');   
        Route::post('/user/eliminar', 'UserController@destroy');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        Route::get('/rol', 'RolesController@index');
        Route::get('/rol/selectRol', 'RolesController@selectRol');

        Route::get('/producto', 'ProductosController@index');
        Route::get('/producto/buscarProducto', 'ProductosController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductosController@listarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductosController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductosController@listarProductoVenta');
        Route::post('/producto/registrar', 'ProductosController@store');
        Route::post('/producto/eliminar', 'ProductosController@destroy');
        Route::put('/producto/actualizar', 'ProductosController@update');

        Route::get('/encargos', 'EncargosController@index');
        Route::get('/encargos/obtenerDatos', 'EncargosController@obtenerDatos');
        Route::get('/encargos/obtenerDetalles', 'EncargosController@obtenerDetalles');
        Route::post('/encargos/registrar', 'EncargosController@store');
        Route::put('/encargos/desactivarEncargo', 'EncargosController@desactivar');
    });


});
