<?php

namespace App\Http\Controllers;

use App\BInvInicial;
use App\Calidad;
use App\CapaEntrega;
use App\CInvInicial;
use App\Empleado;
use App\Exports\EntregaCapaExport;
use App\Exports\RecepcionCapaExport;
use App\Http\Requests\CreateProductosRequest;
use App\Marca;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CapaEntregaController extends Controller
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

            $fecha = $request->get("fecha");

            if ($fecha == null)
                $fecha = Carbon::now()->format('Y-m-d');
            else{
                $fecha = $request->get("fecha");

            }

            $entregaCapa=DB::table("capa_entregas")
                ->leftJoin("empleados","capa_entregas.id_empleado","=","empleados.id")
                ->leftJoin("vitolas","capa_entregas.id_vitolas","=","vitolas.id")
                ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
                ->leftJoin("marcas","capa_entregas.id_marca","=","marcas.id")
                ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")


                ->select("capa_entregas.id","empleados.nombre AS nombre_empleado",
                    "empleados.codigo AS codigo_empleado",
                    "vitolas.name as nombre_vitolas","semillas.name as nombre_semillas",
                    "calidads.name as nombre_calidads",
                    "capa_entregas.id_empleado",
                    "capa_entregas.id_vitolas",
                    "capa_entregas.id_semilla",
                    "capa_entregas.id_calidad",
                    "capa_entregas.manchada",
                    "capa_entregas.botada",
                    "capa_entregas.rota",
                    "capa_entregas.picada",
                    "capa_entregas.id_marca","marcas.name as nombre_marca"
                    ,"capa_entregas.total")
                ->where("empleados.codigo","Like","%".$query."%")

                ->whereDate("capa_entregas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("empleados.codigo")
              //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $empleados = Empleado::all();
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $vitola = Vitola::all();
            $marca = Marca::all();

            $entregaCapass=DB::table("capa_entregas")
                ->leftJoin("empleados","capa_entregas.id_empleado","=","empleados.id")
                ->leftJoin("vitolas","capa_entregas.id_vitolas","=","vitolas.id")
                ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
                ->leftJoin("marcas","capa_entregas.id_marca","=","marcas.id")
                ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")
                ->selectRaw("SUM(total) as total_capa")
                ->where("empleados.codigo","Like","%".$query."%")
                ->whereDate("capa_entregas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->get();

            return view("EntregaDeCapa.CapaEntrega")
                ->withNoPagina(1)
                ->withEntregaCapa($entregaCapa)
                ->withTotal($entregaCapass)
                ->withEmpleados($empleados)
                ->withSemillas($semilla)
                ->withCalidad($calidad)
                ->withVitola($vitola)
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
    public function StoreEntrega(Request $request){

        $inve  =  DB::table('c_inv_inicials')
            ->leftJoin("semillas","c_inv_inicials.id_semilla","=","semillas.id")
            ->leftJoin("vitolas","c_inv_inicials.id_calidad","=","vitolas.id")
            ->leftJoin("tamanos","c_inv_inicials.id_tamano","=","tamanos.id")
            ->select(
                "c_inv_inicials.id",
                "c_inv_inicials.id_tamano",
                "tamanos.name as nombre_tamanos")
            ->where("c_inv_inicials.id_semilla","=",$request->input("id_semilla"))
            ->where("c_inv_inicials.id_calidad","=",$request->input("id_calidad"))->get();
        if($inve->count()>0){

        }else{

            $nuevoConsumo = new CInvInicial();
            $nuevoConsumo->id_semilla=$request->input('id_semilla');
            $nuevoConsumo->id_calidad=$request->input('id_calidad');
            $nuevoConsumo->id_tamano="2";
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->save();
            $nuevoConsumo = new CInvInicial();
            $nuevoConsumo->id_semilla=$request->input('id_semilla');
            $nuevoConsumo->id_calidad=$request->input('id_calidad');
            $nuevoConsumo->id_tamano="3";
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->save();
            $nuevoConsumo = new CInvInicial();
            $nuevoConsumo->id_semilla=$request->input('id_semilla');
            $nuevoConsumo->id_calidad=$request->input('id_calidad');
            $nuevoConsumo->id_tamano="4";
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->save();

        }
        $fechaa =$request->input('fecha');
        if ($fechaa == null)
            $fechaa = Carbon::now()->format('Y-m-d');
        else{
            $fechaa = $request->get("fecha");

        }
        $nuevoCapaEntrega = new CapaEntrega();

        $nuevoCapaEntrega->id_empleado=$request->input('id_empleado');
        $nuevoCapaEntrega->id_vitolas=$request->input('id_vitolas');
        $nuevoCapaEntrega->id_semilla=$request->input('id_semilla');
        $nuevoCapaEntrega->id_calidad=$request->input('id_calidad');
        $nuevoCapaEntrega->id_marca=$request->input("id_marca");

        if ($request->input('total') == null){
            $nuevoCapaEntrega->total = 0;
        }else {
            $nuevoCapaEntrega->total = $request->input('total');
        }
        $nuevoCapaEntrega->created_at=$fechaa;

        $nuevoCapaEntrega->manchada=0;
        $nuevoCapaEntrega->picada=0;
        $nuevoCapaEntrega->botada=0;
        $nuevoCapaEntrega->rota= 0;


        $nuevoCapaEntrega->save();

        return redirect()->route("CapaEntrega")->withExito("Se creó la entraga Correctamente ");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\CapaEntrega
     * @return \Illuminate\Http\Response
     */

    public function show(CapaEntrega $capaEntrega)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CapaEntrega  $capaEntrega
     * @return \Illuminate\Http\Response
     */
    public function editCapaEntrega( Request $request)
    {
        try{
            $this->validate($request, [
                'id_empleado'=>'required',
                'id_vitolas'=>'required',
                'id_marca'=>'required',
                 'id_semilla'=>'required',

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
            $editarCapaEntrega=CapaEntrega::findOrFail($request->id);

            $editarCapaEntrega->id_empleado=$request->input('id_empleado');
            $editarCapaEntrega->id_vitolas=$request->input('id_vitolas');
            $editarCapaEntrega->id_semilla=$request->input('id_semilla');
            $editarCapaEntrega->id_calidad=$request->input('id_calidad');
            $editarCapaEntrega->id_marca=$request->input("id_marca");
            $editarCapaEntrega->total=$request->input('total');
            $editarCapaEntrega->manchada=$request->input('manchada');
            $editarCapaEntrega->picada=$request->input('picada');
            $editarCapaEntrega->botada=$request->input('botada');
            $editarCapaEntrega->rota=$request->input('rota');


            $editarCapaEntrega->save();
            return redirect()->route("CapaEntrega")->withExito("Se editó Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("CapaEntrega")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CapaEntrega  $capaEntrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CapaEntrega $capaEntrega)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CapaEntrega  $capaEntrega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $capaentrega = $request->input('id');
        $borrar = CapaEntrega::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("CapaEntrega")->withExito("Se borró la entrega satisfactoriamente");
    }


    public function export(Request $request)
    {

        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new EntregaCapaExport($fecha))->download('Listado de Entrega'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new EntregaCapaExport($fecha))->download('Listado De Entrega'.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new EntregaCapaExport($fecha))->download('Listado de Entrega'.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    public function Suma25(Request $request){


        $capaentrega = $request->get('id');

        DB::table('capa_entregas')->where("capa_entregas.id","=",$capaentrega)->increment('total', 50);

        return redirect()->route("CapaEntrega")->withExito("Se editó Correctamente");

    }
    public function Suma50(Request $request){


        $capaentrega = $request->get('id');

        DB::table('capa_entregas')->where("capa_entregas.id","=",$capaentrega)->increment('total', 100);

        return redirect()->route("CapaEntrega")->withExito("Se editó Correctamente");

    }
    public function Sumas(Request $request){

        $incremeto =  $request->get('suma');
        $capaentrega = $request->get('id');

        DB::table('capa_entregas')->where("capa_entregas.id","=",$capaentrega)
            ->increment('total', $incremeto);

        return redirect()->route("CapaEntrega")->withExito("Se editó Correctamente");


    }
}
