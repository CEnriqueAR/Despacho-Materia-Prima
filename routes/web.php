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

        //--------------------------------------------vitola ROUTES-------------------------------------------------------->
        Route::get("/vitola","VitolaController@index1")->name("vitola");
        Route::post("/vitola/nuevo","VitolaController@storeVitola1")->name("vitolanueva");
        Route::put("/vitola/editar","VitolaController@editarVitola1")->name("vitolaeditar");
        Route::delete("/vitola/borrar","VitolaController@borrarVitola1")->name("vitolaBorrar");




    });




//--------------------------------------------mildaware Despacho de tripa y banda------------------------------------------------------
//--------------------------------------------mildaware Despacho de tripa y bandaS------------------------------------------------------

    Route::group(['middleware' => 'banda'], function () {
        Route::get('/DesBanda', 'DesBanda@index')->name('DesBanda.index');




        //--------------------------------------------Empleados BANDA ROUTES-------------------------------------------------------->
        Route::get("/empleadosBanda","EmpleadoBandaController@index")->name("empleadosBanda");
        Route::post("/empleadoBanda/nuevo","EmpleadoBandaController@storeEmpleado")->name("nuevoEmpleadoBanda");
        Route::put("/empleadoBanda/editar","EmpleadoBandaController@editarEmpleado")->name("editarempleadoBanda");
        Route::delete("/empleadoBanda/borrar","EmpleadoBandaController@borrarEmpleado")->name("borrarEmpleadoBanda");

        //--------------------------------------------Marca BANDA ROUTES-------------------------------------------------------->
        Route::get("/marcasBanda","MarcaBandaController@index")->name("marcasBanda");
        Route::post("/marcasBanda/nuevo","MarcaBandaController@storeMarca")->name("nuevaMarcaBanda");
        Route::put("/marcasBanda/editar","MarcaBandaController@editarMarca")->name("editarMarcaBanda");
        Route::delete("/marcasBanda/borrar","MarcaBandaController@borrarMarca")->name("borrarMarcaBanda");

        //--------------------------------------------Semilla  BANDA ROUTES-------------------------------------------------------->
        Route::get("/semillasBanda","SemillaController@index1")->name("semillasBanda");
        Route::post("/semillasBanda/nuevo","SemillaController@storeSemilla1")->name("nuevasemillasBanda");
        Route::put("/semillasBanda/editar","SemillaController@editarSemilla1")->name("editarsemillasBanda");
        Route::delete("/semillasBanda/borrar","SemillaController@borrarSemilla1")->name("borrarsemillasBanda");

        //--------------------------------------------vitola  BANDA ROUTES-------------------------------------------------------->
        Route::get("/vitolaBanda","VitolaController@index")->name("vitolaBanda");
        Route::post("/vitolaBanda/nuevo","VitolaController@storeVitola")->name("vitolanuevaBanda");
        Route::put("/vitolaBanda/editar","VitolaController@editarVitola")->name("vitolaeditarBanda");
        Route::delete("/vitolaBanda/borrar","VitolaController@borrarVitola")->name("vitolaBorrarBanda");
        //--------------------------------------------Bulto  Tripa ROUTES-------------------------------------------------------->
        Route::get("/BultoSalida","BultosSalidaController@index")->name("BultoSalida");
        Route::post("/BultoSalida/nuevo","BultosSalidaController@store")->name("BultoSalidanueva");
        Route::put("/BultoSalida/editar","BultosSalidaController@edit")->name("BultoSalidaeditar");
        Route::delete("/BultoSalida/borrar","BultosSalidaController@destroy")->name("BultoSalidaborrar");
        //--------------------------------------------Sumar Bultos ROUTES-------------------------------------------------------->
        Route::put('/BultosSalida/1', 'BultosSalidaController@Suma')->name("sumarBulto");

        //--------------------------------------------CapaEntregaExportar ROUTES-------------------------------------------------------->
        Route::post('/BultoEntrega/export', 'BultosSalidaController@export')->name("exportarbultoentrega");
        Route::get('/BultoEntrega/export', 'BultosSalidaController@export')->name("exportarbultoentrega");
        Route::post('/BultoEntrega/exportPDF', 'BultosSalidaController@exportpdf')->name("exportarbultoentregapdf");
        Route::get('/BultoEntrega/exportPDF', 'BultosSalidaController@exportpdf')->name("exportarbultoentregapdf");
        Route::post('/BultoEntrega/exportCVS', 'BultosSalidaController@exportcvs')->name("exportarbultoentregaacvs");
        Route::get('/BultoEntrega/exportCVS', 'BultosSalidaController@exportcvs')->name("exportarbultoentregacvs");
        //--------------------------------------------Bulto  Tripa  Devueltos ROUTES-------------------------------------------------------->
        Route::get("/BultoDevuelto","BultosDevueltoController@index")->name("BultoDevuelto");
        Route::post("/BultoDevuelto/nuevo","BultosDevueltoController@store")->name("BultoDevueltonueva");
        Route::put("/BultoDevuelto/editar","BultosDevueltoController@edit")->name("BultoDevueltoeditar");
        Route::delete("/BultoDevuelto/borrar","BultosDevueltoController@destroy")->name("BultoDevueltoborrar");
        //--------------------------------------------Bulto Devuelto ROUTES-------------------------------------------------------->
        Route::post('/BultoDevuelto/export', 'BultosDevueltoController@export')->name("exportarbultodevuelto");
        Route::get('/BultoDevuelto/export', 'BultosDevueltoController@export')->name("exportarbultodevuelto");
        Route::post('/BultoDevuelto/exportPDF', 'BultosDevueltoController@exportpdf')->name("exportarbultodevueltopdf");
        Route::get('/BultoDevuelto/exportPDF', 'BultosDevueltoController@exportpdf')->name("exportarbultodevueltopdf");
        Route::post('/BultoDevuelto/exportCVS', 'BultosDevueltoController@exportcvs')->name("exportarbultodevueltocvs");
        Route::get('/BultoDevuelto/exportCVS', 'BultosDevueltoController@exportcvs')->name("exportarbultodevueltocvs");
//--------------------------------------------Consumo De Banda ROUTES-------------------------------------------------------->
        Route::get('/ConsumoBanda', 'ConsumoBandaController@index')->name("ConsumoBanda");
        Route::post("/ConsumoBanda/nuevo","ConsumoBandaController@store")->name("ConsumoBandanueva");
        Route::put("/ConsumoBanda/editar","ConsumoBandaController@edit")->name("ConsumoBandaeditar");
        Route::delete("/ConsumoBanda/borrar","ConsumoBandaController@destroy")->name("ConsumoBandaborrar");
        //--------------------------------------------Consumo De Bnada Exportar ROUTES-------------------------------------------------------->
        Route::post('/ConsumoBanda/export', 'ConsumoBandaController@export')->name("exportarconsumobanda");
        Route::get('/ConsumoBanda/export', 'ConsumoBandaController@export')->name("exportarconsumobanda");
        Route::post('/ConsumoBanda/exportPDF', 'ConsumoBandaController@exportpdf')->name("exportarconsumobandapdf");
        Route::get('/ConsumoBanda/exportPDF', 'ConsumoBandaController@exportpdf')->name("exportarconsumobandapdf");
        Route::post('/ConsumoBanda/exportCVS', 'ConsumoBandaController@exportcvs')->name("exportarconsumobandacvs");
        Route::get('/ConsumoBanda/exportCVS', 'ConsumoBandaController@exportcvs')->name("exportarconsumobandacvs");




    });
//--------------------------------------------mildaware Admin------------------------------------------------------
    //--------------------------------------------mildaware Admin------------------------------------------------------

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/registro', function () {
            return view('auth.registro');})->name('registro');

        Route::post('/Usuario/registrar', 'Usuario@agregarUsuario')->name('registrarUsuario');
    });



});



