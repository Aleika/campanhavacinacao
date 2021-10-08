<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function dataToChart(Request $request){
        $lastWeek = date('Y-m-d', strtotime('-7 days'));
        $today = date('Y-m-d', strtotime(now()));
        
        $query = Agendamento::where('DT_CREATED_AT', '>=', $lastWeek)
                ->where('DT_CREATED_AT', '<=', $today)
                ->where('CO_STATUS_AGENDAMENTO', 1)
                ->selectRaw('count(*) AS total, "DT_CREATED_AT" AS data_agendamento')
                ->groupBy("DT_CREATED_AT")
                ->orderBy("DT_CREATED_AT");

        if ($request->filled('pontoVacinacao')) {
            $query
            ->join('TB_PONTO_VACINACAO', 'CO_SEQ_PONTO_VACINACAO', '=', 'CO_PONTO_VACINACAO')
            ->where('NO_CIDADE', 'ILIKE', '%' . $request->pontoVacinacao . '%');
        }
        
        $agendamentos = $query->take(7)->get();

        foreach($agendamentos as $agendamento){
            $agendamento['data_agendamento'] = date("d/m/Y", strtotime($agendamento['data_agendamento']));
        }

        $agendamentos;

        return response()->json($agendamentos);
    }

    public function dataToChartCidade(Request $request){

        $query =          ' SELECT count("CO_SEQ_AGENDAMENTO") AS total, ponto."NO_CIDADE" AS cidade';
        $query = $query . ' FROM public."TB_AGENDAMENTO" AS agend ';
        $query = $query . ' JOIN public."TB_PONTO_VACINACAO" AS ponto ON ponto."CO_SEQ_PONTO_VACINACAO" = agend."CO_PONTO_VACINACAO" ';
        $query = $query .  'GROUP BY 2';
        $query = $query .  'ORDER BY 2 LIMIT 7;';

        $agendamentos = DB::select( DB::raw($query));
        return response()->json($agendamentos);
    }
}
