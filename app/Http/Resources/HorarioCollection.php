<?php

namespace App\Http\Resources;

use App\Models\Horario;
use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\HorarioResource;

class HorarioCollection extends ApiResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Horario $horario) {
            return (new HorarioResource($horario));
        });

        return parent::toArray($request);
    }
}
