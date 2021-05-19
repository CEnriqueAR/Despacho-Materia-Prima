<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandaInvInicialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banda_inv_inicials', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_semilla")->references("id")->on("semillas");
            $table->foreignId("id_tamano")->references("id")->on("tamanos");
            $table->integer("totalinicial")->nullable();
            $table->decimal("pesoinicial",50,2)->nullable();
            $table->decimal("onzasI",50,2)->nullable();
            $table->foreignId("id_variedad")->references("id")->on("variedads")->nullable();
            $table->foreignId("id_procedencia")->references("id")->on("procedencias")->nullable();

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
        Schema::dropIfExists('banda_inv_inicials');
    }
}
