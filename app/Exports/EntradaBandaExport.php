<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntradaBandaExport implements FromCollection , ShouldAutoSize , WithHeadings
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
        $recibirCapa = DB::table("entrada_bandas")
            ->leftJoin("semillas", "entrada_bandas.id_semilla", "=", "semillas.id")
            ->leftJoin("tamanos", "entrada_bandas.id_tamano", "=", "tamanos.id")
            ->select(


               "semillas.name as nombre_semillas"
                , "entrada_bandas.variedad",
                "tamanos.name AS nombre_tamano",
                "entrada_bandas.origen"
                , "entrada_bandas.total"
                , "entrada_bandas.procedencia")

            ->whereDate('entrada_bandas.created_at', '=', $this->fecha)
            ->get();
        return $recibirCapa;
    }
    public function headings(): array
    {
        return [
            [
                'Entradas de Banda Diario ',

            ],
            [

                'Fecha : '.$this->fecha,
                'Planta : TAOSA'
            ],
            [

                'Semilla',
                'Variedad',
                'Tamaño',
                'Origen',
                'Total Recibida',
                'Procedencia',
            ]];
    }
}
