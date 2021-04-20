<?php

namespace App\Http\Controllers;

use App\CapaEntrega;
use App\ConsumoBanda;
use App\EmpleadosBanda;
use App\Exports\ConsumoBandaExport;
use App\Exports\DevolucionesBultoExport;
use App\Marca;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsumoBandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $Monday = 'Monday';


        if ($request){
            $query = trim($request->get("search"));

            $fecha = $request->get("fecha");

            if ($fecha == null) {
                $fecha = Carbon::now()->format('l');
                if ($fecha == 'Monday') {
                    $fecha = Carbon::now()->subDays(2)->format('Y-m-d');
                    $consumobanda1=DB::table("consumo_bandas")
                        ->leftJoin("vitolas","consumo_bandas.id_vitolas","=","vitolas.id")
                        ->leftJoin("marcas","consumo_bandas.id_marca","=","marcas.id")
                        ->leftJoin("tamanos","consumo_bandas.id_tamano","=","tamanos.id")
                        ->leftJoin("semillas","consumo_bandas.id_semillas","=","semillas.id")

                        ->select("consumo_bandas.id",
                            "vitolas.name as nombre_vitolas",
                            "semillas.name as nombre_semillas",
                            "consumo_bandas.id_tamano",
                            "tamanos.name as nombre_tamano",
                            "consumo_bandas.id_vitolas",
                            "consumo_bandas.id_semillas",
                            "consumo_bandas.id_marca","marcas.name as nombre_marca"
                            ,"consumo_bandas.total"
                            ,"consumo_bandas.onzas"
                            ,"consumo_bandas.libras")
                        ->whereDate("consumo_bandas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))->get();
                    if ($consumobanda1->count()>0){
                    }
                    else{
                            $fecha = Carbon::now()->subDays(3)->format('Y-m-d');
                        }

                } else {
                    $fecha = Carbon::now()->subDay()->format('Y-m-d');
                }
            } else{

                $fecha = $request->get("fecha");

            }

            $consumobanda=DB::table("consumo_bandas")
                ->leftJoin("vitolas","consumo_bandas.id_vitolas","=","vitolas.id")
                ->leftJoin("marcas","consumo_bandas.id_marca","=","marcas.id")
                ->leftJoin("tamanos","consumo_bandas.id_tamano","=","tamanos.id")
                ->leftJoin("semillas","consumo_bandas.id_semillas","=","semillas.id")

                ->select("consumo_bandas.id",
                    "vitolas.name as nombre_vitolas",
                    "semillas.name as nombre_semillas",
                    "consumo_bandas.id_tamano",
                    "tamanos.name as nombre_tamano",
                    "consumo_bandas.id_vitolas",
                    "consumo_bandas.id_semillas",
                    "consumo_bandas.id_marca","marcas.name as nombre_marca"
                    ,"consumo_bandas.total"
                    ,"consumo_bandas.onzas"
                    ,"consumo_bandas.libras")
                ->where("marcas.name","Like","%".$query."%")
                ->whereDate("consumo_bandas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("nombre_marca")

                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $vitola = Vitola::all();
            $marca = Marca::all();
            $tamano = Tamano::all();
            $semilla = Semilla::all();

            return view("ConsumoBanda.ConsumoBanda")
                ->withNoPagina(1)
                ->withConsumoBanda($consumobanda)
                ->withTamano($tamano)
                ->withVitola($vitola)
                ->withSemilla($semilla)
                ->withMarca($marca);
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
    public function store(Request $request)
    {

        try{
            $this->validate($request, [
                'id_vitolas'=>'required',
                'id_marca'=>'required',
                'id_semillas'=>'required',
                'id_tamano'=>'required|integer',
                'onzas'=>'required',
                'total'=>'required'
            ]);
        $fecha = $request->get("fecha");
        $fecha1 = Carbon::parse($fecha)->format('Y-m-d');

        $nuevoConsumoBanda = new ConsumoBanda();
        $nuevoConsumoBanda->id_vitolas=$request->input('id_vitolas');
        $nuevoConsumoBanda->id_semillas=$request->input('id_semillas');
        $nuevoConsumoBanda->id_marca=$request->input("id_marca");
        $nuevoConsumoBanda->id_tamano=$request->input("id_tamano");
        $nuevoConsumoBanda->total=$request->input('total');
        $nuevoConsumoBanda->onzas=$request->input('onzas');
        $nuevoConsumoBanda->created_at =$fecha1;
        $nuevoConsumoBanda->libras=  ($request->input("total") * $request->input('onzas')/16);

        $nuevoConsumoBanda->save();

        return redirect()->route("ConsumoBanda")->withExito("Se creó la entraga Correctamente ");
        }catch (ValidationException $exception){
            return redirect()->route("ConsumoBanda")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConsumoBanda  $consumoBanda
     * @return \Illuminate\Http\Response
     */
    public function show(ConsumoBanda $consumoBanda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConsumoBanda  $consumoBanda
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        try{
            $this->validate($request, [
                'id_vitolas'=>'required',
                'id_marca'=>'required',
                'id_semillas'=>'required',
                'id_tamano'=>'required|integer',
                'onzas'=>'required',
                'total'=>'required'
            ]);
            /**,$messages = [
            'id_empleado.required' => 'El nombre del producto es requerido.',

            'description.max:192' => 'La descripción  no debe de tener más de 192 caracteres.',
            'unit_price.numeric' => 'El precio debe ser un valor numérico.',
            'unit_price.max:9999' =>'El precio unitario no debe de exceder de 9 caracteres',
            'lote_price.max:99999' =>'El precio de lote no debe de exceder de 9 caracteres',
            'lote_price.numeric' =>'El precio lote debe ser un valor numericos',
            'id_empresa.required' => 'Se requiere una empresa para este producto.',
            'id_categoria.required' => 'Se requiere una categoria para este producto.',
            'id_marca.required'=>'Se requiere una marca para este producto'

            ]);  */
            $editarConsumoBanda=ConsumoBanda::findOrFail($request->id);

            $editarConsumoBanda->id_vitolas=$request->input('id_vitolas');
            $editarConsumoBanda->id_semillas=$request->input('id_semillas');
            $editarConsumoBanda->id_marca=$request->input("id_marca");
            $editarConsumoBanda->id_tamano=$request->input("id_tamano");
            $editarConsumoBanda->total=$request->input('total');
            $editarConsumoBanda->onzas=$request->input('onzas');
            $editarConsumoBanda->libras=  ($request->input("total") * $request->input('onzas')/16);


            $editarConsumoBanda->save();
            return redirect()->route("ConsumoBanda")->withExito("Se editó Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("ConsumoBanda")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConsumoBanda  $consumoBanda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConsumoBanda $consumoBanda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConsumoBanda  $consumoBanda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $capaentrega = $request->input('id');
        $borrar = ConsumoBanda::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("ConsumoBanda")->withExito("Se borró la entrega satisfactoriamente");
        //
    }
    public function export(Request $request)
    {

        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ConsumoBandaExport($fecha))->download('Listado Consumo De Banda '.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ConsumoBandaExport($fecha))->download('Listado Consumo De Banda '.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ConsumoBandaExport($fecha))->download('Listado Consumo De Banda '.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
