<?php

namespace App\Http\Controllers;

use App\BInvInicial;
use App\BultosSalida;
use App\Exports\EntregaBultoExport;
use App\Exports\InventarioDiarioBultosExports;
use App\Marca;
use App\ReBulDiario;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReBulDiarioController extends Controller
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

            $inventarioDiario=DB::table("re_bul_diarios")
                ->leftJoin("vitolas","re_bul_diarios.id_vitolas","=","vitolas.id")
                ->leftJoin("marcas","re_bul_diarios.id_marca","=","marcas.id")
                ->select("re_bul_diarios.id",
                    "vitolas.name as nombre_vitolas",
                    "re_bul_diarios.id_vitolas",
                    "re_bul_diarios.id_marca","marcas.name as nombre_marca"
                    ,"re_bul_diarios.totalinicial","re_bul_diarios.pesoinicial"
                    ,"re_bul_diarios.totalentrada","re_bul_diarios.pesoentrada"
                    ,"re_bul_diarios.totalfinal","re_bul_diarios.pesofinal",
                    "re_bul_diarios.totalconsumo","re_bul_diarios.pesoconsumo"
                    ,"re_bul_diarios.onzas")
                ->where("marcas.name","Like","%".$query."%")
                ->whereDate("re_bul_diarios.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("nombre_marca")

                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $vitola = Vitola::all();
            $marca = Marca::all();

            if($inventarioDiario->count()>0){


            }

            else {

                $inve = DB::table('b_inv_inicials')
                    ->leftJoin("vitolas", "b_inv_inicials.id_vitolas", "=", "vitolas.id")
                    ->leftJoin("marcas", "b_inv_inicials.id_marca", "=", "marcas.id")
                    ->select(
                        "vitolas.name as nombre_vitolas",
                        "marcas.name as nombre_marca",
                        "b_inv_inicials.id_vitolas",
                        "b_inv_inicials.id_marca",
                        "b_inv_inicials.totalinicial")->paginate(1000);

                foreach ($inve as $inventario) {

                $nuevoConsumo = new ReBulDiario();
                $nuevoConsumo->id_vitolas = $inventario->id_vitolas;
                $nuevoConsumo->id_marca = $inventario->id_marca;
                $nuevoConsumo->totalinicial = $inventario->totalinicial;
                $nuevoConsumo->created_at = Carbon::parse($fecha)->format('Y-m-d');
                $nuevoConsumo->save();
            }
            }


            return view("InventariosDiarios.ReBulDiario")
                ->withNoPagina(1)
                ->withInvDiario($inventarioDiario)
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

        $inve = DB::table('b_inv_inicials')
            ->leftJoin("vitolas", "b_inv_inicials.id_vitolas", "=", "vitolas.id")
            ->leftJoin("marcas", "b_inv_inicials.id_marca", "=", "marcas.id")
            ->select(
                "vitolas.name as nombre_vitolas",
                "marcas.name as nombre_marca",
                "b_inv_inicials.id",
                "b_inv_inicials.updated_at",
                "b_inv_inicials.id_vitolas",
                "b_inv_inicials.id_marca",
                "b_inv_inicials.totalinicial")
            ->where("b_inv_inicials.id_vitolas","=",$request->input('id_vitolas'))
            ->where("b_inv_inicials.id_marca","=",$request->input("id_marca"))->get();
        if($inve->count()>0) {
    }else{
$nuevoConsumo = new BInvInicial();
$nuevoConsumo->id_vitolas=$request->input('id_vitolas');
$nuevoConsumo->id_marca=$request->input("id_marca");
$nuevoConsumo->totalinicial= ($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal"); ;
$nuevoConsumo->save();
}

        $nuevoInvDiario = new ReBulDiario();
        $nuevoInvDiario->onzas=$request->input("onzas");
        $nuevoInvDiario->id_vitolas=$request->input('id_vitolas');
        $nuevoInvDiario->id_marca=$request->input("id_marca");
        $nuevoInvDiario->totalinicial=$request->input("totalinicial");
        $nuevoInvDiario->pesoinicial=(($request->input("onzas")*$request->input("totalinicial"))/16);
        $nuevoInvDiario->totalentrada=$request->input("totalentrada");
        $nuevoInvDiario->pesoentrada=(($request->input("onzas")*$request->input("totalentrada"))/16);
        $nuevoInvDiario->totalfinal=$request->input("totalfinal");
        $nuevoInvDiario->pesofinal=(($request->input("onzas")*$request->input("totalfinal"))/16);
        $nuevoInvDiario->totalconsumo=($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
        $nuevoInvDiario->pesoconsumo =(($request->input("onzas")* $nuevoInvDiario->totalconsumo)/16);




        $nuevoInvDiario->save();

        return redirect()->route("InventarioDiario")->withExito("Se creó la entrega Correctamente ");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReBulDiario  $reBulDiario
     * @return \Illuminate\Http\Response
     */
    public function show(ReBulDiario $reBulDiario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReBulDiario  $reBulDiario
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        try{
            $this->validate($request, [

                'id_marca'=>'required',

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

              $total = ($request->input("totalfinal"));
    if($total = null){


    }else{
        $inve = DB::table('b_inv_inicials')
            ->leftJoin("vitolas", "b_inv_inicials.id_vitolas", "=", "vitolas.id")
            ->leftJoin("marcas", "b_inv_inicials.id_marca", "=", "marcas.id")
            ->select(
                "vitolas.name as nombre_vitolas",
                "marcas.name as nombre_marca",
                "b_inv_inicials.id",
                "b_inv_inicials.updated_at",
                "b_inv_inicials.id_vitolas",
                "b_inv_inicials.id_marca",
                "b_inv_inicials.totalinicial")
            ->where("b_inv_inicials.id_vitolas","=",$request->input('id_vitolas'))
            ->where("b_inv_inicials.id_marca","=",$request->input("id_marca"))->get();



        $inventarioDiario=DB::table("re_bul_diarios")
            ->leftJoin("vitolas","re_bul_diarios.id_vitolas","=","vitolas.id")
            ->leftJoin("marcas","re_bul_diarios.id_marca","=","marcas.id")
            ->select("re_bul_diarios.id",
                "re_bul_diarios.created_at")
            ->where("re_bul_diarios.id","=",$request->id)->get();


        foreach  ($inve as $inventario) {

            foreach ($inventarioDiario as $diario) {
                $ingresada = $diario->created_at;
            }
            $actual = $inventario->updated_at;

            if (Carbon::parse($ingresada)->format('Y-m-d') >= (Carbon::parse($actual)->format('Y-m-d'))) {



            $editarBultoEntrega = BInvInicial::findOrFail($inventario->id);
            $editarBultoEntrega->totalinicial = $request->input("totalfinal");
            $editarBultoEntrega->save();
        }
        }

    }

            $EditarInvDiario=ReBulDiario::findOrFail($request->id);
            $EditarInvDiario->onzas=$request->input("onzas");
            $EditarInvDiario->id_vitolas=$request->input('id_vitolas');
            $EditarInvDiario->id_marca=$request->input("id_marca");
            $EditarInvDiario->totalinicial=$request->input("totalinicial");
            $EditarInvDiario->pesoinicial=(($request->input("onzas")*$request->input("totalinicial"))/16);
            $EditarInvDiario->totalentrada=$request->input("totalentrada");
            $EditarInvDiario->pesoentrada=(($request->input("onzas")*$request->input("totalentrada"))/16);
            $EditarInvDiario->totalfinal=$request->input("totalfinal");
            $EditarInvDiario->pesofinal=(($request->input("onzas")*$request->input("totalfinal"))/16);
            $EditarInvDiario->totalconsumo=($request->input("totalinicial")+$request->input("totalentrada"))-$request->input("totalfinal");
            $EditarInvDiario->pesoconsumo=(($request->input("onzas")*$EditarInvDiario->totalconsumo)/16);

            $EditarInvDiario->save();
            return redirect()->route("InventarioDiario")->withExito("Se editó Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("InventarioDiario")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReBulDiario  $reBulDiario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReBulDiario $reBulDiario)
    {


        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReBulDiario  $reBulDiario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        $capaentrega = $request->input('id');
        $borrar = ReBulDiario::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("InventarioDiario")->withExito("Se borró la entrega satisfactoriamente");
    }

    public function export(Request $request)
    {

        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new InventarioDiarioBultosExports($fecha))->download('Inventario Diario de Entrega Bultos'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new InventarioDiarioBultosExports($fecha))->download('Inventario Diario De Entrega Bultos '.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new InventarioDiarioBultosExports($fecha))->download('Inventario Diario de Entrega Bultos'.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
