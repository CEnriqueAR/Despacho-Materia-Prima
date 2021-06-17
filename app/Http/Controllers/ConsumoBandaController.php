<?php

namespace App\Http\Controllers;

use App\BandaInvInicial;
use App\ConsumoBanda;
use App\Exports\ConsumoBandaExport;
use App\Marca;
use App\Procedencia;
use App\Semilla;
use App\Tamano;
use App\Variedad;
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

        if ($request) {
            $query = trim($request->get("search"));

            $fecha = $request->get("fecha");
        }
            if ($fecha = null){
                $fecha = Carbon::now()->format('Y-m-d');
        }else{
                $fecha = $request->get("fecha");

            }

            $consumobanda=DB::table("consumo_bandas")
                ->leftJoin("vitolas","consumo_bandas.id_vitolas","=","vitolas.id")
                ->leftJoin("marcas","consumo_bandas.id_marca","=","marcas.id")
                ->leftJoin("tamanos","consumo_bandas.id_tamano","=","tamanos.id")
                ->leftJoin("semillas","consumo_bandas.id_semillas","=","semillas.id")
                ->leftJoin("variedads", "consumo_bandas.variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "consumo_bandas.procedencia", "=", "procedencias.id")

                ->select("consumo_bandas.id",
                    "vitolas.name as nombre_vitolas",
                    "semillas.name as nombre_semillas",
                    "variedads.name as nombre_variedad",
                    "procedencias.name as nombre_procedencia",
                    "consumo_bandas.id_tamano",
                    "tamanos.name as nombre_tamano",
                    "consumo_bandas.id_vitolas",
                    "consumo_bandas.id_semillas",
                    "consumo_bandas.id_marca","marcas.name as nombre_marca"
                    ,"consumo_bandas.total"
                    ,"consumo_bandas.onzas"
                    ,"consumo_bandas.libras"
                , "consumo_bandas.variedad" ,"consumo_bandas.procedencia")
                ->where("marcas.name","Like","%".$query."%")
                ->whereDate("consumo_bandas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("nombre_marca")

                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $vitola = Vitola::all();
            $marca = Marca::all();
            $tamano = Tamano::all();
            $semilla = Semilla::all();
        $variedad = Variedad::all();
        $procedencia =Procedencia::all();

        $entregaCapass=DB::table("consumo_bandas")
            ->leftJoin("vitolas","consumo_bandas.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","consumo_bandas.id_marca","=","marcas.id")
            ->leftJoin("tamanos","consumo_bandas.id_tamano","=","tamanos.id")
            ->leftJoin("semillas","consumo_bandas.id_semillas","=","semillas.id")
            ->leftJoin("variedads", "consumo_bandas.variedad", "=", "variedads.id")
            ->leftJoin("procedencias", "consumo_bandas.procedencia", "=", "procedencias.id")
            ->selectRaw("SUM(total) as total_capa")
            ->where("marcas.name","Like","%".$query."%")
            ->whereDate("consumo_bandas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
            ->get();

            return view("ConsumoBanda.ConsumoBanda")
                ->withNoPagina(1)
                ->withConsumoBanda($consumobanda)
                ->withTamano($tamano)
                ->withVitola($vitola)
                ->withTotal($entregaCapass)

                ->withSemilla($semilla)
                ->withMarca($marca)
        ->withVariedad($variedad)
        ->withProcedencia($procedencia);

    }
        //


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

        $inve  =  DB::table('banda_inv_inicials')
            ->leftJoin("semillas","banda_inv_inicials.id_semilla","=","semillas.id")
            ->leftJoin("tamanos","banda_inv_inicials.id_tamano","=","tamanos.id")
            ->leftJoin("variedads", "banda_inv_inicials.id_variedad", "=", "variedads.id")
            ->leftJoin("procedencias", "banda_inv_inicials.id_procedencia", "=", "procedencias.id")

            ->select(
                "banda_inv_inicials.id")
            ->where("banda_inv_inicials.id_semilla","=",$request->input("id_semillas"))
            ->where("banda_inv_inicials.id_variedad","=",$request->input("id_variedad"))
            ->where("banda_inv_inicials.id_procedencia","=",$request->input("od_procedencia"))

            ->where("banda_inv_inicials.id_tamano","=",$request->input("id_tamano"))->get();
        if($inve->count()>0){
        }else{
            $nuevoConsumo = new BandaInvInicial();
            $nuevoConsumo->id_semilla=$request->input('id_semillas');
            $nuevoConsumo->id_tamano=$request->input("id_tamano");
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->id_variedad= $request->input("id_variedad");
            $nuevoConsumo->id_procedencia= $request->input("id_procedencia");
            $nuevoConsumo->save();
        }
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

            $fechaa =$request->input('fecha');
            if ($fechaa == null)
                $fechaa = Carbon::now()->format('Y-m-d');
            else{
                $fechaa = $request->get("fecha");

            }

        $nuevoConsumoBanda = new ConsumoBanda();
        $nuevoConsumoBanda->id_vitolas=$request->input('id_vitolas');
        $nuevoConsumoBanda->id_semillas=$request->input('id_semillas');
        $nuevoConsumoBanda->id_marca=$request->input("id_marca");
        $nuevoConsumoBanda->id_tamano=$request->input("id_tamano");
        $nuevoConsumoBanda->total=$request->input('total');
        $nuevoConsumoBanda->onzas=$request->input('onzas');
            $nuevoConsumoBanda->created_at=$fechaa;
        $nuevoConsumoBanda->libras=  ($request->input("total") * $request->input('onzas')/16);
            $nuevoConsumoBanda->variedad=$request->input('id_variedad');
            $nuevoConsumoBanda->procedencia=$request->input('id_procedencia');

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
        $inve  =  DB::table('banda_inv_inicials')
            ->leftJoin("semillas","banda_inv_inicials.id_semilla","=","semillas.id")
            ->leftJoin("tamanos","banda_inv_inicials.id_tamano","=","tamanos.id")
            ->leftJoin("variedads", "banda_inv_inicials.id_variedad", "=", "variedads.id")
            ->leftJoin("procedencias", "banda_inv_inicials.id_procedencia", "=", "procedencias.id")

            ->select(
                "banda_inv_inicials.id")
            ->where("banda_inv_inicials.id_semilla","=",$request->input("id_semillas"))
            ->where("banda_inv_inicials.id_variedad","=",$request->input("id_variedad"))
            ->where("banda_inv_inicials.id_procedencia","=",$request->input("id_procedencia"))
            ->where("banda_inv_inicials.id_tamano","=",$request->input("id_tamano"))->get();
        if($inve->count()>0){
        }else{
            $nuevoConsumo = new BandaInvInicial();
            $nuevoConsumo->id_semilla=$request->input('id_semillas');
            $nuevoConsumo->id_tamano=$request->input("id_tamano");
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->id_variedad= $request->input("id_variedad");
            $nuevoConsumo->id_procedencia= $request->input("id_procedencia");

            $nuevoConsumo->save();
        }
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

            $editarConsumoBanda->variedad=$request->input('id_variedad');
            $editarConsumoBanda->procedencia=$request->input('id_procedencia');

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

    public function Suma100(Request $request){


        $capaentrega = $request->get('id');

        DB::table('consumo_bandas')->where("consumo_bandas.id","=",$capaentrega)->increment('total', 100);

        return redirect()->route("ConsumoBanda")->withExito("Se editó Correctamente");

    }
    public function Sumas(Request $request){

        $incremeto =  $request->get('suma');
        $capaentrega = $request->get('id');

        DB::table('consumo_bandas')->where("consumo_bandas.id","=",$capaentrega)
            ->increment('total', $incremeto);

        return redirect()->route("ConsumoBanda")->withExito("Se editó Correctamente");


    }
}
