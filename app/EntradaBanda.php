<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntradaBanda extends Model
{
    protected $fillable = [
        'id_semilla', 'id_tamano', 'variedad', 'procedencia', 'total', 'origen',
    ];
}
