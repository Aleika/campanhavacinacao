<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Throwable;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException; 

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'senha']);

        $user = User::where('NO_EMAIL', $credentials['email'])->first();

        if(isset($user)){
            if(Hash::check($credentials['senha'], $user->NO_SENHA)){
                $token = auth()->login($user); 
            }else{
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Senha inválida, tente novamente.'
                ], 401);
            }
        }else{
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Email não encontrado.'
            ], 401);
        }

        return $this->respondWithToken($token, $user);
    }

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:TB_USUARIO,NO_EMAIL',
            'dataNascimento' => 'required|date',
            'senha' => 'required|min:8',
            'confirmarSenha' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 409);
        }

        $errors = $this->testeSenha($request->senha, $request->confirmarSenha);

        if(!empty($errors)){
            return response()->json($errors, 400);
        }

        try {
            $user = new User([   
                    'NO_NOME' => $request->nome,
                    'NO_EMAIL' => $request->email,
                    'DT_NASCIMENTO' => $request->dataNascimento,
                    'CO_PERFIL' => 2,
                ]);
            $user->NO_SENHA = Hash::make($request->senha);
            $user->save();
            
            return response()->json([
                'status' => 201,
                'message' => 'Usuário cadastrado com sucesso.',
                'id' => $user
            ], 201); 

        }catch(\Throwable $th){
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function testeSenha($senha, $confirmacaoSenha){
        $errors = [];

        if($senha !== $confirmacaoSenha){
            array_push($errors, "As senhas informadas são diferentes!");
        }

        if (strlen($senha) < 8) {
            array_push($errors, "Senha muito pequena!");
        }
    
        if (!preg_match("#[0-9]+#", $senha)) {
            array_push($errors, "Senha deve possuir pelo menos um número!");
        }
    
        if (!preg_match("@[A-Z]@", $senha)) {
            array_push($errors, "Senha deve incluir pelo menos uma letra maiúscula!");
        }

        if (!preg_match("@[a-z]@", $senha)) {
            array_push($errors, "Senha deve incluir pelo menos uma letra minúscula!");
        }
        
        if (!preg_match("@[^\w]@", $senha)) {
            array_push($errors, "Senha deve incluir pelo menos um caracter especial!");
        }  
        return $errors;
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        $usuario = [
            'nome' => $user->NO_NOME,
            'perfil' => $user->CO_PERFIL,
        ];

        return response()->json([
            'access_token' => $token,
            'message' => 'Logado com sucesso',
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $usuario
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = Auth::user();

        $retorno = [
            'nome' => $user->NO_NOME,
            'dataNascimento' => date("d/m/Y", strtotime($user->DT_NASCIMENTO )),
            'email' => $user->NO_EMAIL,
            'perfil' => $user->perfil->NO_DESCRICAO,
        ];

        return response()->json([
            'status' => 200, 
            'data' => $retorno
        ]);
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'Deslogado com sucesso.'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 409);
        } 
    }
}
