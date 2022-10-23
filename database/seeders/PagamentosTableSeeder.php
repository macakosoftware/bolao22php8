<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pagamentos')->insert([
            'id' => 1,
            'ds_pagamento' => 'Pendente de Pagamento'
        ]);
        DB::table('pagamentos')->insert([
            'id' => 2,
            'ds_pagamento' => 'Pago'
        ]);
    }
}
