<?php

namespace App\Http\Controllers;

use App\Trabalho;
use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrabalhosController extends Controller
{

    public function __construct(){
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    public function index(){
        $trabalhos = Trabalho::with('empresa')->get();
        return response()->json($trabalhos);
    }

    public function show($id){
        $trabalhos = Trabalho::with('empresa')->find($id);
        //verificando se o registro é NULL
        if(!$trabalhos){
            return response()->json(['message', 'Dados não encontrados', 404]);
        }

        return response()->json($trabalhos);
    }

    public function store(Request $request){
        $dados = $request->all();
        
        $validador = Validator::make($dados, [
            'titulo' => 'requeired|max:255',
            'descricao' => 'required',
            'local' => 'required',
            'remoto' => 'in:sim,no',
            'type' =>  'integer',
        ]);
            
        if($validador->fails()){
            return response()->json([
                'message'   => 'Validação Falhou',
                'errors'    => $validador->errors()->all()
            ], 422);
        }

        $trabalhos = new Trabalho();
        $trabalhos->fill($dados);
        $trabalhos->empresa_id = \Auth::user()->id;
        $trabalhos->save();

        return response()->json($trabalhos, 201);
    }

    public function update(Request $request, $id){
        $trabalho = Trabalho::find($id);

        if(!$trabalho){
            return response()->json(['message', 'Dados não encontrados'], 404);
        }

        
        if(\Auth::user()->id != $trabalho->empresas_id) {
            return response()->json([
                'message'   => 'Você não tem permissão de mudar',
            ], 401);
        }

        $validador = Validator::make($data, [
            'titulo' => 'max:255',
            'remoto' => 'in:sim,NAO',
            'tipo' => 'integer',
        ]);

        if($validador->fails()) {
            return response()->json([
                'message'   => 'Validação Falhou',
                'errors'    => $validador->errors()->all()
            ], 422);
        }


        $trabalho->fill($request->all());
        $trabalho->save();

        return response()->json($trabalho);
    
        /** Retorno padrão do Laravel para endpoint PUT
            public function update(Request $request, $id){
                try {
                    $job = Job::findOrFail($id);

                    $job->fill($request->all());
                    $job->save();

                    return response()->json($job);
                } 
                catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    response()->json($e);
                }
            }
         * 
         */
    }

    public function destroy($id){
        $trabalho = Trabalho::find($id);

        if(!$trabalho){
            return response()->json(['message', 'Dados não encontrados'], 404);
        }

        if(\Auth::user()->id != $trabalho->empresa_id) {
            return response()->json([
                'message'   => 'Você não tem permissão de mudar',
            ], 401);
        }

        $trabalho->delete();
    }
}
