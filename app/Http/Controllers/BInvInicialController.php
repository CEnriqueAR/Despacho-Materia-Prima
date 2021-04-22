<?php

namespace App\Http\Controllers;

use App\BInvInicial;
use App\Calidad;
use App\ExistenciaDiario;
use App\Marca;
use App\Semilla;
use App\Tamano;
use App\Vitola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BInvInicialController extends Controller
{

    public function index(Request $request)
    {


                              $inve = DB::table('b_inv_inicials')
                            ->leftJoin("vitolas", "b_inv_inicials.id_vitolas", "=", "vitolas.id")
                            ->leftJoin("marcas", "b_inv_inicials.id_marca", "=", "marcas.id")
                            ->select(
                            "vitolas.name as nombre_vitolas",
                            "marcas.name as nombre_marca",
                            "b_inv_inicials.id_vitolas",
                                "b_inv_inicials.id",
                            "b_inv_inicials.id_marca",
                            "b_inv_inicials.totalinicial")
                            ->orderBy("nombre_marca")->paginate(1000);
        $marca = Marca::all();
        $vitola = Vitola::all();


        return view("InventarioInicial.Binicial")
            ->withNoPagina(1)
            ->withBinicial($inve)
            ->withMarca($marca)
            ->withVitola($vitola);
    }


    public function destroy(Request $request)
    {


        $capaentrega = $request->input('id');
        $borrar = BInvInicial::findOrFail($capaentrega);

        $borrar->delete();
        return redirect()->route("InventarioInicial")->withExito("Se borró la entrega satisfactoriamente");
        //
        //
    }

}
