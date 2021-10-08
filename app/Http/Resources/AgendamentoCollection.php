<?php

namespace App\Http\Resources;

use App\Models\Agendamento;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\AgendamentoResource;

class AgendamentoCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Agendamento $agendamento) {
            return (new AgendamentoResource($agendamento));
        });

        return parent::toArray($request);
    }
}
