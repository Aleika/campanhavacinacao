<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('TB_USUARIO')->insert([
            'NO_NOME' => 'Aleika Alves',
            'NO_EMAIL' => 'aleika.alves@lais.huol.ufrn.br',
            'CO_PERFIL' => '1',
            'CO_STATUS' => '1',
            'DT_NASCIMENTO' => Null,
            'NO_SENHA' => Hash::make('123456')
        ]);

        DB::table('TB_USUARIO')->insert([
            'NO_NOME' => 'Luiz Gustavo',
            'NO_EMAIL' => 'lglima@gmail.com',
            'CO_PERFIL' => '2',
            'CO_STATUS' => '1',
            'DT_NASCIMENTO' => '1994-02-18',
            'NO_SENHA' => Hash::make('123456')
        ]);

        DB::table('TB_USUARIO')->insert([
            'NO_NOME' => 'Larissa Alves',
            'NO_EMAIL' => 'larissa@gmail.com',
            'CO_PERFIL' => '2',
            'CO_STATUS' => '1',
            'DT_NASCIMENTO' => '1996-02-18',
            'NO_SENHA' => Hash::make('123456')
        ]);

        DB::unprepared(file_get_contents('database/scripts/sql/dump_usuario.sql'));
    }
}
