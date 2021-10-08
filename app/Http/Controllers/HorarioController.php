<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Http\Resources\HorarioResource;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class HorarioController extends ApiController
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pontoId = 'NULL';
        $dataAgendado = 'NULL';

        if ($request->filled('pontoVacinacao')) {
            $pontoId = $request->pontoVacinacao;
        }

        if ($request->filled('dataAgendado') && $request->dataAgendado !== "''") {
            $dataAgendado = `'`. $request->dataAgendado . `'`;
        }

        if($this->user->CO_PERFIL == 2){ 

            $query =          ' SELECT horario."CO_SEQ_HORARIO", horario."NO_DESCRICAO"';
            $query = $query . ' FROM public."TB_HORARIO" as horario';
            $query = $query . ' WHERE horario."CO_SEQ_HORARIO" NOT IN';
            $query = $query .       '( WITH busca AS';
            $query = $query .           ' ( SELECT count(agend."CO_SEQ_AGENDAMENTO") AS total, hora."CO_SEQ_HORARIO" AS horaId, ';
            $query = $query .                      ' agend."CO_PONTO_VACINACAO" AS ponto, agend."DT_AGENDADO" AS dataagendado ';
            $query = $query .              ' FROM public."TB_AGENDAMENTO" AS agend ' ;
            $query = $query .              ' RIGHT JOIN public."TB_HORARIO" AS hora ON hora."CO_SEQ_HORARIO" = agend."CO_HORARIO"  ' ;
            $query = $query .              ' WHERE  agend."CO_STATUS_AGENDAMENTO" = 1 ' ;
            $query = $query .              ' GROUP BY 2, 3, 4)' ;
            $query = $query .        ' SELECT busca.horaId ' ;
            $query = $query .        ' FROM busca ' ;
            $query = $query .        ' WHERE busca.total > 1 AND busca.ponto = ' . $pontoId . ' AND  busca.dataagendado = ' . $dataAgendado;
            $query = $query.         ' ORDER BY 1); ' ;

            $horariosDisponiveis = DB::select( DB::raw($query));

            return HorarioResource::collection($horariosDisponiveis);

         }else{
            return $this->responseUnauthorized();
        } 
    }

}
