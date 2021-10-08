<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAgendamento extends Model
{
    protected $table = 'TB_STATUS_AGENDAMENTO';

    protected $fillable = ['NO_DESCRICAO'];

    const CREATED_AT = 'DT_CREATED_AT';
    const UPDATED_AT = 'DT_UPDATED_AT';
}
