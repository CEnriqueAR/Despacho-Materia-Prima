<?php

namespace App\Http\Controllers;

use App\Calidad;
use App\CapaEntrega;
use App\Empleado;
use App\Marca;
use App\RecibirCapa;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecibirCapaController extends Controller
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
            $recibirCapa=DB::table("recibir_capas")
                ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                ->leftJoin("tamanos","recibir_capas.id_tamano","=","tamanos.id")

                ->select("recibir_capas.id","tamanos.name AS nombre_tamano",
                   "recibir_capas.id_calidad",
                    "recibir_capas.id_semillas","semillas.name as nombre_semilla","recibir_capas.total")
                ->where("semillas.nombre_semilla","Like","%".$query."%")
                ->paginate(10);
        $tamano= Tamano::all();
            $marca = Marca::all();

            return view("EntregaDeCapa.CapaEntrega")
                ->withNoPagina(1)
                ->withEntregaCapa($recibirCapa)
                ->withTamano($tamano);
        }

        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function StoreRecibir(Request $request){
        $nuevoCapaEntra = new RecibirCapa();

        $nuevoCapaEntra->id_empleado=$request->input('id_tamano');
        $nuevoCapaEntra->id_semillas=$request->input("id_semillas");
        $nuevoCapaEntra->total=$request->input('total');


        $nuevoCapaEntra->save();

        return redirect()->route("CapaEntrega")->withExito("Se creó la entrada Correctamente ");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RecibirCapa  $recibirCapa
     * @return \Illuminate\Http\Response
     */
    public function show(RecibirCapa $recibirCapa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RecibirCapa  $recibirCapa
     * @return \Illuminate\Http\Response
     */
    public function editCapaEntrega( Request $request)
    {
        try{
            $this->validate($request, [
                'id_tamano'=>'required|integer',
                'id_semilla'=>'required|integer',
                'total'=>'required|integer'
            ]);
            /**,$messages = [
            'name.required' => 'El nombre del producto es requerido.',
            'description.max:192' => 'La descripción  no debe de tener más de 192 caracteres.',
            'unit_price.numeric' => 'El precio debe ser un valor numérico.',
            'unit_price.max:9999' =>'El precio unitario no debe de exceder de 9 caracteres',
            'lote_price.max:99999' =>'El precio de lote no debe de exceder de 9 caracteres',
            'lote_price.numeric' =>'El precio lote debe ser un valor numericos',
            'id_empresa.required' => 'Se requiere una empresa para este producto.',
            'id_categoria.required' => 'Se requiere una categoria para este producto.',
            'id_marca.required'=>'Se requiere una marca para este producto'

            ]);  */
            $editarCapaRecibida=RecibirCapa::findOrFail($request->id);
            $editarCapaRecibida->id_calidad=$request->input('id_tamano');
            $editarCapaRecibida->id_semillas=$request->input("id_semillas");
            $editarCapaRecibida->total=$request->input('total');


            $editarCapaRecibida->save();
            return redirect()->route("CapaEntrega")->withExito("Se editó Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("CapaEntrega")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RecibirCapa  $recibirCapa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecibirCapa $recibirCapa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RecibirCapa  $recibirCapa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $capaentrega = $request->input('id');
        $borrar = RecibirCapa::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("CapaEntrega")->withExito("Se borró la entrega satisfactoriamente");
    }
}
