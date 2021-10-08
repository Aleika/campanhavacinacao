<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResouce;

class PontoVacinacaoResource extends ApiResource
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
            'id' => $this->CO_SEQ_PONTO_VACINACAO,
            'nome' => $this->NO_NOME,
            'bairro' => $this->NO_BAIRRO,
            'cidade' => $this->NO_CIDADE,
            'logradouro' => $this->NO_LOGRADOURO
        ];
    }
}
