<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBultosDevueltosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bultos_devueltos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_vitolas")->references("id")->on("vitolas");
            $table->integer("onzas");
            $table->integer("total");
            $table->boolean("usado");
            $table->decimal("libras",50,2);
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
        Schema::dropIfExists('bultos_devueltos');
    }
}
