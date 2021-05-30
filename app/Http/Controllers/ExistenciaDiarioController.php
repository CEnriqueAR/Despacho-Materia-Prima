<?php

namespace App\Http\Controllers;

use App\BInvInicial;
use App\Calidad;
use App\CapaEntrega;
use App\CInvInicial;
use App\ConsumoBanda;
use App\Empleado;
use App\ExistenciaDiario;
use App\Exports\ConsumoBandaExport;
use App\Exports\ExistenciaDiarioExports;
use App\Marca;
use App\ReBulDiario;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExistenciaDiarioController extends Controller
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

            if ($fecha == null) {
                $fecha = Carbon::now()->format('l');
                if ($fecha == 'Monday') {
                    $fecha = Carbon::now()->subDays(2)->format('Y-m-d');
                    $entregaCapa1=DB::table("capa_entregas")
                        ->leftJoin("empleados","capa_entregas.id_empleado","=","empleados.id")
                        ->leftJoin("vitolas","capa_entregas.id_vitolas","=","vitolas.id")
                        ->leftJoin("semillas","capa_entregas.id_semilla","=","semillas.id")
                        ->leftJoin("marcas","capa_entregas.id_marca","=","marcas.id")
                        ->leftJoin("calidads","capa_entregas.id_calidad","=","calidads.id")


                        ->select("capa_entregas.id","empleados.nombre AS nombre_empleado",
                            "vitolas.name as nombre_vitolas","semillas.name as nombre_semillas",
                            "calidads.name as nombre_calidads",
                            "capa_entregas.id_empleado",
                            "capa_entregas.id_vitolas",
                            "capa_entregas.id_semilla",
                            "capa_entregas.id_calidad",
                            "capa_entregas.id_marca","marcas.name as nombre_marca"
                            ,"capa_entregas.total")
                        ->whereDate("capa_entregas.created_at","=" ,$fecha)
                        ->get();
                    if ($entregaCapa1->count()>0){

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

            $entregaCapa=DB::table("existencia_diarios")
                ->leftJoin("semillas","existencia_diarios.id_semillas","=","semillas.id")
                ->leftJoin("calidads","existencia_diarios.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","existencia_diarios.id_tamano","=","tamanos.id")
                ->select("existencia_diarios.id","semillas.name as nombre_semillas",
                    "calidads.name as nombre_calidads",
                    "existencia_diarios.id_tamano","tamanos.name as nombre_tamano",
                    "existencia_diarios.id_semillas",
                    "existencia_diarios.id_calidad"
                    ,"existencia_diarios.totalinicial","existencia_diarios.pesoinicial"
                    ,"existencia_diarios.totalentrada","existencia_diarios.pesoentrada"
                    ,"existencia_diarios.totalfinal","existencia_diarios.pesofinal",
                    "existencia_diarios.totalconsumo","existencia_diarios.pesoconsumo"
                    ,"existencia_diarios.onzasI"
                    ,"existencia_diarios.onzasE"
                    ,"existencia_diarios.onzasF")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("existencia_diarios.created_at","=" ,$fecha)
                ->orderBy("nombre_semillas")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();

            if ($entregaCapa->count()>0){

            }else{
                $inve  =  DB::table('c_inv_inicials')
                    ->leftJoin("semillas","c_inv_inicials.id_semilla","=","semillas.id")
                    ->leftJoin("calidads","c_inv_inicials.id_calidad","=","calidads.id")
                    ->leftJoin("tamanos","c_inv_inicials.id_tamano","=","tamanos.id")

                    ->select(
                        "c_inv_inicials.id",
                       "semillas.name as nombre_semillas",
                        "calidads.name as nombre_calidads",
                        "c_inv_inicials.id_tamano","tamanos.name as nombre_tamano",
                        "c_inv_inicials.id_semilla",
                        "c_inv_inicials.id_calidad"
                        ,"c_inv_inicials.totalinicial"
                        ,"c_inv_inicials.pesoinicial"
                        ,"c_inv_inicials.onzasI"
                    )->get();

                $fecha1 = $request->get("fecha");
                if ($fecha1 == null) {
                    $fecha1 = Carbon::now()->format('Y-m-d');

                }else{
                    Carbon::parse($fecha1)->format('Y-m-d');

                }
                foreach ($inve as $inventario){
                    $nuevoConsumo = new ExistenciaDiario();
                    $nuevoConsumo->id_semillas = $inventario->id_semilla;
                    $nuevoConsumo->id_calidad = $inventario->id_calidad;
                    $nuevoConsumo->id_tamano = $inventario->id_tamano;
                    $nuevoConsumo->totalinicial = $inventario->totalinicial;
                    $nuevoConsumo->pesoinicial = $inventario->pesoinicial;
                    $nuevoConsumo->onzasI = $inventario->onzasI;

                    $nuevoConsumo->created_at = $fecha;
                    $nuevoConsumo->save();
                }
            }

            foreach ($entregaCapa as $entrega){
                $recibirCapa=DB::table("recibir_capas")
                ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                ->leftJoin("tamanos","recibir_capas.id_tamano","=","tamanos.id")
                ->leftJoin("calidads","recibir_capas.id_calidad","=","calidads.id")

                ->select("recibir_capas.id","tamanos.name AS nombre_tamano",
                    "recibir_capas.id_tamano",
                    "recibir_capas.id_calidad","calidads.name as nombre_calidad",
                    "recibir_capas.id_semillas","semillas.name as nombre_semillas","recibir_capas.total")
                ->where("recibir_capas.id_semillas","=",$entrega->id_semillas)
                ->where("recibir_capas.id_tamano","=",$entrega->id_tamano)
                ->where("recibir_capas.id_calidad","=",$entrega->id_calidad)
                ->whereDate("recibir_capas.created_at","=" ,$fecha)->get();



                foreach ($recibirCapa as $reci){
                    if ($entrega->totalentrada == $reci->total){
                         } else{

                    $editarCapaEntrega=ExistenciaDiario::findOrFail($entrega->id);

                    $editarCapaEntrega->totalentrada = $reci->total;
                    $editarCapaEntrega->save();

                }

                }



            }
            $entregaCapa=DB::table("existencia_diarios")
                ->leftJoin("semillas","existencia_diarios.id_semillas","=","semillas.id")
                ->leftJoin("calidads","existencia_diarios.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","existencia_diarios.id_tamano","=","tamanos.id")
                ->select("existencia_diarios.id","semillas.name as nombre_semillas",
                    "calidads.name as nombre_calidads",
                    "existencia_diarios.id_tamano","tamanos.name as nombre_tamano",
                    "existencia_diarios.id_semillas",
                    "existencia_diarios.id_calidad"
                    ,"existencia_diarios.totalinicial","existencia_diarios.pesoinicial"
                    ,"existencia_diarios.totalentrada","existencia_diarios.pesoentrada"
                    ,"existencia_diarios.totalfinal","existencia_diarios.pesofinal",
                    "existencia_diarios.totalconsumo","existencia_diarios.pesoconsumo"
                    ,"existencia_diarios.onzasI"
                    ,"existencia_diarios.onzasE"
                    ,"existencia_diarios.onzasF")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("existencia_diarios.created_at","=" ,$fecha)
                ->orderBy("nombre_semillas")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();

            return view("InventariosDiarios.ExistenciaDiario")
                ->withNoPagina(1)
                ->withExistenciaDiaria($entregaCapa)
                ->withSemilla($semilla)
                ->withTamano($tamano)
                ->withCalidad($calidad);

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

        $fecha = $request->get("fecha");
        $fecha1 = Carbon::parse($fecha)->format('Y-m-d');
        $inve  =  DB::table('c_inv_inicials')
            ->leftJoin("semillas","c_inv_inicials.id_semilla","=","semillas.id")
            ->leftJoin("calidads","c_inv_inicials.id_calidad","=","calidads.id")
            ->leftJoin("tamanos","c_inv_inicials.id_tamano","=","tamanos.id")

            ->select(
                "c_inv_inicials.id",
                "semillas.name as nombre_semillas",
                "calidads.name as nombre_calidads",
                "c_inv_inicials.id_tamano","tamanos.name as nombre_tamano",
                "c_inv_inicials.id_semilla",
                "c_inv_inicials.id_calidad"
                ,"c_inv_inicials.totalinicial", "c_inv_inicials.updated_at"
            )
            ->where("c_inv_inicials.id_semilla","=",$request->input('id_semillas'))
            ->where("c_inv_inicials.id_tamano","=",$request->input("id_tamano"))
            ->where("c_inv_inicials.id_calidad","=",$request->input('id_calidad'))->get();
        if($inve->count()>0){


            $inventarioDiario=DB::table("existencia_diarios")
                ->leftJoin("semillas","existencia_diarios.id_semillas","=","semillas.id")
                ->leftJoin("calidads","existencia_diarios.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","existencia_diarios.id_tamano","=","tamanos.id")
                ->select("existencia_diarios.id"
                    ,"existencia_diarios.created_at")
                ->where("existencia_diarios.id","=",$request->id)->get();

            foreach  ($inve as $inventario) {

                foreach ($inventarioDiario as $diario) {
                    $ingresada = $diario->created_at;
                }
                $actual = $inventario->updated_at;

                if (Carbon::parse($ingresada)->format('Y-m-d') >= (Carbon::parse($actual)->format('Y-m-d'))) {



                    $editarBultoEntrega = CInvInicial::findOrFail($inventario->id);
                    $editarBultoEntrega->totalinicial = $request->input("totalfinal");
                    $editarBultoEntrega->pesoinicial=(($request->input("onzasF")*($request->input("totalfinal")/50))/16);
                    $editarBultoEntrega->updated_at = Carbon::parse($ingresada)->format('Y-m-d');
                    $editarBultoEntrega->onzasI = $request->input("onzasF");

                    $editarBultoEntrega->save();
                }
            }

        }else{
            $nuevoConsumo = new CInvInicial();

            $nuevoConsumo->id_semilla = $request->input('id_semillas');
            $nuevoConsumo->id_calidad = $request->input('id_calidad');
            $nuevoConsumo->id_tamano = $request->input("id_tamano");
            $nuevoConsumo->totalinicial = ($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
            $nuevoConsumo->pesoinicial=(($request->input("onzas")*($request->input("totalfinal")/50))/16);
            $nuevoConsumo->onzasI = $request->input("onzasF");
            $nuevoConsumo->updated_at =$fecha1;
            $nuevoConsumo->created_at =$fecha1;
            $nuevoConsumo->save();
        }

        $nuevoInvDiario = new ExistenciaDiario();
        $nuevoInvDiario->id_semillas=$request->input('id_semillas');
        $nuevoInvDiario->id_calidad=$request->input('id_calidad');
        $nuevoInvDiario->id_tamano=$request->input("id_tamano");
        $nuevoInvDiario->totalinicial=$request->input("totalinicial");
        $nuevoInvDiario->pesoinicial=(($request->input("onzasI")*($request->input("totalinicial")/50))/16);
        $nuevoInvDiario->totalentrada=$request->input("totalentrada");
        $nuevoInvDiario->pesoentrada=(($request->input("onzasE")*($request->input("totalentrada")/50))/16);
        $nuevoInvDiario->totalfinal=$request->input("totalfinal");
        $nuevoInvDiario->pesofinal=(($request->input("onzasF")*($request->input("totalfinal")/50))/16);
        $nuevoInvDiario->totalconsumo=($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
        $nuevoInvDiario->pesoconsumo =(($request->input("onzasE")* ($nuevoInvDiario->totalconsumo/50))/16);
        $nuevoInvDiario->onzasI =$request->input("onzasI");
        $nuevoInvDiario->onzasE=$request->input("onzasE");
        $nuevoInvDiario->onzasF=$request->input("onzasF");
        $nuevoInvDiario->created_at =$fecha1;





        $nuevoInvDiario->save();

        return redirect()->route("ExistenciaDiario")->withExito("Se creó la entrega Correctamente ");

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function show(ExistenciaDiario $existenciaDiario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {



        $total = ($request->input("totalfinal"));
        if($total == null){


        }else{

            $inve  =  DB::table('c_inv_inicials')
                ->leftJoin("semillas","c_inv_inicials.id_semilla","=","semillas.id")
                ->leftJoin("calidads","c_inv_inicials.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","c_inv_inicials.id_tamano","=","tamanos.id")

                ->select(
                    "c_inv_inicials.id",
                    "semillas.name as nombre_semillas",
                    "calidads.name as nombre_calidads",
                    "c_inv_inicials.updated_at",

                    "c_inv_inicials.id_tamano","tamanos.name as nombre_tamano",
                    "c_inv_inicials.id_semilla",
                    "c_inv_inicials.id_calidad"
                    ,"c_inv_inicials.totalinicial"
                )
                ->where("c_inv_inicials.id_semilla","=",$request->input('id_semillas'))
                ->where("c_inv_inicials.id_tamano","=",$request->input("id_tamano"))
                ->where("c_inv_inicials.id_calidad","=",$request->input('id_calidad'))->get();
            $inventarioDiario=DB::table("existencia_diarios")
                ->leftJoin("semillas","existencia_diarios.id_semillas","=","semillas.id")
                ->leftJoin("calidads","existencia_diarios.id_calidad","=","calidads.id")
                ->leftJoin("tamanos","existencia_diarios.id_tamano","=","tamanos.id")
                ->select("existencia_diarios.id"
                    ,"existencia_diarios.created_at")
                ->where("existencia_diarios.id","=",$request->id)->get();

            foreach  ($inve as $inventario) {

                foreach ($inventarioDiario as $diario) {
                    $ingresada = $diario->created_at;
                }
                $actual = $inventario->updated_at;

                if (Carbon::parse($ingresada)->format('Y-m-d') >= (Carbon::parse($actual)->format('Y-m-d'))) {



                    $editarBultoEntrega = CInvInicial::findOrFail($inventario->id);
                    $editarBultoEntrega->totalinicial = $request->input("totalfinal");
                    $editarBultoEntrega->pesoinicial=(($request->input("onzasF")*($request->input("totalfinal")/50))/16);
                    $editarBultoEntrega->updated_at = Carbon::parse($ingresada)->format('Y-m-d');
                    $editarBultoEntrega->onzasI = $request->input("onzasF");

                    $editarBultoEntrega->save();
                }
            }
        }

        $EditarInvDiario=ExistenciaDiario::findOrFail($request->id);
        $EditarInvDiario->id_semillas=$request->input('id_semillas');
        $EditarInvDiario->id_calidad=$request->input('id_calidad');
        $EditarInvDiario->id_tamano=$request->input("id_tamano");
        $EditarInvDiario->totalinicial=$request->input("totalinicial");
        $EditarInvDiario->pesoinicial=(($request->input("onzasI")*($request->input("totalinicial")/50))/16);
        $EditarInvDiario->totalentrada=$request->input("totalentrada");
        $EditarInvDiario->pesoentrada=(($request->input("onzasE")*($request->input("totalentrada")/50))/16);
        $EditarInvDiario->totalfinal=$request->input("totalfinal");
        $EditarInvDiario->pesofinal=(($request->input("onzasF")*($request->input("totalfinal")/50))/16);
        $EditarInvDiario->totalconsumo=($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
        $EditarInvDiario->pesoconsumo=(($request->input("onzasE")*($EditarInvDiario->totalconsumo)/50)/16);
            $EditarInvDiario->onzasI =$request->input("onzasI");
            $EditarInvDiario->onzasE=$request->input("onzasE");
            $EditarInvDiario->onzasF=$request->input("onzasF");
        $EditarInvDiario->save();
        return redirect()->route("ExistenciaDiario")->withExito("Se editó Correctamente");

    }catch (ValidationException $exception){
return redirect()->route("ExistenciaDiario")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
}
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExistenciaDiario $existenciaDiario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExistenciaDiario  $existenciaDiario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $capaentrega = $request->input('id');
        $borrar = ExistenciaDiario::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("ExistenciaDiario")->withExito("Se borró la entrega satisfactoriamente");
        //
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
        return (new ExistenciaDiarioExports($fecha))->download('Listado Inventario de Capa'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ExistenciaDiarioExports($fecha))->download('Listado Inventario de Capa'.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new ExistenciaDiarioExports($fecha))->download('Listado Inventario de Capa '.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
