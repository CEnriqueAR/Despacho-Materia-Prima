<?php

namespace App\Http\Controllers;

use App\Calidad;
use App\CapaEntrega;
use App\Empleado;
use App\ExistenciaDiario;
use App\Marca;
use App\ReBulDiario;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExistenciaDiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request){
            $query = trim($request->get("search"));

            $fecha = $request->get("fecha");

            if ($fecha == null) {
                $fecha = Carbon::now()->format('l');
                if ($fecha = 'Monday') {
                    $fecha = Carbon::now()->subDays(2)->format('Y-m-d');
                    $entregaCapa1=DB::table("capa_entregas")
                        ->leftJoin("empleados","capa_entregas.id_empleado","=","empleados.id")
                        ->leftJoin("vitolas","capa_entregas.id_vitolas","=","vitolas.id")
                        ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
                        ->leftJoin("marcas","capa_entregas.id_marca","=","marcas.id")
                        ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")
                        ->leftJoin("tamanos","capa_entregas.id_tamano","=","tamanos.id")


                        ->select("capa_entregas.id","empleados.nombre AS nombre_empleado",
                            "vitolas.name as nombre_vitolas","semillas.name as nombre_semillas",
                            "calidads.name as nombre_calidads",
                            "capa_entregas.id_tamano","tamanos.name as nombre_tamano",
                            "capa_entregas.id_empleado",
                            "capa_entregas.id_vitolas",
                            "capa_entregas.id_semilla",
                            "capa_entregas.id_calidad",
                            "capa_entregas.id_marca","marcas.name as nombre_marca"
                            ,"capa_entregas.total")
                        ->whereDate("capa_entregas.created_at","=" ,$fecha)
                        ->get();
                    if ($entregaCapa1->count()>0){

                    }
                    else{
                        $fecha = Carbon::now()->subDays(3)->format('Y-m-d');
                    }

                } else {
                    $fecha = Carbon::now()->subDay()->format('Y-m-d');
                }
            } else{

                $fecha = $request->get("fecha");

            }

            $entregaCapa=DB::table("existencia_diarios")
                ->leftJoin("semillas","existencia_diarios.id_semillas","=","semillas.id")
                ->leftJoin("calidads","existencia_diarios.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","existencia_diarios.id_tamano","=","tamanos.id")
                ->select("existencia_diarios.id","semillas.name as nombre_semillas",
                    "calidads.name as nombre_calidads",
                    "existencia_diarios.id_tamano","tamanos.name as nombre_tamano",
                    "existencia_diarios.id_semillas",
                    "existencia_diarios.id_calidad"
                    ,"existencia_diarios.totalinicial","existencia_diarios.pesoinicial"
                    ,"existencia_diarios.totalentrada","existencia_diarios.pesoentrada"
                    ,"existencia_diarios.totalfinal","existencia_diarios.pesofinal",
                    "existencia_diarios.totalconsumo","existencia_diarios.pesoconsumo"
                    ,"existencia_diarios.onzas")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("existencia_diarios.created_at","=" ,$fecha)
                ->orderBy("nombre_semillas")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();

            if ($entregaCapa->count()>0){

            }else{
                $inve  =  DB::table('c_inv_inicials')
                    ->leftJoin("semillas","c_inv_inicials.id_semilla","=","semillas.id")
                    ->leftJoin("calidads","c_inv_inicials.id_calidad","=","calidads.id")
                    ->leftJoin("tamanos","c_inv_inicials.id_tamano","=","tamanos.id")

                    ->select(
                        "c_inv_inicials.id",
                       "semillas.name as nombre_semillas",
                        "calidads.name as nombre_calidads",
                        "c_inv_inicials.id_tamano","tamanos.name as nombre_tamano",
                        "c_inv_inicials.id_semilla",
                        "c_inv_inicials.id_calidad"
                        ,"c_inv_inicials.totalinicial"
                    )->get();

                $fecha1 = $request->get("fecha");
                if ($fecha1 == null) {
                    $fecha1 = Carbon::now()->format('Y-m-d');

                }else{
                    Carbon::parse($fecha1)->format('Y-m-d');

                }
                foreach ($inve as $inventario){
                    $nuevoConsumo = new ExistenciaDiario();
                    $nuevoConsumo->id_semillas = $inventario->id_semilla;
                    $nuevoConsumo->id_calidad = $inventario->id_calidad;
                    $nuevoConsumo->id_tamano = $inventario->id_tamano;
                    $nuevoConsumo->totalinicial = $inventario->totalinicial;

                    $nuevoConsumo->created_at = $fecha;
                    $nuevoConsumo->save();
                }
            }

            foreach ($entregaCapa as $entrega){
                if ($entrega->totalentrada == null or '0'){

                    $recibirCapa=DB::table("recibir_capas")
                        ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                        ->leftJoin("tamanos","recibir_capas.id_tamano","=","tamanos.id")
                        ->leftJoin("calidads","recibir_capas.id_calidad","=","calidads.id")

                        ->select("recibir_capas.id","tamanos.name AS nombre_tamano",
                            "recibir_capas.id_tamano",
                            "recibir_capas.id_calidad","calidads.name as nombre_calidad",
                            "recibir_capas.id_semillas","semillas.name as nombre_semillas","recibir_capas.total")
                        ->where("recibir_capas.id_semillas","=",$entrega->id_semillas)
                        ->where("recibir_capas.id_tamano","=",$entrega->id_tamano)
                        ->where("recibir_capas.id_calidad","=",$entrega->id_calidad)
                        ->whereDate("recibir_capas.created_at","=" ,$fecha)->get();
                foreach ($recibirCapa as $reci){

                    $editarCapaEntrega=ExistenciaDiario::findOrFail($entrega->id);

                    $editarCapaEntrega->totalentrada = $reci->total;
                    $editarCapaEntrega->save();

                }

                }



            }


            return view("InventariosDiarios.ExistenciaDiario")
                ->withNoPagina(1)
                ->withExistenciaDiaria($entregaCapa)
                ->withSemilla($semilla)
                ->withTamano($tamano)
                ->withCalidad($calidad);

        }
        //
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function show(ExistenciaDiario $existenciaDiario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function edit(ExistenciaDiario $existenciaDiario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExistenciaDiario $existenciaDiario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExistenciaDiario $existenciaDiario)
    {
        //
    }
}
