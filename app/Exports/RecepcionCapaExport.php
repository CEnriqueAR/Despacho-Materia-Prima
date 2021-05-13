<?php

namespace App\Exports;

use App\Calidad;
use App\RecibirCapa;
use App\Semilla;
use App\Tamano;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class RecepcionCapaExport implements  FromCollection , ShouldAutoSize , WithHeadings
{
    use Exportable;

    protected $fecha;
    public function __construct(String $fecha )
    {

        $this->fecha = $fecha;
    }
        /**
     * @param Request $request
     * @return View
         */
    public function collection()
    {

            $recibirCapa=DB::table("recibir_capas")
                ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                ->leftJoin("tamanos","recibir_capas.id_tamano","=","tamanos.id")
                ->leftJoin("calidads","recibir_capas.id_calidad","=","calidads.id")

                ->select("tamanos.name AS nombre_tamano",

                    "calidads.name as nombre_calidad",
                   "semillas.name as nombre_semillas",
                    "recibir_capas.total")

                ->whereDate('recibir_capas.created_at', '=', $this->fecha)
                ->get();
        return $recibirCapa;
        }
    public function headings(): array
    {
        return [
            [
                'Entradas de Capa Diario ',

            ],
            [

                'Fecha : '.$this->fecha,
                'Planta : TAOSA'
            ],
            [
                'Tamaño',
            'Semilla',
            'Calidad',
            'Total Recibida',
        ]];
    }
        //



}
