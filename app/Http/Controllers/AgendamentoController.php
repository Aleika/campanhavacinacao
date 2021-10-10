<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AgendamentoResource;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AgendamentoController extends ApiController
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
        if($this->user->CO_PERFIL == 1){
            $agendamento = Agendamento::all();
        }else{
            return $this->responseUnauthorized();
        }

        return response()->json($agendamento);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dataAgendado' => 'required|date',
            'horario' => 'required',
            'pontoVacinacao' => 'required',
            'grupoAtendimento' => 'required',
        ]); 

         if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 409);
        } 

        if($this->user->CO_PERFIL == 2){
            $agendamento = Agendamento::where('CO_USUARIO', $this->user->CO_SEQ_USUARIO)
            ->where('CO_STATUS_AGENDAMENTO', '!=', 2)
            ->get();

            if(sizeof($agendamento) === 0){
                DB::beginTransaction();
                try{
                    $anoAtual = date('Y');
                    $anoNascimento = date('Y', strtotime($this->user->DT_NASCIMENTO));

                    $idade = $anoAtual - $anoNascimento;

                    $agendamento = new Agendamento([
                        'CO_USUARIO' => $this->user->CO_SEQ_USUARIO,
                        'DT_AGENDADO' => $request->dataAgendado,
                        'NO_IDADE' => $idade,
                        'CO_HORARIO' => $request->horario,
                        'CO_PONTO_VACINACAO' => $request->pontoVacinacao,
                        'CO_GRUPO_ATENDIMENTO' => $request->grupoAtendimento,
                        'CO_STATUS_AGENDAMENTO' => 1,
                    ]);
    
                    $agendamento->save();
    
                    $message = 'Agendamento criado com sucesso.';
                    $resource = $agendamento;

                    DB::commit();
                    return $this->responseResourceCreated($message, $resource);
    
                }catch(\Throwable $th){
                    DB::rollBack();
                    return $this->responseServerError($th->getMessage());
                }
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Usuário já possui um agendamento cadastrado.',
                ], 400);
            }
        }else{
            return $this->responseUnauthorized();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        if($this->user->CO_PERFIL == 1){
            $agendamento = Agendamento::where('CO_SEQ_AGENDAMENTO', $id)
                                        ->whereIn('CO_STATUS_AGENDAMENTO', [1, 3])
                                        ->get();

            if(isset($agendamento)){
                return AgendamentoResource::collection($agendamento);
            }else{
                return response()->json([
                    'message'   => 'Record not found',
                ], 404);
            }
        }else{
            return $this->responseUnauthorized();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'dataAgendado' => 'required|date',
            'horario' => 'required',
            'pontoVacinacao' => 'required',
            'grupoAtendimento' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 409);
        } 

        if($user->CO_PERFIL == 2){
            $agendamento = Agendamento::findOrFail($id);

            if(isset($agendamento)){
                DB::beginTransaction();
                try{
                    $agendamento->DT_AGENDADO = $request->dataAgendado;
                    $agendamento->CO_HORARIO = $request->horario;
                    $agendamento->CO_PONTO_VACINACAO = $request->pontoVacinacao;
                    $agendamento->CO_GRUPO_ATENDIMENTO = $request->grupoAtendimento;
                    $agendamento->CO_STATUS_AGENDAMENTO = 1;
                    
                    $agendamento->save(); 
    
                    $message = 'Agendamento atualizado com sucesso.';
                    $resource = $agendamento;

                    DB::commit();
                    return $this->responseResourceCreated($message, $resource);
    
                }catch(\Throwable $th){

                    DB::rollback();
                    return $this->responseServerError($th->getMessage());
                }
            }else{
                return response()->json([
                    'message'  => 'Record not found',
                ], 404);
            }
        }else{
            return $this->responseUnauthorized();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($this->user->CO_PERFIL == 2){
            $agendamento = Agendamento::where(
                ['CO_USUARIO' => $this->user->CO_SEQ_USUARIO,
                'CO_SEQ_AGENDAMENTO' =>$id
                ])->first();

            if(isset($agendamento)){
                DB::beginTransaction();
                try{
                    $agendamento->CO_STATUS_AGENDAMENTO = 2;
                    $agendamento->save();

                    $message = 'Agendamento cancelado com sucesso.';
                    DB::commit();
                    return $this->responseResourceDeleted($message);
    
                }catch(\Throwable $th){
                    DB::rollback();
                    return $this->responseServerError($th->getMessage());
                }
            }else{
                return response()->json([
                    'message'  => 'Record not found',
                ], 404);
            }
        }else{
            return $this->responseUnauthorized();
        }
    }

    public function comprovante(Request $request){
 
        if($this->user->CO_PERFIL == 2){
            $agendamento = Agendamento::where('CO_USUARIO', $this->user->CO_SEQ_USUARIO)
            ->whereIn('CO_STATUS_AGENDAMENTO', [1, 3])->first();
            if(isset($agendamento)){
                $retorno  = [
                    "id" => $agendamento->CO_SEQ_AGENDAMENTO,
                    "nome" => $agendamento->usuario->NO_NOME,
                    "grupo" => $agendamento->grupoAtendimento->NO_NOME,
                    "data" => date("d/m/Y", strtotime($agendamento->DT_AGENDADO)),
                    "sala" => 'Sala 1',
                    "local" => $agendamento->pontoVacinacao,
                    "hora" => $agendamento->horario->NO_DESCRICAO,
                    "status" => $agendamento->status->NO_DESCRICAO
                ];
                return response()->json($retorno);
            }else{
                return response()->json([
                    'message'  => 'Record not found',
                ], 404);
            }
        }else{
            return $this->responseUnauthorized();
        }
    }

    public function checkAgendamento(Request $request){

        if($this->user->CO_PERFIL === 2){
            $agendamento = Agendamento::where('CO_USUARIO', $this->user->CO_SEQ_USUARIO)->first();
            if(empty($agendamento)){
                return response()->json([
                    'possuiAgendamento' => false
                    ], 200);
            }else{
                return response()->json([
                    'possuiAgendamento' => true
                    ], 200);
            }
        }else{
            return $this->responseUnauthorized();
        }
    }

}
