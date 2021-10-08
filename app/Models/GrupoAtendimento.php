<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoAtendimento extends Model
{
    protected $table = 'TB_GRUPO_ATENDIMENTO';
    protected $primaryKey = 'CO_SEQ_GRUPO_ATENDIMENTO';

    protected $fillable = ['NO_NOME', 'NO_IDADE_MINIMA'];

    const CREATED_AT = 'DT_CREATED_AT';
    const UPDATED_AT = 'DT_UPDATED_AT';
}
