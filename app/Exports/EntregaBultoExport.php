<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntregaBultoExport implements FromCollection  , ShouldAutoSize ,WithHeadings
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

        $bultoentrega=DB::table("bultos_salidas")
            ->leftJoin("empleados","bultos_salidas.id_empleado","=","empleados.id")
            ->leftJoin("vitolas","bultos_salidas.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","bultos_salidas.id_marca","=","marcas.id")

            ->select("empleados.codigo AS codigo_empleado",
                "empleados.nombre AS nombre_empleado",
                "vitolas.name as nombre_vitolas",
               "marcas.name as nombre_marca"
                ,"bultos_salidas.total")
            ->whereDate("bultos_salidas.created_at","=" ,$this->fecha)->get();
        //

        return $bultoentrega;
    }


    public function headings(): array
    {
        return [
            [
                'Entrega de Bultos a los Salones ',

            ],
            [

                'Fecha : '.$this->fecha,
                'Planta : TAOSA'
            ],
            [
                'Codigo',
            'Empleado',
            'Vitola',
            'Marca',
            'Total Entregada',

        ]];


    }
}
