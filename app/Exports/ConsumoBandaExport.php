<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsumoBandaExport implements FromCollection, ShouldAutoSize ,WithHeadings
{


    use Exportable;

    protected $fecha;

    public function __construct(string $fecha)
    {

        $this->fecha = $fecha;
    }  /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
          $consumobanda=DB::table("consumo_bandas")
            ->leftJoin("vitolas","consumo_bandas.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","consumo_bandas.id_marca","=","marcas.id")
            ->leftJoin("tamanos","consumo_bandas.id_tamano","=","tamanos.id")
            ->leftJoin("semillas","consumo_bandas.id_semillas","=","semillas.id")
              ->leftJoin("variedads", "consumo_bandas.variedad", "=", "variedads.id")
              ->leftJoin("procedencias", "consumo_bandas.procedencia", "=", "procedencias.id")

            ->select("marcas.name as nombre_marca",
                "vitolas.name as nombre_vitolas",
                "semillas.name as nombre_semillas",
                "variedads.name as nombre_variedad",
                "tamanos.name as nombre_tamano",
               "procedencias.name as nombre_procedencia"
                ,"consumo_bandas.total"
                ,"consumo_bandas.onzas"
                ,"consumo_bandas.libras")
            ->whereDate("consumo_bandas.created_at", "=", $this->fecha)->get();
        //

        return $consumobanda;
    }

    public function headings(): array
    {
        return [
            [
                'Consumo De Banda Diario ',

            ],
            [

                'Fecha : '.$this->fecha,
                'Planta : TAOSA'
            ],
            [
                'Marca',
            'Vitola',
            'Semilla',
                'Variedad',
            'Tamaño',
                'Procedencia',
            'Total Entregada','Onzas ','Libras '
        ]];
    }
}
