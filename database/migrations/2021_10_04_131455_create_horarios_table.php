<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_HORARIO', function (Blueprint $table) {
            $table->increments('CO_SEQ_HORARIO');
            $table->string('NO_DESCRICAO');
            $table->boolean('CO_STATUS')->default(true);
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
        Schema::dropIfExists('TB_HORARIO');
    }
}
