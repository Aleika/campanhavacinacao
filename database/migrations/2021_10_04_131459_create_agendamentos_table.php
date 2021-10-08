<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_AGENDAMENTO', function (Blueprint $table) {
            $table->bigIncrements('CO_SEQ_AGENDAMENTO');
            $table->unsignedBigInteger('CO_USUARIO');
            $table->date('DT_AGENDADO');
            $table->unsignedBigInteger('CO_HORARIO');
            $table->unsignedBigInteger('CO_PONTO_VACINACAO');
            $table->unsignedBigInteger('CO_GRUPO_ATENDIMENTO');
            $table->unsignedBigInteger('CO_STATUS_AGENDAMENTO');

            $table->foreign('CO_USUARIO')->references('CO_SEQ_USUARIO')->on('TB_USUARIO');
            $table->foreign('CO_PONTO_VACINACAO')->references('CO_SEQ_PONTO_VACINACAO')->on('TB_PONTO_VACINACAO');
            $table->foreign('CO_GRUPO_ATENDIMENTO')->references('CO_SEQ_GRUPO_ATENDIMENTO')->on('TB_GRUPO_ATENDIMENTO');
            $table->foreign('CO_STATUS_AGENDAMENTO')->references('CO_SEQ_STATUS_AGENDAMENTO')->on('TB_STATUS_AGENDAMENTO');
            $table->foreign('CO_HORARIO')->references('CO_SEQ_HORARIO')->on('TB_HORARIO');

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
        Schema::dropIfExists('TB_AGENDAMENTO');
    }
}
