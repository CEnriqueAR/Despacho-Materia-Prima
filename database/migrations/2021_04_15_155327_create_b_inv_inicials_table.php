<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBInvInicialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_inv_inicials', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_marca")->references("id")->on("marcas");
            $table->foreignId("id_vitolas")->references("id")->on("vitolas");
            $table->integer("totalinicial")->nullable();
            $table->decimal("pesoinicial",50,2)->nullable();

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
        Schema::dropIfExists('b_inv_inicials');
    }
}
