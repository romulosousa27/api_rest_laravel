<?php

namespace App\Http\Controllers;

use App\Trabalho;
use App\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrabalhosController extends Controller
{
    public function index(){
        $trabalhos = Trabalho::with('empresa')->get();
        return response()->json($trabalhos);
    }

    public function show($id){
        $trabalho = Trabalho::with('empresa')->find($id);
        //verificando se o registro é NULL
        if(!$trabalho){
            return response()->json(['message', 'Dados não encontrados', 404]);
        }

        return response()->json($trabalho);
    }
}
