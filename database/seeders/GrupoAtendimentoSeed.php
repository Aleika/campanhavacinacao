<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrupoAtendimento;
use Illuminate\Support\Facades\DB;

class GrupoAtendimentoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
        ['NO_NOME' => 'Maiores de 18', 'NO_IDADE_MINIMA' => 18],
        ['NO_NOME' => 'Maiores de 20', 'NO_IDADE_MINIMA' => 20],
        ['NO_NOME' => 'Maiores de 30', 'NO_IDADE_MINIMA' => 30],
        ['NO_NOME' => 'Maiores de 40', 'NO_IDADE_MINIMA' => 40],
        ['NO_NOME' => 'Maiores de 50', 'NO_IDADE_MINIMA' => 50],
        ['NO_NOME' => 'Maiores de 60', 'NO_IDADE_MINIMA' => 60],

    ];

    GrupoAtendimento::insert($data);
    }
}
