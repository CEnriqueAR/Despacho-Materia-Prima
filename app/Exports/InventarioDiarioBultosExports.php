<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarioDiarioBultosExports implements FromCollection ,ShouldAutoSize ,WithHeadings
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
        $inventarioDiario=DB::table("re_bul_diarios")
            ->leftJoin("vitolas","re_bul_diarios.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","re_bul_diarios.id_marca","=","marcas.id")
            ->select(
                "vitolas.name as nombre_vitolas", "marcas.name as nombre_marca"
                ,"re_bul_diarios.totalinicial","re_bul_diarios.pesoinicial"
                ,"re_bul_diarios.totalentrada","re_bul_diarios.pesoentrada"
                ,"re_bul_diarios.totalfinal","re_bul_diarios.pesofinal",
                "re_bul_diarios.totalconsumo","re_bul_diarios.pesoconsumo"
                ,"re_bul_diarios.onzas")
            ->whereDate("re_bul_diarios.created_at", "=", $this->fecha)
            ->orderBy("nombre_marca")->get();


        return $inventarioDiario;
        //
    }


    public function headings(): array
    {
        return [
            [
                'Inevntario Diario de Bultos',

            ],
            [

                'Fecha Creacion del Documento: '.$this->fecha,
                'Planta : TAOSA'
            ],
            [
                'Vitola',
            'Marca',
            'Inv.Inicial',
            'Peso',
            'Entradas',
            'Peso',
            'Inv.Final ','peso ',
             'Consumo ','peso ','Onzas '
        ]];
    }
}
