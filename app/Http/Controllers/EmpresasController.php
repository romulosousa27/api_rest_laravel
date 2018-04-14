<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class EmpresasController extends Controller
{
    public function index(){
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    public function show($id){
        $empresa = Empresa::find($id);
        //verificando se o registro é NULL
        if(!$empresa){
            return response()->json(['message', 'Dados não encontrados'], 404);
        }

        return response()->json($empresa);
    }
}
