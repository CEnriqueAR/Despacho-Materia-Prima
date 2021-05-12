<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReBulDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_bul_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_vitolas")->references("id")->on("vitolas");
            $table->integer("totalinicial")->nullable();
            $table->decimal("pesoinicial",50,2)->nullable();
            $table->integer("totalentrada")->nullable();
            $table->decimal("pesoentrada",50,2)->nullable();
            $table->integer("totalfinal")->nullable();
            $table->decimal("pesofinal",50,2)->nullable();
            $table->integer("totalconsumo")->nullable();
            $table->decimal("pesoconsumo",50,2)->nullable();
            $table->decimal("onzas",50,2)->nullable();
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
        Schema::dropIfExists('re_bul_diarios');
    }
}
