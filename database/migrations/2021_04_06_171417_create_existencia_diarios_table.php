<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExistenciaDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('existencia_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_semillas")->references("id")->on("semillas");
            $table->foreignId("id_tamano")->references("id")->on("tamanos");
            $table->foreignId("id_calidad")->references("id")->on("calidads");
            $table->integer("totalinicial")->nullable();
            $table->decimal("pesoinicial",50,2)->nullable();
            $table->integer("totalentrada")->nullable();
            $table->decimal("pesoentrada",50,2)->nullable();
            $table->integer("totalfinal")->nullable();
            $table->decimal("pesofinal",50,2)->nullable();
            $table->integer("totalconsumo")->nullable();
            $table->decimal("pesoconsumo",50,2)->nullable();
            $table->decimal("onzasI")->nullable();
            $table->decimal("onzasE")->nullable();
            $table->decimal("onzasF")->nullable();
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
        Schema::dropIfExists('existencia_diarios');
    }
}
