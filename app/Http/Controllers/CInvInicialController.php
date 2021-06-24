<?php

namespace App\Http\Controllers;

use App\BInvInicial;
use App\Calidad;
use App\CInvInicial;
use App\Marca;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CInvInicialController extends Controller
{

    public function index(Request $request)
    {

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
            ->orderBy("nombre_semillas")
            ->orderBy("nombre_calidads")->paginate(1000);
        $semilla = Semilla::all();
        $calidad = Calidad::all();
        $tamano = Tamano::all();

        return view("InventarioInicial.Cinicial")
            ->withNoPagina(1)
            ->withCinicial($inve)
            ->withSemilla($semilla)
            ->withTamano($tamano)
            ->withCalidad($calidad);
    }


    public function destroy(Request $request)
    {


        $capaentrega = $request->input('id');
        $borrar = CInvInicial::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("InventarioInicialCapa")->withExito("Se borró la entrega satisfactoriamente");
        //
        //
    }
    //
}
