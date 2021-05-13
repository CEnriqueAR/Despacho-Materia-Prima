<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaBandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_bandas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_semilla")->references("id")->on("semillas");
            $table->foreignId("id_tamano")->references("id")->on("tamanos");
            $table->String("variedad")->nullable();
            $table->String("procedencia")->nullable();
            $table->integer("total")->nullable();
            $table->String("origen")->nullable();
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
        Schema::dropIfExists('entrada_bandas');
    }
}
