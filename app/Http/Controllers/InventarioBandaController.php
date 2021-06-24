<?php

namespace App\Http\Controllers;

use App\BandaInvInicial;
use App\Calidad;
use App\CInvInicial;
use App\ExistenciaDiario;
use App\Exports\ExistenciaDiarioExports;
use App\Exports\InventarioBandaExport;
use App\InventarioBanda;
use App\Procedencia;
use App\Semilla;
use App\Tamano;
use App\Variedad;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioBandaController extends Controller
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

            $entregaCapa=DB::table("inventario_bandas")
                ->leftJoin("semillas","inventario_bandas.id_semillas","=","semillas.id")
                ->leftJoin("variedads", "inventario_bandas.id_variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "inventario_bandas.id_procedencia", "=", "procedencias.id")
                ->leftJoin("tamanos","inventario_bandas.id_tamano","=","tamanos.id")
                ->select("inventario_bandas.id","semillas.name as nombre_semillas",
                    "inventario_bandas.id_tamano","tamanos.name as nombre_tamano",
                    "inventario_bandas.id_semillas",
                    "inventario_bandas.id_variedad", "variedads.name as nombre_variedad",
                    "inventario_bandas.id_procedencia", "procedencias.name as nombre_procedencia"
                    ,"inventario_bandas.totalinicial","inventario_bandas.pesoinicial"
                    ,"inventario_bandas.totalentrada","inventario_bandas.pesoentrada"
                    ,"inventario_bandas.totalfinal","inventario_bandas.pesofinal",
                    "inventario_bandas.totalconsumo","inventario_bandas.pesoconsumo"
                    ,"inventario_bandas.pesobanda")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("inventario_bandas.created_at","=" ,$fecha)
                ->orderBy("nombre_semillas")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $tamano = Tamano::all();

            if ($entregaCapa->count()>0){

            }else{
                $inve  =  DB::table('banda_inv_inicials')
                    ->leftJoin("semillas","banda_inv_inicials.id_semilla","=","semillas.id")
                    ->leftJoin("tamanos","banda_inv_inicials.id_tamano","=","tamanos.id")
                    ->leftJoin("variedads", "banda_inv_inicials.id_variedad", "=", "variedads.id")
                    ->leftJoin("procedencias", "banda_inv_inicials.id_procedencia", "=", "procedencias.id")

                    ->select(
                        "banda_inv_inicials.id",
                        "semillas.name as nombre_semillas",
                        "banda_inv_inicials.id_tamano","tamanos.name as nombre_tamano",
                        "banda_inv_inicials.id_variedad", "variedads.name as nombre_variedad",
                        "banda_inv_inicials.id_procedencia", "procedencias.name as nombre_procedencia",
                        "banda_inv_inicials.id_semilla"
                        ,"banda_inv_inicials.totalinicial"
                        ,"banda_inv_inicials.pesoinicial"
                        ,"banda_inv_inicials.onzasI"

                    )->get();

                $fecha1 = $request->get("fecha");
                if ($fecha1 == null) {
                    $fecha1 = Carbon::now()->format('Y-m-d');

                }else{
                    Carbon::parse($fecha1)->format('Y-m-d');

                }
                foreach ($inve as $inventario){
                    $nuevoConsumo = new InventarioBanda();
                    $nuevoConsumo->id_semillas = $inventario->id_semilla;
                    $nuevoConsumo->id_tamano = $inventario->id_tamano;
                    $nuevoConsumo->totalinicial = $inventario->totalinicial;
                    $nuevoConsumo->pesoinicial = $inventario->pesoinicial;
                    $nuevoConsumo->id_variedad = $inventario->id_variedad;
                    $nuevoConsumo->id_procedencia = $inventario->id_procedencia;
                    $nuevoConsumo->created_at = $fecha;
                    $nuevoConsumo->save();
                }
            }

            foreach ($entregaCapa as $entrega){
                $recibirCapa = DB::table("entrada_bandas")
                    ->leftJoin("semillas", "entrada_bandas.id_semilla", "=", "semillas.id")
                    ->leftJoin("tamanos", "entrada_bandas.id_tamano", "=", "tamanos.id")
                    ->leftJoin("variedads", "entrada_bandas.id_variedad", "=", "variedads.id")
                    ->leftJoin("procedencias", "entrada_bandas.id_procedencia", "=", "procedencias.id")
                    ->select("entrada_bandas.id", "tamanos.name AS nombre_tamano",
                        "entrada_bandas.id_tamano",
                        "entrada_bandas.origen",
                        "entrada_bandas.id_semilla", "semillas.name as nombre_semillas",
                        "entrada_bandas.id_variedad", "variedads.name as nombre_variedad",
                        "entrada_bandas.id_procedencia", "procedencias.name as nombre_procedencia"
                        , "entrada_bandas.total" )
                    ->where("entrada_bandas.id_semilla","=",$entrega->id_semillas)
                    ->where("entrada_bandas.id_variedad","=",$entrega->id_variedad)
                    ->where("entrada_bandas.id_procedencia","=",$entrega->id_procedencia)
                    ->where("entrada_bandas.id_tamano","=",$entrega->id_tamano)
                    ->whereDate("entrada_bandas.created_at","=" ,$fecha)->get();



                foreach ($recibirCapa as $reci){
                    if ($entrega->totalentrada == $reci->total){
                    } else{

                        $editarCapaEntrega=InventarioBanda::findOrFail($entrega->id);
                        $editarCapaEntrega->totalentrada = $reci->total;
                        $editarCapaEntrega->save();

                    }

                }



            }
            $entregaCapa=DB::table("inventario_bandas")
                ->leftJoin("semillas","inventario_bandas.id_semillas","=","semillas.id")
                ->leftJoin("variedads", "inventario_bandas.id_variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "inventario_bandas.id_procedencia", "=", "procedencias.id")
                ->leftJoin("tamanos","inventario_bandas.id_tamano","=","tamanos.id")
                ->select("inventario_bandas.id","semillas.name as nombre_semillas",
                    "inventario_bandas.id_tamano","tamanos.name as nombre_tamano",
                    "inventario_bandas.id_semillas",
                    "inventario_bandas.id_variedad", "variedads.name as nombre_variedad",
                    "inventario_bandas.id_procedencia", "procedencias.name as nombre_procedencia"
                    ,"inventario_bandas.totalinicial","inventario_bandas.pesoinicial"
                    ,"inventario_bandas.totalentrada","inventario_bandas.pesoentrada"
                    ,"inventario_bandas.totalfinal","inventario_bandas.pesofinal",
                    "inventario_bandas.totalconsumo","inventario_bandas.pesoconsumo"
                    ,"inventario_bandas.pesobanda")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("inventario_bandas.created_at","=" ,$fecha)
                ->orderBy("nombre_semillas")
                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $semilla = Semilla::all();
            $calidad = Calidad::all();
            $tamano = Tamano::all();

            $variedad = Variedad::all();
            $procedencia =Procedencia::all();
            return view("InventariosDiarios.InventarioBanda")
                ->withNoPagina(1)
                ->withExistenciaDiaria($entregaCapa)
                ->withSemilla($semilla)
                ->withTamano($tamano)
                ->withCalidad($calidad)
                ->withVariedad($variedad)
                ->withProcedencia($procedencia);

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
        $inve  = DB::table("banda_inv_inicials")
        ->leftJoin("semillas", "banda_inv_inicials.id_semilla", "=", "semillas.id")
        ->leftJoin("tamanos", "banda_inv_inicials.id_tamano", "=", "tamanos.id")
        ->leftJoin("variedads", "banda_inv_inicials.id_variedad", "=", "variedads.id")
        ->leftJoin("procedencias", "banda_inv_inicials.id_procedencia", "=", "procedencias.id")

            ->select("banda_inv_inicials.id", "tamanos.name AS nombre_tamano",
            "banda_inv_inicials.id_tamano",
                "banda_inv_inicials.updated_at",
            "banda_inv_inicials.id_semilla", "semillas.name as nombre_semillas",
                "banda_inv_inicials.id_variedad", "variedads.name as nombre_variedad",
                "banda_inv_inicials.id_procedencia", "procedencias.name as nombre_procedencia"
            , "banda_inv_inicials.totalinicial" )
        ->where("banda_inv_inicials.id_semilla","=",$request->input('id_semillas'))

            ->where("banda_inv_inicials.id_variedad","=",$request->input('id_variedad'))
            ->where("banda_inv_inicials.id_procedencia","=",$request->input('id_procedencia'))
            ->where("banda_inv_inicials.id_tamano","=",$request->input("id_tamano"))
            ->where("banda_inv_inicials.id_semilla","=",$request->input("id_semilla"))->get();
        if($inve->count()>0){


            $inventarioDiario=DB::table("inventario_bandas")
                ->leftJoin("semillas","inventario_bandas.id_semillas","=","semillas.id")

                ->leftJoin("variedads", "inventario_bandas.id_variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "inventario_bandas.id_procedencia", "=", "procedencias.id")
                ->leftJoin("tamanos","inventario_bandas.id_tamano","=","tamanos.id")
                ->select("inventario_bandas.id"
                    ,"inventario_bandas.created_at")
                ->where("inventario_bandas.id","=",$request->id)->get();

            foreach  ($inve as $inventario) {

                foreach ($inventarioDiario as $diario) {
                    $ingresada = $diario->created_at;
                }
                $actual = $inventario->updated_at;

                if (Carbon::parse($ingresada)->format('Y-m-d') >= (Carbon::parse($actual)->format('Y-m-d'))) {



                    $editarBultoEntrega = BandaInvInicial::findOrFail($inventario->id);
                    $editarBultoEntrega->totalinicial = $request->input("totalfinal");
                    $editarBultoEntrega->pesoinicial=$request->input("totalinicial");
                    $editarBultoEntrega->updated_at = Carbon::parse($ingresada)->format('Y-m-d');
                    $editarBultoEntrega->id_variedad= $request->input("id_variedad");
                    $editarBultoEntrega->id_procedencia= $request->input("id_procedencia");

                    $editarBultoEntrega->save();
                }
            }


        }else{
            $nuevoConsumo = new BandaInvInicial();

            $nuevoConsumo->id_semilla = $request->input('id_semillas');
            $nuevoConsumo->id_tamano = $request->input("id_tamano");
            $nuevoConsumo->totalinicial = $request->input("totalfinal");
            $nuevoConsumo->pesoinicial= $request->input("pesofinal");
            $nuevoConsumo->id_variedad= $request->input("id_variedad");
            $nuevoConsumo->id_procedencia= $request->input("id_procedencia");
            $nuevoConsumo->updated_at =$fecha1;
            $nuevoConsumo->created_at =$fecha1;
            $nuevoConsumo->save();
        }

        $nuevoInvDiario = new InventarioBanda();
        $nuevoInvDiario->id_semillas=$request->input('id_semillas');
        $nuevoInvDiario->id_variedad= $request->input("id_variedad");
        $nuevoInvDiario->id_procedencia= $request->input("id_procedencia");
        $nuevoInvDiario->id_tamano=$request->input("id_tamano");
        $nuevoInvDiario->totalinicial=$request->input("totalinicial");
        $nuevoInvDiario->pesoinicial=$request->input("pesoinicial");
        $nuevoInvDiario->totalentrada=$request->input("totalentrada");
        $nuevoInvDiario->pesoentrada=$request->input("pesoentrada");
        $nuevoInvDiario->totalfinal=$request->input("totalfinal");
        $nuevoInvDiario->pesofinal=$request->input("pesofinal");
        $nuevoInvDiario->totalconsumo=($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
        $nuevoInvDiario->pesoconsumo =( $nuevoInvDiario->pesoinicial+$nuevoInvDiario->pesoentrada)- $nuevoInvDiario->pesofinal;
        $nuevoInvDiario->created_at =$fecha1;





        $nuevoInvDiario->save();

        return redirect()->route("InventarioBanda")->withExito("Se creó la entrega Correctamente ");

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InventarioBanda  $inventarioBanda
     * @return \Illuminate\Http\Response
     */
    public function show(InventarioBanda $inventarioBanda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InventarioBanda  $inventarioBanda
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {



        $total = ($request->input("totalfinal"));
        if($total == null){


        }else{

            $inve  = DB::table("banda_inv_inicials")
                ->leftJoin("semillas", "banda_inv_inicials.id_semilla", "=", "semillas.id")
                ->leftJoin("variedads", "banda_inv_inicials.id_variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "banda_inv_inicials.id_procedencia", "=", "procedencias.id")
                ->leftJoin("tamanos", "banda_inv_inicials.id_tamano", "=", "tamanos.id")
                ->select("banda_inv_inicials.id", "tamanos.name AS nombre_tamano",
                    "banda_inv_inicials.id_tamano"
                    ,"banda_inv_inicials.updated_at",
                    "banda_inv_inicials.id_semilla", "semillas.name as nombre_semillas"
                    , "banda_inv_inicials.totalinicial" , "banda_inv_inicials.id_variedad")
                ->where("banda_inv_inicials.id_semilla","=",$request->input('id_semillas'))
                ->where("banda_inv_inicials.id_variedad","=",$request->input("id_variedad"))
                ->where("banda_inv_inicials.id_procedencia","=",$request->input("id_procedencia"))
                ->where("banda_inv_inicials.id_tamano","=",$request->input("id_tamano"))
                ->where("banda_inv_inicials.id_variedad","=",$request->input("id_variedad"))->get();

                  $inventarioDiario=DB::table("inventario_bandas")
                ->leftJoin("semillas","inventario_bandas.id_semillas","=","semillas.id")

                ->leftJoin("variedads", "inventario_bandas.id_variedad", "=", "variedads.id")
                ->leftJoin("procedencias", "inventario_bandas.id_procedencia", "=", "procedencias.id")
                ->leftJoin("tamanos","inventario_bandas.id_tamano","=","tamanos.id")
                ->select("inventario_bandas.id"
                    ,"inventario_bandas.created_at")
                ->where("inventario_bandas.id","=",$request->id)->get();

            foreach  ($inve as $inventario) {

                foreach ($inventarioDiario as $diario) {
                    $ingresada = $diario->created_at;
                }
                $actual = $inventario->updated_at;

                if (Carbon::parse($ingresada)->format('Y-m-d') >= (Carbon::parse($actual)->format('Y-m-d'))) {



                    $editarBultoEntrega = BandaInvInicial::findOrFail($inventario->id);
                    $editarBultoEntrega->totalinicial = $request->input("totalfinal");
                    $editarBultoEntrega->pesoinicial=$request->input("totalinicial");
                    $editarBultoEntrega->updated_at = Carbon::parse($ingresada)->format('Y-m-d');
                    $editarBultoEntrega->id_variedad= $request->input("id_variedad");
                    $editarBultoEntrega->id_procedencia= $request->input("id_procedencia");

                    $editarBultoEntrega->save();
                }
            }
        }

            $nuevoInvDiario= InventarioBanda::findOrFail($request->id);
            $nuevoInvDiario->id_semillas=$request->input('id_semillas');
            $nuevoInvDiario->id_variedad= $request->input("id_variedad");
            $nuevoInvDiario->id_procedencia= $request->input("id_procedencia");
            $nuevoInvDiario->id_tamano=$request->input("id_tamano");
            $nuevoInvDiario->totalinicial=$request->input("totalinicial");
            $nuevoInvDiario->pesoinicial=$request->input("pesoinicial");
            $nuevoInvDiario->totalentrada=$request->input("totalentrada");
            $nuevoInvDiario->pesoentrada=$request->input("pesoentrada");
            $nuevoInvDiario->totalfinal=$request->input("totalfinal");
            $nuevoInvDiario->pesofinal=$request->input("pesofinal");
            $nuevoInvDiario->totalconsumo=($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
            $nuevoInvDiario->pesoconsumo =( $nuevoInvDiario->pesoinicial+$nuevoInvDiario->pesoentrada)- $nuevoInvDiario->pesofinal;

            $nuevoInvDiario->save();
        return redirect()->route("InventarioBanda")->withExito("Se editó Correctamente");

    }catch (ValidationException $exception){
        return redirect()->route("InventarioBanda")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
    }
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InventarioBanda  $inventarioBanda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventarioBanda $inventarioBanda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InventarioBanda  $inventarioBanda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $capaentrega = $request->input('id');
        $borrar = InventarioBanda::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("InventarioBanda")->withExito("Se borró la entrega satisfactoriamente");
    }public function export(Request $request)
{

    $fecha = $request->get("fecha1");

    if ($fecha = null)
        $fecha = Carbon::now()->format('Y-m-d');
    else {
        $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

    }
    return (new InventarioBandaExport($fecha))->download('Listado Inventario de Banda'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

}

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new InventarioBandaExport($fecha))->download('Listado Inventario de Banda'.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new InventarioBandaExport($fecha))->download('Listado Inventario de Banda '.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
