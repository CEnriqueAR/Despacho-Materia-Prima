<?php

namespace App\Http\Controllers;

use App\CapaEntrega;
use App\Http\Requests\createEmpleadosRequest;
use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmpleadoController extends Controller
{
    //
    //Funcion Lista Empleados
    public function index(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $empleado = Empleado::where("codigo","like","%".$query."%")->orderBy("nombre")->paginate(1000);

           return View('Empleados.Empleados')
                ->withNoPagina(1)
                ->withEmpleado($empleado);

        }
    }
    //Funcion Crear Empleado
    public function storeEmpleado(createEmpleadosRequest $request){
        $empleado = new Empleado();
        $empleado->nombre = $request->input("nombre");
        $empleado->codigo = $request->input("codigo");
        $empleado->puesto = ('Rolero');
        $empleado->save();
        return redirect()->route("empleados")->withExito("Empleado creada correctamente");
    }
    //Funcion Editar Empleado

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmpleadoController  $recibirCapa
     * @return \Illuminate\Http\Response
     */
    public function editarEmpleado(Request $request){

            try {
                $this->validate($request, [
                    'codigo' => 'required',
                    'nombre' => 'required|string|max:100',


                ], $messages = [
                    'nombre.required' => 'El name de la nombre es requerido',
                    'codigo.required' => 'El name de la codigo es requerido',
                    'puesto.required' => 'El name de la marca es requerido',
                    'nombre.max:100' => 'El name no puede exceder 30 caracteres',
                    'nombre.string' => 'El name no deben de ser solamente numeros',
                ]);

                $editar = Empleado::findOrFail($request->id);

                $editar->codigo= $request->input("codigo");
                $editar->nombre= $request->input("nombre");
                $editar->puesto = ('Rolero');

                $editar->save();
                return redirect()->route("empleados")->withExito("Empleado editada correctamente");
            } catch (ValidationException $exception){
                return redirect()->route("empleados")->with('errors','errors')->with('id_producto',$request->input("id"))->withErrors($exception->errors());
            }




    }
    //Funcion Borrar Marca
    public function borrarEmpleado(Request $request){
        $id = $request->input("id");
        $borrar = Empleado::findOrFail($id);
        $updateProducto = CapaEntrega::where("id_empleado","=",$id)->get();
       foreach ($updateProducto as $producto){
         $producto->delete();
        }
        $borrar->delete();
        return redirect()->route("empleados")->withExito("Empleado borrada con éxito");
    }
}
