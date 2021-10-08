<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $table = 'TB_AGENDAMENTO';
    protected $primaryKey = 'CO_SEQ_AGENDAMENTO';

    protected $fillable = ['CO_USUARIO','DT_AGENDADO', 'CO_HORARIO', 'CO_PONTO_VACINACAO', 'CO_GRUPO_ATENDIMENTO', 'CO_STATUS_AGENDAMENTO'];

    const CREATED_AT = 'DT_CREATED_AT';
    const UPDATED_AT = 'DT_UPDATED_AT';

    public function usuario(){
        return $this->hasOne(User::class, 'CO_SEQ_USUARIO', 'CO_USUARIO');
    }

    public function pontoVacinacao(){
        return $this->hasOne(PontoVacinacao::class, 'CO_SEQ_PONTO_VACINACAO', 'CO_PONTO_VACINACAO');
    }

    public function status(){
        return $this->hasOne(StatusAgendamento::class,'CO_SEQ_STATUS_AGENDAMENTO', 'CO_STATUS_AGENDAMENTO');
    }

    public function grupoAtendimento(){
        return $this->hasOne(GrupoAtendimento::class,'CO_SEQ_GRUPO_ATENDIMENTO', 'CO_GRUPO_ATENDIMENTO');
    }

    public function horario(){
        return $this->hasOne(Horario::class,'CO_SEQ_HORARIO', 'CO_HORARIO');
    }
}
