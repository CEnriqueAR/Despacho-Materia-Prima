<?php

namespace App\Http\Controllers;

use App\Calidad;
use App\Empleado;
use App\ExistenciaDiario;
use App\Marca;
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

            if ($fecha = null)
                $fecha = Carbon::now()->format('Y-m-d');
            else{
                $fecha = $request->get("fecha");

            }

            $entregaCapa=DB::table("existencia_diarios")
                ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
                ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","capa_entregas.id_tamano","=","tamanos.id")


                ->select("capa_entregas.id","semillas.name as nombre_semillas",
                    "calidads.name as nombre_calidads",
                    "capa_entregas.id_tamano","tamanos.name as nombre_tamano",
                    "capa_entregas.id_semilla",
                    "capa_entregas.id_calidad"
                    ,"capa_entregas.totalinicial","capa_entregas.pesoinicial"
                    ,"capa_entregas.totalentrada","capa_entregas.pesoentrada"
                    ,"capa_entregas.totalfinal","capa_entregas.pesofinal",
                    "capa_entregas.totalconsumo","capa_entregas.pesoconsumo")
                ->whereDate("capa_entregas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))

                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();
     ;

            return view("EntregaDeCapa.CapaEntrega")
                ->withNoPagina(1)
                ->withEntregaCapa($entregaCapa)
                ->withSemillas($semilla)
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
