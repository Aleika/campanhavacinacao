<?php

namespace App\Http\Resources;

use App\Models\Municipio;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\MunicipiooResource;

class MunicipioCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Municipio $municipio) {
            return (new MunicipioResource($municipio));
        });

        return parent::toArray($request);
    }
}
