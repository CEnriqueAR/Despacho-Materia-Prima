<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMarcasRequest;
use App\Marca;
use App\Semilla;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SemillaController extends Controller
{
    public function index(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $semilla = Semilla::where("name","like","%".$query."%")->orderBy("name")->get();

            return View('Semilla.semillas')
                ->withNoPagina(1)
                ->withSemilla($semilla);
        }
    }
    //Funcion Crear Marca
    public function storeSemilla(createMarcasRequest $request){
        $marca = new Semilla();
        $marca->name = $request->input("name");
        $name = $request->input("name");
        $marca->description = $request->input("description");

        $marca->save();
        return redirect()->route("semillas")->withExito("Marca creada correctamente");
    }
    //Funcion Editar Marca
    public function editarSemilla(Request $request){
        $name=Semilla::where("name",$request->input("name"))->Where("id","!=",$request->input("id"))->first();

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
                $editar = Semilla::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("semillas")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("semillas")->with('errores','errores')->with('id_M',$request->input("id"))->withErrors($exception->errors());
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
                $editar = Semilla::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("semillas")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("semillas")->with('errors','errors')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }


    }
    //Funcion Borrar Marca
    public function borrarSemilla(Request $request){
        $id = $request->input("id");
        $borrar = Semilla::findOrFail($id);

        $borrar->delete();
        return redirect()->route("semillas")->withExito("Marca borrada con éxito");
    }


    public function index1(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $semilla = Semilla::where("name","like","%".$query."%")->get();

            return View('Semilla.semillasbanda')
                ->withNoPagina(1)
                ->withSemilla($semilla);
        }
    }
    //Funcion Crear Marca
    public function storeSemilla1(createMarcasRequest $request){
        $marca = new Semilla();
        $marca->name = $request->input("name");
        $name = $request->input("name");
        $marca->description = $request->input("description");

        $marca->save();
        return redirect()->route("semillasBanda")->withExito("Marca creada correctamente");
    }
    //Funcion Editar Marca
    public function editarSemilla1(Request $request){
        $name=Semilla::where("name",$request->input("name"))->Where("id","!=",$request->input("id"))->first();

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
                $editar = Semilla::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("semillasBanda")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("semillasBanda")->with('errores','errores')->with('id_M',$request->input("id"))->withErrors($exception->errors());
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
                $editar = Semilla::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("semillasBanda")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("semillasBanda")->with('errors','errors')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }


    }
    //Funcion Borrar Marca
    public function borrarSemilla1(Request $request){
        $id = $request->input("id");
        $borrar = Semilla::findOrFail($id);

        $borrar->delete();
        return redirect()->route("semillasBanda")->withExito("Marca borrada con éxito");
    }
}
