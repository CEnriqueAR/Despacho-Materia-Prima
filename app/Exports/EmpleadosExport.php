<?php

namespace App\Exports;

use App\Empleado;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmpleadosExport implements FromCollection , ShouldAutoSize ,WithMapping
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
}
