<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusAgendamento;

class StatusAgendamentoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['NO_DESCRICAO' => 'Agendado'],
            ['NO_DESCRICAO' => 'Cancelado'],
            ['NO_DESCRICAO' => 'Vacinado'],
        ];
        
        StatusAgendamento::insert($data);
    }
}
