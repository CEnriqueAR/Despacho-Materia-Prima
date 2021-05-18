<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMarcasRequest;
use App\Marca;
use App\Variedad;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VariedadController extends Controller
{

    //Funcion Lista Marca
    public function index(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $marca = Variedad::where("name","like","%".$query."%")  ->orderBy("name")->paginate(1000);

            return View('Variedad.variedad')
                ->withNoPagina(1)
                ->withMarca($marca);
        }
    }
    //Funcion Crear Marca
    public function storeMarca(createMarcasRequest $request){
        $marca = new Variedad();
        $marca->name = $request->input("name");
        $name = $request->input("name");
        $marca->description = $request->input("description");

        $marca->save();
        return redirect()->route("variedad")->withExito("Marca creada correctamente");
    }
    //Funcion Editar Marca
    public function editarMarca(Request $request){
        $name=Variedad::where("name",$request->input("name"))->Where("id","!=",$request->input("id"))->first();

        if ($name!=null){
            try {
                $this->validate($request, [
                    'name'=> 'unique:marcas,name|required|string|max:30',
                    'description'=>'max:100'
                ],$messages = [
                    'name.required'=>'El nombre de la marca es requerido',
                    'name.unique'=>'El nombre de la marca debe de ser unico',
                    'name.max:30'=>'El nombre no puede exceder 30 caracteres',
                    'name.string'=>'El nombre no deben de ser solamente numeros',
                    'description.max:100'=>'La descripcion no debe de excceder de 100 caracteres'
                ]);
                $id = $request->input("id");
                $editar = Variedad::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("variedad")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("variedad")->with('errores','errores')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }else{
            try {
                $this->validate($request, [
                    'name'=> 'required|string|max:30',
                    'description'=>'max:100'
                ],$messages = [
                    'name.required'=>'El nombre de la marca es requerido',
                    'name.max:30'=>'El nombre no puede exceder 30 caracteres',
                    'name.string'=>'El nombre no deben de ser solamente numeros',
                    'description.max:100'=>'La descripcion no debe de excceder de 100 caracteres'
                ]);
                $id = $request->input("id");
                $editar = Variedad::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("variedad")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("variedad")->with('errors','errors')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }


    }
    //Funcion Borrar Marca
    public function borrarMarca(Request $request){
        $id = $request->input("id");
        $borrar = Variedad::findOrFail($id);

        $borrar->delete();
        return redirect()->route("variedad")->withExito("Marca borrada con éxito");
    }

}
