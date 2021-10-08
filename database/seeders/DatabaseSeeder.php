<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MunicipioSeed::class);
        $this->call(PerfilSeed::class);
        $this->call(UsuarioSeed::class);
        $this->call(GrupoAtendimentoSeed::class);
        $this->call(PontoVacinacaoSeed::class);
        $this->call(StatusAgendamentoSeed::class);
        $this->call(HorarioSeed::class);
        $this->call(AgendamentoSeed::class);
    }
}
