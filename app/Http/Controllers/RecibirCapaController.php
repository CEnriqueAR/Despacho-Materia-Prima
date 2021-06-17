<?php

namespace App\Http\Controllers;

use App\Calidad;
use App\CInvInicial;
use App\Exports\RecepcionCapaExport;
use App\RecibirCapa;
use App\Semilla;
use App\Tamano;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Int_;
use Ramsey\Uuid\Type\Integer;


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

          $fecha = $request->get("fecha");

            if ($fecha == null)
                $fecha = Carbon::now()->format('Y-m-d');
            else{
                $fecha = $request->get("fecha");

            }
            $recibirCapa=DB::table("recibir_capas")
                ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                ->leftJoin("tamanos","recibir_capas.id_tamano","=","tamanos.id")
                ->leftJoin("calidads","recibir_capas.id_calidad","=","calidads.id")

                ->select("recibir_capas.id","tamanos.name AS nombre_tamano",
                    "recibir_capas.id_tamano",
                    "recibir_capas.id_calidad","calidads.name as nombre_calidad",
                    "recibir_capas.id_semillas","semillas.name as nombre_semillas","recibir_capas.total")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("recibir_capas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->orderBy("nombre_semillas")
                ->paginate(1000);
           $tamano= Tamano::all();
            $semillas = Semilla::all();
            $calidad = Calidad::all();

            $entregaCapass=DB::table("recibir_capas")
                ->leftJoin("semillas","recibir_capas.id_semillas","=","semillas.id")
                ->leftJoin("calidads","recibir_capas.id_calidad","=","calidads.id")
                ->selectRaw("SUM(total) as total_capa")
                ->where("semillas.name","Like","%".$query."%")
                ->whereDate("recibir_capas.created_at","=" ,Carbon::parse($fecha)->format('Y-m-d'))
                ->get();

            return view("RecepcionCapa.CapaRecepcion")
                ->withNoPagina(1)
                ->withRecibirCapa($recibirCapa)
                ->withTamano($tamano)
                ->withTotal($entregaCapass)
               ->withSemillas($semillas)
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
    public function storeRecepcionCapa(Request $request){

        $inve  =  DB::table('c_inv_inicials')
            ->leftJoin("semillas","c_inv_inicials.id_semilla","=","semillas.id")
            ->leftJoin("vitolas","c_inv_inicials.id_calidad","=","vitolas.id")
            ->leftJoin("tamanos","c_inv_inicials.id_tamano","=","tamanos.id")

            ->select(
                "c_inv_inicials.id")
            ->where("c_inv_inicials.id_semilla","=",$request->input("id_semillas"))
            ->where("c_inv_inicials.id_calidad","=",$request->input("id_calidad"))
            ->where("c_inv_inicials.id_tamano","=",$request->input("id_tamano"))->get();
        if($inve->count()>0){
        }else{
            $nuevoConsumo = new CInvInicial();
            $nuevoConsumo->id_semilla=$request->input('id_semillas');
            $nuevoConsumo->id_calidad=$request->input('id_calidad');
            $nuevoConsumo->id_tamano=$request->input("id_tamano");
            $nuevoConsumo->totalinicial= '0';
            $nuevoConsumo->save();
        }
        $fechaa =$request->input('fecha');
        if ($fechaa == null)
            $fechaa = Carbon::now()->format('Y-m-d');
        else{
            $fechaa = $request->get("fecha");

        }
        $nuevoCapaEntra = new RecibirCapa();

        $nuevoCapaEntra->id_tamano=$request->input('id_tamano');
        $nuevoCapaEntra->id_semillas=$request->input("id_semillas");
        $nuevoCapaEntra->id_calidad=$request->input("id_calidad");
        $nuevoCapaEntra->created_at=$fechaa;
        $nuevoCapaEntra->total=$request->input('total');


        $nuevoCapaEntra->save();

        return redirect()->route("RecepcionCapa")->withExito("Se creó la entrada Correctamente ");

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
    public function editarRecepcionCapa( Request $request)
    {
        try{
            $this->validate($request, [
                'id_tamano'=>'required|integer',
                'id_semillas'=>'required|integer',
                'id_calidad'=>'required|integer',
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
            $editarCapaRecibida->id_tamano=$request->input('id_tamano');
            $editarCapaRecibida->id_semillas=$request->input("id_semillas");
            $editarCapaRecibida->id_calidad=$request->input("id_calidad");

            $editarCapaRecibida->total=$request->input('total');


            $editarCapaRecibida->save();
            return redirect()->route("RecepcionCapa")->withExito("Se editó Correctamente");

        }catch (ValidationException $exception){
            return redirect()->route("RecepcionCapa")->with('errores','errores')->with('id_capa_entregas',$request->input("id"))->withErrors($exception->errors());
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
    public function borrarRecepcionCapa(Request $request)
    {
        $capaentrega = $request->input('id');
        $borrar = RecibirCapa::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("RecepcionCapa")->withExito("Se borró la entrega satisfactoriamente");
    }

    public function export(Request $request)
    {

        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
            return (new RecepcionCapaExport($fecha))->download('Listado de Capa Recibida'.$fecha.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }

    public function exportpdf(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new RecepcionCapaExport($fecha))->download('Listado de Capa Recibida'.$fecha.'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);

    }
    public function exportcvs(Request $request)
    {
        $fecha = $request->get("fecha1");

        if ($fecha = null)
            $fecha = Carbon::now()->format('Y-m-d');
        else {
            $fecha = Carbon::parse(  $request->get("fecha1"))->format('Y-m-d');

        }
        return (new RecepcionCapaExport($fecha))->download('Listado de Capa Recibida'.$fecha.'.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    public function Suma200(Request $request){


        $capaentrega = $request->get('id');

        DB::table('recibir_capas')->where("recibir_capas.id","=",$capaentrega)->increment('total', 200);

        return redirect()->route("RecepcionCapa")->withExito("Se editó Correctamente");

    }
    public function Suma50(Request $request){


        $capaentrega = $request->get('id');

        DB::table('recibir_capas')->where("recibir_capas.id","=",$capaentrega)->increment('total', 50);

        return redirect()->route("RecepcionCapa")->withExito("Se editó Correctamente");

    }
    public function Sumas(Request $request){

  $incremeto =  $request->get('suma');
        $capaentrega = $request->get('id');

        DB::table('recibir_capas')->where("recibir_capas.id","=",$capaentrega)
            ->increment('total', $incremeto);

        return redirect()->route("RecepcionCapa")->withExito("Se editó Correctamente");

    }
}
