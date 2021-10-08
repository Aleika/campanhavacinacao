<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiResouce;

class HorarioResource extends ApiResource
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
            'id' => $this->CO_SEQ_HORARIO,
            'descricao' => $this->NO_DESCRICAO,
        ];
    }
}
