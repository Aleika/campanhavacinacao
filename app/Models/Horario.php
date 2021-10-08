<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'TB_HORARIO';

    protected $fillable = ['NO_DESCRICAO', 'CO_STATUS'];

    const CREATED_AT = 'DT_CREATED_AT';
    const UPDATED_AT = 'DT_UPDATED_AT';
}
