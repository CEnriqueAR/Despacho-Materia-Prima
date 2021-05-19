<?php

namespace App\Http\Controllers;

use App\Calidad;
use App\Exports\ResumenCapaExport;
use App\Semilla;
use App\Tamano;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntradaCapaMensualController extends Controller
{

    public function index(Request $request)
    {

            $fecha = $request->get("fecha");

            if ($fecha == null) {
                $fecha = Carbon::now()->format('Y-m');

            } else{

                $fecha = $request->get("fecha");

            }
            $entregaCapa=DB::table("recibir_capas")
                ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                ->leftJoin("tamanos","recibir_capas.id_tamano","=","tamanos.id")
                ->leftJoin("calidads","recibir_capas.id_calidad","=","calidads.id")
                ->leftJoin("variedads", "recibir_capas.id_variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "recibir_capas.id_procedencia", "=", "procedencias.id")
                ->selectRaw('recibir_capas.fecha'  )
                ->selectRaw("SUM(total) as total")

                ->groupBy('fecha')
                ->where("mes","=" ,Carbon::parse($fecha)->format('Y-m'))
                //  ->whereDate("capa_entregas.created_at","=" ,)
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();

            return view("InventarioMensual.EntradaCapa")
                ->withNoPagina(1)
                ->withExistenciaDiaria($entregaCapa)
                ->withSemilla($semilla)
                ->withTamano($tamano)
                ->withCalidad($calidad);
        }

        //

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

}
