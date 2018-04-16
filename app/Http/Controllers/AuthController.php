<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabalho;
use App\Empresa;
use JWT\Auth;
use Hash;
use Tymon\JWTAuth\JWTAuth;
use Validator;

class AuthController extends Controller
{
 
    public function autenticacao(AuthenticateRequest $request){
        $dados = $request->only('email', 'senha');
        $empresa = Empresa::where('email', $dados['email'])->first();

        $validador = Validator::make($dados,[
            'senha' => 'required',
            'email' => 'required' 
        ]);
       
        if($validador->fails()){
            return response()->json([
                'message'   => 'Credenciais Invalidas',
                'errors'    => $validador->errors()->all()     
            ], 422);
        }

        //validação da empresa
        if(!$empresa){
            return response()->json(['error' => 'Credenciais Invalidas'], 401);
        }

        //vaidação da senha
        if(Hash::check($dados['senha'], $empresa->senha)){
            return response()->json(['error' => 'Credenciais Invalidas'], 401);
        }

        //gerando Token JWT
        $token = JWTAuth::fromUser($token);

        //Expirando o tempo 
        $Objtoken = JWTAuth::setToken($token);
        $expira = JWTAuth::decode($Objtoken->getToken())->get('exp');

        return response()->json([
            'acess_token'   => $token,
            'token_type'    =>'bearer',
            'expires_in'    =>  JWTAuth::decode()->get('exp')

        ]);

    } 
}
