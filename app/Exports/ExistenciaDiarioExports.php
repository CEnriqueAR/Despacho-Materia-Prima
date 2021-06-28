<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExistenciaDiarioExports implements FromCollection,ShouldAutoSize ,WithHeadings
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
            ->select("semillas.name as nombre_semillas",
                "calidads.name as nombre_calidads",
               "tamanos.name as nombre_tamano"
                ,"existencia_diarios.totalinicial","existencia_diarios.pesoinicial"
                ,"existencia_diarios.totalentrada","existencia_diarios.pesoentrada"
                ,"existencia_diarios.totalfinal","existencia_diarios.pesofinal",
                "existencia_diarios.totalconsumo","existencia_diarios.pesoconsumo"
              )
            ->whereDate("existencia_diarios.created_at","=" ,$this->fecha)
            ->orderBy("nombre_semillas")
            ->orderBy("nombre_calidads")->get();

        return $entregaCapa;
        //
    }

    public function headings(): array
    {
        return [
            [
                ' Invetario De Existencia de Capa  ',

            ],
            [

                'Fecha : '.$this->fecha,
                'Planta : TAOSA'
            ],
            [
                'Semilla',
            'calidad',
            'Tamaño',
            'Inv.Inicial',
            'Peso',
            'Entradas',
            'Peso',
            'Inv.Final ','peso ',
            'Consumo ','peso ',
                'Dev. Cuarto Firo ','peso ',
        ]];
    }
}
