<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePontoVacinacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_PONTO_VACINACAO', function (Blueprint $table) {
            $table->bigIncrements('CO_SEQ_PONTO_VACINACAO');
            $table->string('NO_NOME')->nullable();
            $table->string('NO_LOGRADOURO')->nullable();
            $table->string('NO_CIDADE')->nullable();
            $table->string('NO_BAIRRO')->nullable();

            #$table->foreign('CO_MUNICIPIO')->references('CO_IBGE')->on('TB_MUNICIPIO');

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
        Schema::dropIfExists('TB_PONTO_VACINACAO');
    }
}
