<?php

namespace App\Http\Controllers;

use App\Http\Requests\createEmpleadosRequest;
use App\Empleado;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmpleadoController extends Controller
{
    //
    //Funcion Lista Empleados
    public function index(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $empleado = Empleado::where("nombre","like","%".$query."%")->paginate(100);

           return View('Empleados.Empleados')
                ->withNoPagina(1)
                ->withMarca($empleado);

        }
    }
    public function listar()
    {
        return Empleado::all();
    }
    //Funcion Crear Empleado
    public function storeEmpleado(createEmpleadosRequest $request){
        $empleado = new Empleado();
        $empleado->nombre = $request->input("nombre");
        $empleado->codigo = $request->input("codigo");
        $empleado->puesto = $request->input("puesto");
        $empleado->save();
        return redirect()->route("empleados")->withExito("Empleado creada correctamente");
    }
    //Funcion Editar Empleado
    public function editarEmpleado(Request $request){
        try {
            $id = $request->input("id");
            $this->validate($request, [
                'codigo' => 'required',
                'nombre' => 'required|string|max:100',
                'puesto' => 'max:100'
            ], $messages = [
                'nombre.required' => 'El name de la nombre es requerido',
                'codigo.required' => 'El name de la codigo es requerido',
                'puesto.required' => 'El name de la marca es requerido',
                'nombre.max:100' => 'El name no puede exceder 30 caracteres',
                'nombre.string' => 'El name no deben de ser solamente numeros',
                'puesto.max:100' => 'La descripcion no debe de excceder de 100 caracteres'
            ]);

            $editar = Empleado::findOrFail($id);
            $editar->codigo= $request->input("codigo");
            $editar->nombre= $request->input("nombre");
            $editar->description = $request->input("puesto");

            $editar->save();
            return redirect()->route("empleados")->withExito("Empleado editada correctamente");
        } catch (ValidationException $exception){
            return redirect()->route("empleados")->with('errors','errors')->with('id',$request->input("id"))->withErrors($exception->errors());
        }
    }
    //Funcion Borrar Marca
    public function borrarEmpleado(Request $request){
        $id = $request->input("id");
        $borrar = Empleado::findOrFail($id);
       // $updateProducto = Producto::where("id_marca","=",$id)->get();
        //foreach ($updateProducto as $producto){
          //  $producto->delete();
      //  }
        $borrar->delete();
        return redirect()->route("empleados")->withExito("Empleado borrada con éxito");
    }
}
