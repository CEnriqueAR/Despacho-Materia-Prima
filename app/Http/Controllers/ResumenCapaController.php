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

        if ($request) {
            $query = trim($request->get("search"));
            $fecha1 = trim($request->get("fecha1"));
            $fecha2 = trim($request->get("fecha2"));
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
                ->orderBy("nombre_semilla")
                ->when($fecha1 && $fecha2, function ($query) use ($fecha1, $fecha2) {
                    $query->whereBetween('existencia_diarios.created_at', [$fecha1, $fecha2]);})
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


        //
    }
    public function export(Request $request)
    {

        $fecha1 = $request->get("fecha1");
        $fecha2 = $request->get("fecha2");
        return (new ResumenCapaExport($fecha1,$fecha2))->download('Resumen de Capa'.$fecha1.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {

        $fecha1 = $request->get("fecha1");
        $fecha2 = $request->get("fecha2");
        return (new ResumenCapaExport($fecha1,$fecha2))->download('Resumen de Capa'.$fecha1.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        $fecha1 = $request->get("fecha1");
        $fecha2 = $request->get("fecha2");


        return (new ResumenCapaExport($fecha1,$fecha2))->download('Resumen de Capa '.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    //
}
