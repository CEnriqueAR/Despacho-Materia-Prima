<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBultosSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bultos_salidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_empleado")->references("id")->on("empleados");
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_vitolas")->references("id")->on("vitolas");
            $table->integer("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bultos_salidas');
    }
}
