<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encargos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('anticipo',11,2);
            $table->timestamp('fec_encargo');
            $table->date('fec_entrega');
            $table->string('estado', 20);
            $table->integer('id_cliente')->unsigned();
            $table->timestamps();
        
        $table->foreign('id_cliente')->references('id')->on('clientes'); 
        });
    }
        
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encargos');
    }
}
