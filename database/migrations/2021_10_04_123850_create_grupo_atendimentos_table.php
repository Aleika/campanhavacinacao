<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_GRUPO_ATENDIMENTO', function (Blueprint $table) {
            $table->increments('CO_SEQ_GRUPO_ATENDIMENTO');
            $table->string('NO_NOME');
            $table->unsignedBigInteger('NO_IDADE_MINIMA');
            $table->timestamp('DT_CREATED_AT')->nullable();
            $table->timestamp('DT_UPDATED_AT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_GRUPO_ATENDIMENTO');
    }
}
