<?php

namespace App\Exports;

use App\Empleado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EntregaCapaExport implements  FromCollection , ShouldAutoSize ,WithHeadings
{
    use Exportable;

    protected $fecha;
    public function __construct(String $fecha )
    {

        $this->fecha = $fecha;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $entregaCapa=DB::table("capa_entregas")
            ->leftJoin("empleados","capa_entregas.id_empleado","=","empleados.id")
            ->leftJoin("vitolas","capa_entregas.id_vitolas","=","vitolas.id")
            ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
            ->leftJoin("marcas","capa_entregas.id_marca","=","marcas.id")
            ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")
            ->leftJoin("tamanos","capa_entregas.id_tamano","=","tamanos.id")


            ->select("empleados.nombre AS nombre_empleado",
                "vitolas.name as nombre_vitolas",
                "marcas.name as nombre_marca",
                "semillas.name as nombre_semillas",
                "calidads.name as nombre_calidads",
               "tamanos.name as nombre_tamano"

                ,"capa_entregas.total") ->whereDate('capa_entregas.created_at', '=', $this->fecha)
            ->get();

        return $entregaCapa;
    }
    public function headings(): array
    {
        return [
            'Empleado',
            'Vitola',
            'Marca',
            'Semilla',
            'Calidad',
            'Tamaño',
            'Total Recibida',
        ];
    }

}
