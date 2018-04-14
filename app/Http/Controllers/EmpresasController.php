<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class EmpresasController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
        $empresas = new Empresa();
        $empresas->fill($request->all());
        $empresas->save();

        return response()->json($empresas, 201);
    }

    public function update(Request $request, $id){
        $empresas = Empresa::find($id);

        if(!$empresas){
            return response()->json(['message', 'Dados não encontrados', 404]);
        }

        $empresas->fill($request->all());
        $empresas->save();

        return response()->json($empresas);
    }

    public function destroy($id){
        $empresas = Empresa::find($id);

        if(!$empresas){
            return response()->json(['Dados não encontrados'], 404);
        }

        $empresas->delete();
    }
}
