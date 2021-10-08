<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_USUARIO', function (Blueprint $table) {
            $table->bigIncrements('CO_SEQ_USUARIO');
            $table->string('NO_NOME');
            $table->string('NO_EMAIL')->unique();
            $table->date('DT_NASCIMENTO')->nullable();
            $table->string('NO_SENHA')->nullable();
            $table->unsignedInteger('CO_PERFIL');
            $table->boolean('CO_STATUS')->default(true);
            $table->timestamp('DT_CREATED_AT')->nullable();
            $table->timestamp('DT_UPDATED_AT')->nullable();

            $table->foreign('CO_PERFIL')->references('CO_SEQ_PERFIL')->on('TB_PERFIL');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TB_USUARIO');
    }
}
