<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibirCapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibir_capas', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_tamano")->references("id")->on("tamanos");
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
        Schema::dropIfExists('recibir_capas');
    }
}
