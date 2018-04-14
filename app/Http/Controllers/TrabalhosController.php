<?php

namespace App\Http\Controllers;

use App\Trabalho;
use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrabalhosController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
        $trabalhos = new Trabalho();
        $trabalhos->fill($request->all());
        $trabalhos->save();

        return response()->json($trabalhos, 201);
    }

    public function update(Request $request, $id){
        $trabalhos = Trabalho::find($id);

        if(!$trabalhos){
            return response()->json(['message', 'Dados não encontrados'], 404);
        }

        $trabalhos->fill($request->all());
        $trabalhos->save();

        return response()->json($trabalhos);
    
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

        $trabalho->delete();
    }
}
