<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DevolucionesBultoExport implements FromCollection , ShouldAutoSize ,WithHeadings
{


    use Exportable;

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
        $bultodevuleto = DB::table("bultos_devueltos")
            ->leftJoin("vitolas", "bultos_devueltos.id_vitolas", "=", "vitolas.id")
            ->leftJoin("marcas", "bultos_devueltos.id_marca", "=", "marcas.id")
            ->select(
                "vitolas.name as nombre_vitolas",
               "marcas.name as nombre_marca"
                , "bultos_devueltos.total", "bultos_devueltos.onzas", "bultos_devueltos.libras")
            ->whereDate("bultos_devueltos.created_at", "=", $this->fecha)->get();
        //

        return $bultodevuleto;
    }

    public function headings(): array
    {
        return [
            [
                'Devoluciones de Bultos a los Salones ',

            ],
            [

                'Fecha: '.$this->fecha,
                'Planta : TAOSA'
            ],
            [   'Vitola',
            'Marca',
            'Total Entregada','Onzas ','Libras '
        ]];
    }
}
