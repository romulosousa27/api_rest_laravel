<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use Illuminate\Validation\Validator;

class EmpresasController extends Controller
{

    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['index', 'show', 'store']]);
    }

    public function index(){
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    public function show($id){
        $$empresas = Empresa::find($id);
        //verificando se o registro é NULL
        if(!$$empresas){
            return response()->json(['message', 'Dados não encontrados'], 404);
        }

        return response()->json($empresas);
    }

    public function store(Request $request){
        $dados = $request->all();

        //validando dos dados
        $validador = Validator::make($dados, [
            'name' => 'required|max 100',
            'email' => 'required|email|unique:empresas',
            'senha' => 'required',
        ]);

        //testando se a validação foi realizada com sucesso.
        if($validador->fails()){
            return response()->json([
                'message'   => 'Validação falhou',
                'errors'    => $validador->errors()->all()
            ], 422);
        }

        $empresas = new Empresa();
        $empresas->fill($dados);
        $senha = $request->only('senha')['senha'];
        $empresas->senha = Hash::make($senha);
        $empresas->save();

        return response()->json($empresas, 201);
    }

    public function update(Request $request, $id){
        $empresa = Empresa::find($id);
        $dados = $request->all();

        //verifica se a empresa existe
        if(!$empresa){
            return response()->json(['message', 'Empresa não encontrada', 404]);
        }

        //remove o email da variavel $dados se não houver uma mudança.
        if(array_key_exists('email', $dados) && $empresa->email == $dados['email']){
            unset($dados['email']); //unset destroi ela.
        }

        //validando
        $validador = Validator::make($dados, [
            'nome' => 'max:100',
            'email' => 'email|unique:empresas',
        ]);

        //verificando
        if($validador->fails()) {
            return response()->json([
                'message'   => 'Validação Falhou',
                'errors'    => $validador->errors()->all()
            ], 422);
        }


        $empresa->fill($request->all());
        //verifica se existe uma nova senha no request
        if(array_key_exists('senha', $dados)){
            $empresa->senha = Hash::make($dados['senha']);
        }
        $empresa->save();

        return response()->json($empresa);
    }

    public function destroy($id){
        $empresa = Empresa::find($id);

        if(!$empresa){
            return response()->json(['Dados não encontrados'], 404);
        }

        if(\Auth::user()->id != $empresa->id){
            return response()->json([
                'message' => 'Você não tem permissão para deletar isso'
            ], 401);
        }

        return response()->json($empresa->delete(), 204);
    }
}
