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

            ->select("marcas.name as nombre_marca",
                "vitolas.name as nombre_vitolas",
                "semillas.name as nombre_semillas",
                "tamanos.name as nombre_tamano"
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

                'Fecha Creacion del Documento: '.$this->fecha,
                'Planta : TAOSA'
            ],
            [
                'Marca',
            'Vitola',
            'Semilla',
            'Tamaño',
            'Total Entregada','Onzas ','Libras '
        ]];
    }
}
