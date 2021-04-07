<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExistenciaDiario extends Model
{

    protected $fillable = ["id_semillas","id_tamano","id_calidad","totalinicial","pesoinicial","totalentrada","pesoentrada"
        ,"totalfinal","pesofinal","totalconsumo","pesoconsumo"];
    //
}
