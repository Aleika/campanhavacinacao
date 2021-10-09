<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Http\Resources\MunicipioResource;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class MunicipioController extends ApiController
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

        if($this->user->CO_PERFIL == 2 || $this->user->CO_PERFIL == 1){ 
            $query = Municipio::where('CO_UF', 24)->get();
           
         }else{
            return $this->responseUnauthorized();
        } 

        return MunicipioResource::collection($query);
    }
}
