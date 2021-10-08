<?php

namespace App\Http\Resources;

use App\Models\PontoVacinacao;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\PontoVacinacaoResource;

class PontoVacinacaoCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (PontoVacinacao $pontoVacinacao) {
            return (new PontoVacinacaoResource($pontoVacinacao));
        });

        return parent::toArray($request);
    }
}
