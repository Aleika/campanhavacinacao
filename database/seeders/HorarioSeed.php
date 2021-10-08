<?php

namespace Database\Seeders;
use App\Models\Horario;

use Illuminate\Database\Seeder;

class HorarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['NO_DESCRICAO' => '08:00'],
            ['NO_DESCRICAO' => '08:30'],
            ['NO_DESCRICAO' => '09:00'],
            ['NO_DESCRICAO' => '09:30'],
            ['NO_DESCRICAO' => '10:00'],
            ['NO_DESCRICAO' => '10:30'],
            ['NO_DESCRICAO' => '11:00'],
            ['NO_DESCRICAO' => '11:30'],
            ['NO_DESCRICAO' => '12:00'],
            ['NO_DESCRICAO' => '14:00'],
            ['NO_DESCRICAO' => '14:30'],
            ['NO_DESCRICAO' => '15:00'],
            ['NO_DESCRICAO' => '15:30'],
            ['NO_DESCRICAO' => '16:00']

        ];
        
        Horario::insert($data);
    }
}
