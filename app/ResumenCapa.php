<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumenCapa extends Model
{

    protected $fillable = ["id_semilla","totalprimera","pesoinicial","totalsegunda","pesoentrada","totaltercera","pesofinal"
        ,"totalcuarta","pesocuarta","totalconsumo","pesoconsumo"];
    //
}
