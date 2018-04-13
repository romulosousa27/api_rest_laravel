<?php

use Illuminate\Database\Seeder;
use App\Trabalho;

class TrabalhosSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trabalho::create([
            'titulo' => str_random(10),
            'descricao' => str_random(100),
            'local' => 'São Paulo / SP',
            'remote' => 'nao',
            'tipo' => 3,
            'empresa_id' => 1,
        ]);
    }
}
