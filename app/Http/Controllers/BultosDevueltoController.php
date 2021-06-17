<?php

namespace App\Http\Controllers;

use App\BultosDevuelto;
use App\BultosSalida;
use App\Empleado;
use App\Exports\DevolucionesBultoExport;
use App\Exports\EntregaBultoExport;
use App\Marca;
use App\ReBulDiario;
use App\Vitola;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class BultosDevueltoController extends Controller
{
    public function index(Request $request)
    {

        if ($request){
            $query = trim($request->get("search"));

            $fecha = $request->get("fecha");

            if ($fecha == null) {
                $fecha = Carbon::now()->format('l');
                if ($fecha == 'Monday') {
                    $fecha = Carbon::now()->subDays(2)->format('Y-m-d');
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
                        ->whereDate("bultos_salidas.created_at","=" ,$fecha)->get();
                    if ($bultoentrega->count()>0){
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

            $bultodevuleto=DB::table("bultos_devueltos")
                ->leftJoin("vitolas","bultos_devueltos.id_vitolas","=","vitolas.id")
                ->leftJoin("marcas","bultos_devueltos.id_marca","=","marcas.id")

                ->select("bultos_devueltos.id",
                    "vitolas.name as nombre_vitolas",
                    "bultos_devueltos.id_vitolas",
                    "bultos_devueltos.id_marca","marcas.name as nombre_marca"
                    ,"bultos_devueltos.total","bultos_devueltos.libras","bultos_devueltos.onzas")
                ->where("marcas.name","Like","%".$query."%")
                ->whereDate("bultos_devueltos.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("nombre_marca")

                //  ->whereDate("capa_entregas.created_at","=" ,Carbon::now()->format('Y-m-d'))
                ->paginate(1000);
            $vitola = Vitola::all();
            $marca = Marca::all();

            return view("BultosDevueltos.Bultosdevuelto")
                ->withNoPagina(1)
                ->withBultoDevuelto($bultodevuleto)
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
                'id_vitolas'=>'required',
                'id_marca'=>'required',
                'onzas'=>'required',
                 'total'=>'required'
            ]);

            $fechaa =$request->input('fecha');
            if ($fechaa == null)
                $fechaa = Carbon::now()->format('Y-m-d');
            else{
                $fechaa = $request->get("fecha");

            }


        $nuevoBultoEntrega = new BultosDevuelto();
        $nuevoBultoEntrega->onzas=$request->input('onzas');
        $nuevoBultoEntrega->id_vitolas=$request->input('id_vitolas');
        $nuevoBultoEntrega->id_marca=$request->input("id_marca");
        $nuevoBultoEntrega->total=$request->input("total");
        $nuevoBultoEntrega->libras=  ($request->input("total") * $request->input('onzas')/16);
        $nuevoBultoEntrega->created_at =$fechaa;
            $nuevoBultoEntrega->usado =false;


        $nuevoBultoEntrega->save();

        return redirect()->route("BultoDevuelto")->withExito("Se creó la Devolucion Correctamente ");
        }catch (ValidationException $exception){
            return redirect()->route("BultoDevuelto")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
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
                'id_vitolas'=>'required',
                'id_marca'=>'required',
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
            $editarBultoEntrega=BultosDevuelto::findOrFail($request->id);


            $editarBultoEntrega->onzas=$request->input('onzas');
            $editarBultoEntrega->id_vitolas=$request->input('id_vitolas');
            $editarBultoEntrega->id_marca=$request->input("id_marca");

            $editarBultoEntrega->libras=  ($request->input("total") * $request->input('onzas')/16);


            $inventarioDiarios=DB::table("re_bul_diarios")
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
                ->where("re_bul_diarios.id_marca","=",$request->input("id_marca"))
                ->where("re_bul_diarios.id_vitolas","=",$request->input('id_vitolas'))
                ->whereDate("re_bul_diarios.created_at","=" , $editarBultoEntrega->created_at)
                ->get();

            foreach ($inventarioDiarios as $in) {
                DB::table('re_bul_diarios')->where("re_bul_diarios.id", "=", $in->id)->increment('totalinicial', $editarBultoEntrega->total);
                DB::table('re_bul_diarios')->where("re_bul_diarios.id", "=", $in->id)->decrement('totalinicial',$request->input('total'));
                $EditarInvDiario = ReBulDiario::findOrFail($in->id);
                $EditarInvDiario->pesoinicial = (($EditarInvDiario->onzas * $EditarInvDiario->totalinicial) / 16);
                $EditarInvDiario->totalconsumo = ($EditarInvDiario->totalinicial + $EditarInvDiario->totalentrada)
                    - $EditarInvDiario->totalfinal;
                $EditarInvDiario->pesoconsumo = (($EditarInvDiario->onzas * $EditarInvDiario->totalconsumo) / 16);
                $EditarInvDiario->save();


                $editarBultoEntrega->total=$request->input('total');
                $editarBultoEntrega->save();
                return redirect()->route("BultoDevuelto")->withExito("Se editó Correctamente");
            }
        }catch (ValidationException $exception){
            return redirect()->route("BultoDevuelto")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
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
        $borrar = BultosDevuelto::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("BultoDevuelto")->withExito("Se borró la Devolucion satisfactoriamente");
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
        return (new DevolucionesBultoExport($fecha))->download('Listado Devoluciones Bultos'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new DevolucionesBultoExport($fecha))->download('Listado Devoluciones Bultos '.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new DevolucionesBultoExport($fecha))->download('Listado Devoluciones Bultos'.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
