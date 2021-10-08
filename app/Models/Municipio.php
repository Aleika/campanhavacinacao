<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'TB_MUNICIPIO';
    protected $primaryKey = 'CO_SEQ_MUNICIPIO';
    protected $fillable = [ 'CO_IBGE', 'NO_MU', 'CO_UF'];

    const CREATED_AT = 'DT_CREATED_AT';
    const UPDATED_AT = 'DT_UPDATED_AT';
}
