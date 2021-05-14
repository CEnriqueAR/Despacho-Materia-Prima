<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarioBandaExport implements FromCollection,ShouldAutoSize ,WithHeadings
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
        $entregaCapa=DB::table("inventario_bandas")
            ->leftJoin("semillas","inventario_bandas.id_semillas","=","semillas.id")
            ->leftJoin("tamanos","inventario_bandas.id_tamano","=","tamanos.id")
            ->select("semillas.name as nombre_semillas",
                "inventario_bandas.variedad",
                "tamanos.name as nombre_tamano"

                ,"inventario_bandas.totalinicial","inventario_bandas.pesoinicial"
                ,"inventario_bandas.totalentrada","inventario_bandas.pesoentrada"
                ,"inventario_bandas.totalfinal","inventario_bandas.pesofinal",
                "inventario_bandas.totalconsumo","inventario_bandas.pesoconsumo"
                ,"inventario_bandas.pesobanda")
            ->whereDate("inventario_bandas.created_at","=" ,$this->fecha)
            ->orderBy("nombre_semillas")->get();

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
                'Tamaño',
                'variedad',
                'Inv.Inicial',
                'Peso',
                'Entradas',
                'Peso',
                'Inv.Final ','peso ',
                'Consumo ','peso ',
                'Peso Por 100 Banda',
            ]];
    }
}
