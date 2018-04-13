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
}
