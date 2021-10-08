<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResouce;

class GrupoAtendimentoResource extends ApiResource
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
            'id' => $this->CO_SEQ_GRUPO_ATENDIMENTO,
            'nome' => $this->NO_NOME,
            'idadeMinima' => $this->NO_IDADE_MINIMA
        ];
    }
}
