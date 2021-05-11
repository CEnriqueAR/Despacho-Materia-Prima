<?php

namespace App\Http\Controllers;

use App\Calidad;
use App\Empleado;
use App\Exports\ExistenciaDiarioExports;
use App\Exports\ResumenCapaExport;
use App\Marca;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumenCapaController extends Controller
{

    public function index(Request $request)
    {

        if ($request){
            $query = trim($request->get("search"));

            $fecha = $request->get("fecha");

            if ($fecha == null) {
                $fecha = Carbon::now()->format('l');
                if ($fecha == 'Monday') {
                    $fecha = Carbon::now()->subDays(2)->format('Y-m-d');
                    $entregaCapa1=DB::table("capa_entregas")
                        ->leftJoin("empleados","capa_entregas.id_empleado","=","empleados.id")
                        ->leftJoin("vitolas","capa_entregas.id_vitolas","=","vitolas.id")
                        ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
                        ->leftJoin("marcas","capa_entregas.id_marca","=","marcas.id")
                        ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")


                        ->select("capa_entregas.id","empleados.nombre AS nombre_empleado",
                            "vitolas.name as nombre_vitolas","semillas.name as nombre_semillas",
                            "calidads.name as nombre_calidads",
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
                ->selectRaw("semillas.name as nombre_semilla")
                ->selectRaw("calidads.name as nombre_calidads")

                ->selectRaw("SUM(totalconsumo) as total_capa")
                ->selectRaw("SUM(pesoconsumo) as total_peso")
                ->groupBy('id_semillas' ,'id_calidad')
                ->whereDate("existencia_diarios.created_at","=" ,$fecha)
                ->orderBy("nombre_semilla")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();

            return view("InventariosDiarios.ResumenCapa")
                ->withNoPagina(1)
                ->withExistenciaDiaria($entregaCapa)
                ->withSemilla($semilla)
                ->withTamano($tamano)
                ->withCalidad($calidad);
        }

        //
    }
    public function export(Request $request)
    {

        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ResumenCapaExport($fecha))->download('Resumen de Capa'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ResumenCapaExport($fecha))->download('Resumen de Capa'.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ResumenCapaExport($fecha))->download('Resumen de Capa '.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    //
}
