<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapaEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa_entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_empleado")->references("id")->on("empleados");
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_vitolas")->references("id")->on("vitolas");
            $table->foreignId("id_semilla")->references("id")->on("semillas");
            $table->integer("id_calidad")->nullable();
            $table->integer("total");
            $table->integer("manchada");
            $table->integer("picada");
            $table->integer("botada");
            $table->integer("rota");
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
        Schema::dropIfExists('capa_entregas');
    }
}
