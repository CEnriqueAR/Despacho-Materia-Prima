<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Exports\EmpleadosExport;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Excel;


class EmpleadosExportController extends Controller
{

    private $excel;

    public function _construct(Excel $excel)
    {
       $this-> excel = $excel;
    }

    public function export()
    {
        return (new EmpleadosExport)->download('Listado de Empleados.xlsx', \Maatwebsite\Excel\Excel::XLSX);


        //return $this->excel->download(new EmpleadosExport, 'Listado de Empleados.csv', Excel::CSV);
     //   return (new EmpleadosExport)->download('Listado de Empleados.csv', \Maatwebsite\Excel\Excel::CSV);

        //return Excel::download(new EmpleadosExport, 'Listado de Empleados.pdf', Excel::DOMPDF);


        //codigo para exportar a pdf
        // return (new EmpleadosExport)->download('invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
