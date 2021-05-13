<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumoBandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumo_bandas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_semillas")->references("id")->on("semillas");
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_tamano")->references("id")->on("tamanos");
            $table->foreignId("id_vitolas")->references("id")->on("vitolas");
            $table->String("variedad")->nullable();
            $table->String("procedencia")->nullable();
            $table->decimal("onzas",50,2)->nullable();
            $table->integer("total")->nullable();
            $table->decimal("libras",50,2)->nullable();

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
        Schema::dropIfExists('consumo_bandas');
    }
}
