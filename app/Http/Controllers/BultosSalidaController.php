<?php

namespace App\Http\Controllers;

use App\BInvInicial;
use App\BultosSalida;
use App\ConsumoBanda;
use App\Empleado;
use App\EmpleadosBanda;
use App\Exports\EntregaBultoExport;
use App\Exports\EntregaCapaExport;
use App\Marca;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BultosSalidaController extends Controller
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

            if ($fecha = null)
                $fecha = Carbon::now()->format('Y-m-d');
            else{
                $fecha = $request->get("fecha");

            }

            $bultoentrega=DB::table("bultos_salidas")
                ->leftJoin("empleados_bandas","bultos_salidas.id_empleado","=","empleados_bandas.id")
                ->leftJoin("vitolas","bultos_salidas.id_vitolas","=","vitolas.id")
                ->leftJoin("marcas","bultos_salidas.id_marca","=","marcas.id")

                ->select("bultos_salidas.id",
                    "empleados_bandas.nombre AS nombre_empleado",
                    "vitolas.name as nombre_vitolas",
                    "bultos_salidas.id_empleado",
                    "bultos_salidas.id_vitolas",
                    "bultos_salidas.id_marca","marcas.name as nombre_marca"
                    ,"bultos_salidas.total")
                ->where("empleados_bandas.nombre","Like","%".$query."%")
                ->whereDate("bultos_salidas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("nombre_marca")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $empleados = EmpleadosBanda::all();
            $vitola = Vitola::all();
            $marca = Marca::all();

            return view("BultosSalida.Bultossalida")
                ->withNoPagina(1)
                ->withEntregaBulto($bultoentrega)
                ->withEmpleados($empleados)
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
                'id_empleado'=>'required',
                'id_vitolas'=>'required',
                'id_marca'=>'required',
            ]);

        //para consultar si existe la marca y vitola en la tabla consumo de banda y si no existe se inserta
        $banda  =  DB::table('consumo_bandas')
            ->leftJoin("vitolas","consumo_bandas.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","consumo_bandas.id_marca","=","marcas.id")
            ->select(
                "vitolas.name as nombre_vitolas",
                "marcas.name as nombre_marca",
                "consumo_bandas.id_vitolas",
                "consumo_bandas.id_marca")
            ->where("consumo_bandas.id_marca","=",$request->input("id_marca"))
            ->where("consumo_bandas.id_vitolas","=",$request->input("id_vitolas"))
            ->whereDate("consumo_bandas.created_at","=" ,Carbon::now()->format('Y-m-d'))->paginate(1000);
        if($banda->count()>0){
        }else{
            $nuevoConsumo = new ConsumoBanda();
            $nuevoConsumo->id_vitolas=$request->input('id_vitolas');
            $nuevoConsumo->id_marca=$request->input("id_marca");
            $nuevoConsumo->id_semillas= '1';
            $nuevoConsumo->id_tamano='1';
            $nuevoConsumo->save();
        }
//parea ver si exiaste en la tabla intermediaria y si no la inserta

        $inve  =  DB::table('b_inv_inicials')
            ->leftJoin("vitolas","b_inv_inicials.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","b_inv_inicials.id_marca","=","marcas.id")
            ->select(
                "vitolas.name as nombre_vitolas",
                "marcas.name as nombre_marca",
                "consumo_bandas.id_vitolas",
                "consumo_bandas.id_marca")
            ->where("b_inv_inicials.id_marca","=",$request->input("id_marca"))
            ->where("b_inv_inicials.id_vitolas","=",$request->input("id_vitolas"));
        if($inve->count()>0){
        }else{
            $nuevoConsumo = new BInvInicial();
            $nuevoConsumo->id_vitolas=$request->input('id_vitolas');
            $nuevoConsumo->id_marca=$request->input("id_marca");
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->save();
        }





        $nuevoBultoEntrega = new BultosSalida();
        $nuevoBultoEntrega->id_empleado=$request->input('id_empleado');
        $nuevoBultoEntrega->id_vitolas=$request->input('id_vitolas');
        $nuevoBultoEntrega->id_marca=$request->input("id_marca");
        $nuevoBultoEntrega->total=('1');




        $nuevoBultoEntrega->save();

        return redirect()->route("BultoSalida")->withExito("Se creó la entrega Correctamente ");
        }catch (ValidationException $exception){
            return redirect()->route("BultoSalida")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BultosSalida  $bultosSalida
     * @return \Illuminate\Http\Response
     */
    public function show(BultosSalida $bultosSalida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BultosSalida  $bultosSalida
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        try{
            $this->validate($request, [
                'id_empleado'=>'required',
                'id_vitolas'=>'required',
                'id_marca'=>'required',
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
            $editarBultoEntrega=BultosSalida::findOrFail($request->id);

            $editarBultoEntrega->id_empleado=$request->input('id_empleado');
            $editarBultoEntrega->id_vitolas=$request->input('id_vitolas');
            $editarBultoEntrega->id_marca=$request->input("id_marca");
            $editarBultoEntrega->total=$request->input('total');


            $editarBultoEntrega->save();
            return redirect()->route("BultoSalida")->withExito("Se editó La Salida  Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("BultoSalida")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BultosSalida  $bultosSalida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BultosSalida  $bultosSalida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $capaentrega = $request->input('id');
        $borrar = BultosSalida::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("BultoSalida")->withExito("Se borró la entrega satisfactoriamente");
        //
    }


    public function Suma(Request $request){


        $capaentrega = $request->get('id');

        DB::table('bultos_salidas')->where("bultos_salidas.id","=",$capaentrega)->increment('total', 1);

        return redirect()->route("BultoSalida")->withExito("Se Incremento el bulto  Correctamente");
    }


    public function export(Request $request)
    {

        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new EntregaBultoExport($fecha))->download('Listado de Entrega Bultos'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new EntregaBultoExport($fecha))->download('Listado De Entrega Bultos '.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new EntregaBultoExport($fecha))->download('Listado de Entrega Bultos'.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
