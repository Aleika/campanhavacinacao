<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResouce;

class AgendamentoResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->CO_SEQ_AGENDAMENTO,
            'nome' => $this->usuario,
            'data' => $this->DT_AGENDADO,
            'grupo' => $this->grupoAtendimento,
            'sala' => "Sala 1",
            'local' => $this->pontoVacinacao,
            'hora' => $this->horario->NO_DESCRICAO,
            'status' => $this->status->NO_DESCRICAO
        ];
    }
}
