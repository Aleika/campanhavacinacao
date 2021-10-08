<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perfil;

class PerfilSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['NO_DESCRICAO' => 'Administrador'],
            ['NO_DESCRICAO' => 'Cidadão']
        ];
        
        Perfil::insert($data);
    }
}
