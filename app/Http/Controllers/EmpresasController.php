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
}
