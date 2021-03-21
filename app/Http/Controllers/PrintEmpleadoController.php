<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;

class PrintEmpleadoController extends Controller
{
    public function index()
    {
        $students = Empleado::all();
        return view('printstudent')->with('empleado', $students);;
    }
    public function prnpriview()
    {
        $students = Empleado::all();
        return view('Empleados.Empleados')->with('empleado', $students);;
    }
}
