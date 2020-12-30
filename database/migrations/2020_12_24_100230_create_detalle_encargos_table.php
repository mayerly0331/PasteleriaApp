<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEncargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_encargos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->integer('id_encargo')->unsigned();
            $table->integer('id_producto')->unsigned();
            $table->timestamps();


            $table->foreign('id_encargo')->references('id')->on('encargos');
            $table->foreign('id_producto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_encargos');
    }
}
