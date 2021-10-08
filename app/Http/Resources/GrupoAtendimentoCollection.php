<?php

namespace App\Http\Resources;

use App\Models\GrupoAtendimento;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\GrupoAtendimentoResource;

class GrupoAtendimentoCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (GrupoAtendimento $grupoAtendimento) {
            return (new GrupoAtendimentoResource($grupoAtendimento));
        });

        return parent::toArray($request);
    }
}
