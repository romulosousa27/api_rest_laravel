<?php

use Illuminate\Database\Seeder;
use App\Empresa;

class EmpresasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::create([
            'nome' => str_random(10),
            'email' => str_random(10). '@gmail.com',
            'senha' => bcrypt('secret'),
            'website' => str_random(10). '.com.br',
            'logo'  =>  str_random(10),
        ]);
    }
}
