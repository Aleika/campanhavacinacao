<?php

namespace App\Http\Controllers;

use App\Models\PontoVacinacao;
use App\Models\Municipio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;
use App\Http\Resources\PontoVacinacaoResource;
use App\Http\Resources\PontoVacinacaoCollection;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Agendamento;

class PontoVacinacaoController extends ApiController
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
         if($this->user->CO_PERFIL == 1 || $this->user->CO_PERFIL == 2){
            
            if ($request->filled('municipio')) {
                $query = Municipio::where('CO_SEQ_MUNICIPIO', $request->municipio)->first();
                $pontos = PontoVacinacao::where('NO_CIDADE',    $query->NO_MU )->get();

            }else{
                if($request->filled('nome')){
                    $pontos = PontoVacinacao::where('NO_NOME', 'ILIKE', '%' . $request->nome . '%')
                    ->orderBy('NO_NOME')
                    ->paginate(10);
                }else{
                    $pontos = PontoVacinacao::orderBy('NO_NOME')->paginate(10);
                }
            }
            return PontoVacinacaoResource::collection($pontos);

        }else{
            return $this->responseUnauthorized();
        } 

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
            'nome' => 'required|string|max:255',
            'logradouro' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 409);
        } 

        if($this->user->CO_PERFIL == 1){
            DB::beginTransaction();
            try{
                $pontoVacinacao = new PontoVacinacao([
                    'NO_NOME' => $request->nome,
                    'NO_LOGRADOURO' => $request->logradouro,
                    'NO_BAIRRO' => $request->bairro,
                    'NO_CIDADE' => $request->cidade,
                ]);

                $pontoVacinacao->save();

                $message = 'Ponto de vacinação criado com sucesso.';
                $resource = $pontoVacinacao;

                DB::commit();
                return $this->responseResourceCreated($message, $resource);

            }catch(\Throwable $th){
                DB::rollBack();
                return $this->responseServerError($th->getMessage());
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
            $pontoVacinacao = PontoVacinacao::where('CO_SEQ_PONTO_VACINACAO', $id)->get();

            if(isset($pontoVacinacao)){
                return PontoVacinacaoResource::collection($pontoVacinacao);
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
        if($this->user->CO_PERFIL == 1){
            $pontoVacinacao = PontoVacinacao::findOrFail($id);

            if(isset($pontoVacinacao)){
                DB::beginTransaction();
                try{
                    $pontoVacinacao->NO_NOME = $request->nome;
                    $pontoVacinacao->NO_LOGRADOURO = $request->logradouro;
                    $pontoVacinacao->NO_BAIRRO = $request->bairro;
                    $pontoVacinacao->NO_CIDADE =  $request->cidade;
                    
                    $pontoVacinacao->save(); 
    
                    $message = 'Ponto de vacinação atualizado com sucesso.';
                    $resource = $pontoVacinacao;

                    DB::commit();

                    return $this->responseResourceUpdated($message, $resource);
    
                }catch(\Throwable $th){
                    DB::rollBack();
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
        if($this->user->CO_PERFIL == 1){
            $pontoVacinacao = PontoVacinacao::findOrFail($id);

            $possuiRegistroAgendamento = Agendamento::where('CO_PONTO_VACINACAO', $pontoVacinacao->CO_SEQ_PONTO_VACINACAO)->count();
            
            if($possuiRegistroAgendamento > 0){
                return response()->json([
                    'status' => 500,
                    'message'   => 'Não é possível remover o ponto de vacinação, pois há agendamentos cadastrados para este ponto.',
                ], 500);
            }

            if(isset($pontoVacinacao)){
                DB::beginTransaction();
                try{
                    $pontoVacinacao->delete();
    
                    $message = 'Ponto de vacinação removido com sucesso.';

                    DB::commit();
                    return $this->responseResourceDeleted($message);
    
                }catch(\Throwable $th){
                    DB::rollBack();
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
}
