<?php

namespace App\Exports;

use App\Empleado;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmpleadosExport implements FromCollection , ShouldAutoSize ,WithMapping, WithHeadings,WithEvents
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Empleado::all();
    }
    public function map($Empleado): array
    {
        return [

            $Empleado->nombre,
            $Empleado->codigo,
            $Empleado->puesto,
        ];
    }
    public function headings(): array
    {
        return [
            'Nombre',
            'Codigo',
            'Puesto',
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getStyle("A1:C1")->apllyFromArray([

'font'=>[
    'bold' =>true],
                ]);
        }];
    }
}
