<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReBulDiario extends Model
{
    //
    protected $fillable = ["id_vitolas","id_marca","onzas","totalinicial","pesoinicial","totalentrada","pesoentrada"
        ,"totalfinal","pesofinal","totalconsumo","pesoconsumo"];
}
