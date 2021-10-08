<?php

namespace App\Http\Controllers;

use App\Models\GrupoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;
use App\Http\Resources\GrupoAtendimentoResource;
use App\Http\Resources\GrupoAtendimentoCollection;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Agendamento;

class GrupoAtendimentoController extends ApiController
{
    protected $user;
 
    public function __construct()
    {
        
        $this->user = JWTAuth::parseToken()->authenticate();
        return response()->json($this->user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($this->user->CO_PERFIL == 1 || $this->user->CO_PERFIL == 2){ 
            $grupoAtendimento = GrupoAtendimento::orderBy('NO_IDADE_MINIMA');
            
            if($request->filled('nome')){
                $grupoAtendimento = GrupoAtendimento::where('NO_NOME', 'ILIKE', '%' . $request->nome . '%')
                ->orderBy('NO_NOME')
                ->paginate(10);
            }else{
                $grupoAtendimento = $grupoAtendimento->paginate(10);
            }

            return GrupoAtendimentoResource::collection($grupoAtendimento);

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
            'idadeMinima' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 409);
        } 

        if($this->user->CO_PERFIL == 1){
            DB::beginTransaction();
            try{
                $grupoAtendimento = new GrupoAtendimento([
                    'NO_NOME' => $request->nome,
                    'NO_IDADE_MINIMA' => $request->idadeMinima,
                ]);

                $grupoAtendimento->save();

                $message = 'Grupo de atendimento criado com sucesso.';
                $resource = $grupoAtendimento;

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
            $grupoAtendimento = GrupoAtendimento::where('CO_SEQ_GRUPO_ATENDIMENTO', $id)->get();

            if(isset($grupoAtendimento)){
               return GrupoAtendimentoResource::collection($grupoAtendimento);
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
            'nome' => 'required|string|max:255',
            'idadeMinima' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 409);
        } 

        if($this->user->CO_PERFIL == 1){
            $grupoAtendimento = GrupoAtendimento::findOrFail($id);

            if(isset($grupoAtendimento)){
                DB::beginTransaction();
                try{
                    $grupoAtendimento->NO_NOME = $request->nome;
                    $grupoAtendimento->NO_IDADE_MINIMA = $request->idadeMinima;
                    
                    $grupoAtendimento->save(); 
    
                    $message = 'Grupo de atendimento atualizado com sucesso.';
                    $resource = $grupoAtendimento;

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
            $grupoAtendimento = GrupoAtendimento::findOrFail($id);

            $possuiRegistroAgendamento = Agendamento::where('CO_GRUPO_ATENDIMENTO', $grupoAtendimento->CO_SEQ_GRUPO_ATENDIMENTO)->count();
            
            if($possuiRegistroAgendamento > 0){
                return response()->json([
                    'status' => 500,
                    'message'   => 'Não é possível remover o grupo de atendimento, pois há agendamentos cadastrados para este grupo.',
                ], 500);
            }

            if(isset($grupoAtendimento)){
                DB::beginTransaction();
                try{
                    $grupoAtendimento->delete();
    
                    $message = 'Grupo de atendimento removido com sucesso.';

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

    public function gruposAtendimentoByIdade(Request $request){
        if($this->user->CO_PERFIL == 2){
            $anoAtual = date('Y');
            $anoNascimento = date('Y', strtotime($this->user->DT_NASCIMENTO));

            $idade = $anoAtual - $anoNascimento;

            $gruposAtendimento = GrupoAtendimento::where('NO_IDADE_MINIMA', '<=', $idade)
                                                ->orderBy('NO_IDADE_MINIMA')
                                                ->get(
                                                    ['CO_SEQ_GRUPO_ATENDIMENTO as id', 
                                                    'NO_NOME as nome', 
                                                    'NO_IDADE_MINIMA as idade']);

            return $gruposAtendimento;
        }else{
            return $this->responseUnauthorized();
        } 
    }
}
