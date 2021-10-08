<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_MUNICIPIO', function (Blueprint $table) {
            $table->increments('CO_SEQ_MUNICIPIO')->unique();
            $table->unsignedBigInteger('CO_IBGE')->unique();
            $table->string('NO_MU');
            $table->integer('CO_UF');
            $table->string('SG_UF');
            $table->string('NO_UF');
            $table->string('CG_LAT');
            $table->string('CG_LON');
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
        Schema::dropIfExists('TB_MUNICIPIO');
    }
}
