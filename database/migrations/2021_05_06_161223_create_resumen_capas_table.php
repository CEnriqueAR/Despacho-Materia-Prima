<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumenCapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumen_capas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_semilla")->references("id")->on("semillas");
            $table->integer("totalprimera")->nullable();
            $table->decimal("pesoinicial",50,2)->nullable();
            $table->integer("totalsegunda")->nullable();
            $table->decimal("pesoentrada",50,2)->nullable();
            $table->integer("totaltercera")->nullable();
            $table->decimal("pesofinal",50,2)->nullable();
            $table->integer("totalcuarta")->nullable();
            $table->decimal("pesocuarta",50,2)->nullable();
            $table->integer("totalconsumo")->nullable();
            $table->decimal("pesoconsumo",50,2)->nullable();
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
        Schema::dropIfExists('resumen_capas');
    }
}
