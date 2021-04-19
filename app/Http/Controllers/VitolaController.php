<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMarcasRequest;
use App\Vitola;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VitolaController extends Controller
{
    //Funcion Lista Marca
    public function index(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $vitola = Vitola::where("name","like","%".$query."%")->orderBy("name")->paginate(1000);

            return View('Vitola.vitolaBanda')
                ->withNoPagina(1)
                ->withVitola($vitola);
        }
    }
    //Funcion Crear Marca
    public function storeVitola(createMarcasRequest $request){
        $marca = new Vitola();
        $marca->name = $request->input("name");
        $name = $request->input("name");
        $marca->description = $request->input("description");

        $marca->save();
        return redirect()->route("vitolaBanda")->withExito("vitola creada correctamente");
    }
    //Funcion Editar Marca
    public function editarVitola(Request $request){
        $name=Vitola::where("name",$request->input("name"))->Where("id","!=",$request->input("id"))->first();

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
                $editar = Vitola::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("vitolaBanda")->withExito("vitola editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("vitolaBanda")->with('errores','errores')->with('id_M',$request->input("id"))->withErrors($exception->errors());
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
                $editar = Vitola::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("vitolaBanda")->withExito("vitola editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("vitolaBanda")->with('errors','errors')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }


    }
    //Funcion Borrar Marca
    public function borrarVitola(Request $request){
        $id = $request->input("id");
        $borrar = Vitola::findOrFail($id);

        $borrar->delete();
        return redirect()->route("vitolaBanda")->withExito("vitola borrada con éxito");
    }
    //Funcion Lista Marca
    public function index1(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $vitola = Vitola::where("name","like","%".$query."%")->paginate(1000);

            return View('Vitola.vitola')
                ->withNoPagina(1)
                ->withVitola($vitola);
        }
    }
    //Funcion Crear Marca
    public function storeVitola1(createMarcasRequest $request){
        $marca = new Vitola();
        $marca->name = $request->input("name");
        $name = $request->input("name");
        $marca->description = $request->input("description");

        $marca->save();
        return redirect()->route("vitola")->withExito("vitola creada correctamente");
    }
    //Funcion Editar Marca
    public function editarVitola1(Request $request){
        $name=Vitola::where("name",$request->input("name"))->Where("id","!=",$request->input("id"))->first();

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
                $editar = Vitola::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("vitola")->withExito("vitola editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("vitola")->with('errores','errores')->with('id_M',$request->input("id"))->withErrors($exception->errors());
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
                $editar = Vitola::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("vitola")->withExito("vitola editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("vitola")->with('errors','errors')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }


    }
    //Funcion Borrar Marca
    public function borrarVitola1(Request $request){
        $id = $request->input("id");
        $borrar = Vitola::findOrFail($id);

        $borrar->delete();
        return redirect()->route("vitola")->withExito("vitola borrada con éxito");
    }
}
