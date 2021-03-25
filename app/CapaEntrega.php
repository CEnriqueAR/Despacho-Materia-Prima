<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CapaEntrega extends Model
{
    protected $fillable=["id_empleado","id_marca","id_vitolas","id_semilla","id_calidad","total",];

}
