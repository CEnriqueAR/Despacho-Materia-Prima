<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
Auth::routes();



Route::group(["middleware" => "auth"], function () {

    Route::get('/', function () {
        return view('index');


    });




    Route::get('/prnpriview','PrintEmpleadoController@prnpriview')->name("imprimirEmpleado");







//--------------------------------------------mildware de Capa------------------------------------------------------
    //--------------------------------------------Mildware de Capa------------------------------------------------------
    Route::group(['middleware' => 'capa'], function () {

        Route::get('/DesCapa', 'DesCapa@index')->name('DesCapa.index');

        //--------------------------------------------Empleados ROUTES-------------------------------------------------------->
        Route::get("/empleados","EmpleadoController@index")->name("empleados");
        Route::post("/empleado/nuevo","EmpleadoController@storeEmpleado")->name("nuevoEmpleado");
        Route::put("/empleados/editar","EmpleadoController@editarEmpleado")->name("editarempleado");
        Route::delete("/empleado/borrar","EmpleadoController@borrarEmpleado")->name("borrarEmpleado");
        //--------------------------------------------EmpleadosExportar ROUTES-------------------------------------------------------->

        Route::get('/empleados/export', 'EmpleadosExportController@export')->name("exportarEmpleado");
        Route::get('/empleados/exportPDF', 'EmpleadosExportController@exportpdf')->name("exportarEmpleadopdf");
        Route::get('/empleados/exportCVS', 'EmpleadosExportController@exportcvs')->name("exportarEmpleadocvs");

        //--------------------------------------------Marca ROUTES-------------------------------------------------------->
        Route::get("/marcas","MarcaController@index")->name("marcas");
        Route::post("/marcas/nuevo","MarcaController@storeMarca")->name("nuevaMarca");
        Route::put("/marcas/editar","MarcaController@editarMarca")->name("editarMarca");
        Route::delete("/marcas/borrar","MarcaController@borrarMarca")->name("borrarMarca");
        //--------------------------------------------Semilla ROUTES-------------------------------------------------------->
        Route::get("/semillas","SemillaController@index")->name("semillas");
        Route::post("/semillas/nuevo","SemillaController@storeSemilla")->name("nuevasemillas");
        Route::put("/semillas/editar","SemillaController@editarSemilla")->name("editarsemillas");
        Route::delete("/semillas/borrar","SemillaController@borrarSemilla")->name("borrarsemillas");

        //--------------------------------------------CapaEntrega ROUTES------------------------------------------------------
        Route::post("/CapaEntrega/nuevo","CapaEntregaController@StoreEntrega")->name("nuevoCapaEntrega");
        Route::get("/CapaEntrega", "CapaEntregaController@index")->name("CapaEntrega");//Muestra el servicio de las empresas
        Route::put("/CapaEntrega/editar","CapaEntregaController@editCapaEntrega")->name("editarCapaEntrega");
        Route::delete("/CapaEntrega/borrar","CapaEntregaController@destroy")->name("borrarCapaEntrega");

        //--------------------------------------------CapaEntregaExportar ROUTES-------------------------------------------------------->
        Route::post('/CapaEntrega/export', 'CapaEntregaController@export')->name("exportarcapaentrega");
        Route::get('/CapaEntrega/export', 'CapaEntregaController@export')->name("exportarcapaentrega");
        Route::post('/CapaEntrega/exportPDF', 'CapaEntregaController@exportpdf')->name("exportarcapaentregapdf");
        Route::get('/CapaEntrega/exportPDF', 'CapaEntregaController@exportpdf')->name("exportarcapaentregapdf");
        Route::post('/CapaEntrega/exportCVS', 'CapaEntregaController@exportcvs')->name("exportarcapaentregaacvs");
        Route::get('/CapaEntrega/exportCVS', 'CapaEntregaController@exportcvs')->name("exportarcapaentregacvs");
        //--------------------------------------------CapaEntrega ROUTES------------------------------------------------------
        Route::put("/CapaEntrega/25","CapaEntregaController@Suma25")->name("Suma25CapaEntrega");
        Route::put("/CapaEntrega/50","CapaEntregaController@Suma50")->name("Suma50CapaEntrega");
        Route::put("/CapaEntrega/suma","CapaEntregaController@Sumas")->name("SumasCapaEntrega");

        //--------------------------------------------Recibir Capa ROUTES-------------------------------------------------------->
        Route::get("/RecepcionCapa","RecibirCapaController@index")->name("RecepcionCapa");
        Route::post("/RecepcionCapa/nuevo","RecibirCapaController@storeRecepcionCapa")->name("nuevaRecepcionCapa");
        Route::put("/RecepcionCapa/editar","RecibirCapaController@editarRecepcionCapa")->name("editarRecepcionCapa");
        Route::delete("/RecepcionCapa/borrar","RecibirCapaController@borrarRecepcionCapa")->name("borrarRecepcionCapa");
        //--------------------------------------------RECIBIRCAPAExportar ROUTES-------------------------------------------------------->
        Route::post('/RecepcionCapa/export', 'RecibirCapaController@export')->name("exportarRecibircapa");
        Route::get('/RecepcionCapa/export', 'RecibirCapaController@export')->name("exportarRecibircapa");
        Route::post('/RecepcionCapa/exportPDF', 'RecibirCapaController@exportpdf')->name("exportarRecibircapapdf");
        Route::get('/RecepcionCapa/exportPDF', 'RecibirCapaController@exportpdf')->name("exportarRecibircapapdf");
        Route::post('/RecepcionCapa/exportCVS', 'RecibirCapaController@exportcvs')->name("exportarRecibircapacvs");
        Route::get('/RecepcionCapa/exportCVS', 'RecibirCapaController@exportcvs')->name("exportarRecibircapacvs");
        //--------------------------------------------Sumar Capa ROUTES-------------------------------------------------------->
        Route::put('/RecepcionCapa/200', 'RecibirCapaController@Suma200')->name("sumar200Recibircapa");
        Route::put('/RecepcionCapa/50', 'RecibirCapaController@Suma50')->name("sumar50Recibircapa");
        Route::put('/RecepcionCapa/sumar', 'RecibirCapaController@Sumas')->name("sumarRecibircapa");
        //--------------------------------------------PESOS ROUTES-------------------------------------------------------->
        Route::get("/peso","PesoController@index")->name("peso");
        Route::post("/peso/nuevo","PesoController@StorePeso")->name("nuevopeso");
        Route::put("/peso/editar","PesoController@editarPeso")->name("editarpeso");
        Route::delete("/peso/borrar","PesoController@destroy")->name("borrarpeso");





    });




//--------------------------------------------mildaware Despacho de tripa y banda------------------------------------------------------
//--------------------------------------------mildaware Despacho de tripa y bandaS------------------------------------------------------

    Route::group(['middleware' => 'banda'], function () {
        Route::get('/DesBanda', 'DesBanda@index')->name('DesBanda.index');

    });
//--------------------------------------------mildaware Admin------------------------------------------------------
    //--------------------------------------------mildaware Admin------------------------------------------------------

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/registro', function () {
            return view('auth.registro');})->name('registro');

        Route::post('/Usuario/registrar', 'Usuario@agregarUsuario')->name('registrarUsuario');
    });



});



