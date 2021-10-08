<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoVacinacao extends Model
{
    protected $table = 'TB_PONTO_VACINACAO';
    protected $primaryKey = 'CO_SEQ_PONTO_VACINACAO';

    protected $fillable = ['CO_CNES', 'NO_NOME', 'NO_LOGRADOURO', 'NO_CIDADE', 'NO_BAIRRO'];

    const CREATED_AT = 'DT_CREATED_AT';
    const UPDATED_AT = 'DT_UPDATED_AT';
}
