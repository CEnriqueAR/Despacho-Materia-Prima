<?php

namespace App\Http\Controllers;

use App\Peso;
use App\Semilla;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request){
            $query = trim($request->get("search"));
            $peso=DB::table("pesos")
                ->leftJoin("semillas","pesos.id_semillas","=","semillas.id")

                ->select("pesos.id",
                    "pesos.id_semillas","semillas.name as nombre_semillas",
                    "pesos.PesoGrande",
                    "pesos.PesoMediano",
                    "pesos.PesoPequeno")
                ->where("semillas.name","Like","%".$query."%")
                ->paginate(10);
            $semillas = Semilla::all();


            return view("Peso.PesoCapa")
                ->withNoPagina(1)
                ->withPeso($peso)
                ->withSemillas($semillas);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function StorePeso(Request $request){
        $nuevoPeso = new Peso();

        $nuevoPeso->PesoGrande=$request->input('PesoGrande');
        $nuevoPeso->PesoMediano=$request->input('PesoMediano');
        $nuevoPeso->id_semillas=$request->input('id_semillas');
        $nuevoPeso->PesoPequeno=$request->input('PesoPequeno');

        $nuevoPeso->save();

        return redirect()->route("peso")->withExito("Se creó la entraga Correctamente ");
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Peso  $peso
     * @return \Illuminate\Http\Response
     */
    public function show(Peso $peso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Peso  $peso
     * @return \Illuminate\Http\Response
     */
    public function editarPeso(Request $request)
    {
        try{
            $this->validate($request, [
                'PesoGrande'=>'required',
                'PesoMediano'=>'required',
                'PesoPequeno'=>'required',
                'id_semillas'=>'required|integer',

            ]
           ,$messages = [
                    'PesoGrande.required' => 'El nombre del producto es requerido.',
                    'PesoMediano.required' => 'El nombre del producto es requerido.',



                    /**
            'name.required' => 'El nombre del producto es requerido.',
            'description.max:192' => 'La descripción  no debe de tener más de 192 caracteres.',
            'unit_price.numeric' => 'El precio debe ser un valor numérico.',
            'unit_price.max:9999' =>'El precio unitario no debe de exceder de 9 caracteres',
            'lote_price.max:99999' =>'El precio de lote no debe de exceder de 9 caracteres',
            'lote_price.numeric' =>'El precio lote debe ser un valor numericos',
            'id_empresa.required' => 'Se requiere una empresa para este producto.',
            'id_categoria.required' => 'Se requiere una categoria para este producto.',
            'id_marca.required'=>'Se requiere una marca para este producto'
                 */

                'required' => 'Se requiere una empresa para este producto.',
            ]);
            $editarPeso = Peso::findOrFail($request->id);
            $editarPeso->PesoGrande=$request->input('PesoGrande');
            $editarPeso->PesoMediano=$request->input('PesoMediano');
            $editarPeso->id_semillas=$request->input('id_semillas');
            $editarPeso->PesoPequeno=$request->input('PesoPequeno');

            $editarPeso->save();

            return redirect()->route("peso")->withExito("Se editó Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("peso")->with('errores','errores')->with('id_producto',$request->input("id"))->withErrors($exception->errors());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Peso  $peso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peso $peso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Peso  $peso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $capaentrega = $request->input('id');
        $borrar = Peso::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("peso")->withExito("Se borró la entrega satisfactoriamente");

    }
}
