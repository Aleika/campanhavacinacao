<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResouce;

class MunicipioResource extends ApiResource
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
            'id' => $this->CO_SEQ_MUNICIPIO,
            'codigo' => $this->CO_IBGE,
            'nome' => $this->NO_MU,
        ];
    }
}
