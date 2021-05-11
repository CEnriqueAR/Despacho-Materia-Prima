<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResumenCapaExport implements FromCollection,ShouldAutoSize ,WithHeadings
{


    use \Maatwebsite\Excel\Concerns\Exportable;

    protected $fecha;

    public function __construct(string $fecha)
    {

        $this->fecha = $fecha;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $entregaCapa=DB::table("existencia_diarios")
            ->leftJoin("semillas","existencia_diarios.id_semillas","=","semillas.id")
            ->leftJoin("calidads","existencia_diarios.id_calidad","=","calidads.id")
            ->leftJoin("tamanos","existencia_diarios.id_tamano","=","tamanos.id")
            ->selectRaw("semillas.name as nombre_semilla")
            ->selectRaw("calidads.name as nombre_calidads")
            ->selectRaw("SUM(totalconsumo) as total_capa")
            ->selectRaw("SUM(pesoconsumo) as total_peso")
            ->groupBy('id_semillas' ,'id_calidad')
            ->whereDate("existencia_diarios.created_at","=" ,$this->fecha)
            ->orderBy("nombre_semilla")->get();

        return $entregaCapa;
        //
    }

    public function headings(): array
    {
        return [

            'Semilla',
            'calidad',
            'Cantidad ',
            'Peso ',
        ];
    }
}
