<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formas_pagamentos')->insert([
            'id' => 1,
            'ds_nome' => 'Dinheiro',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);        
        DB::table('formas_pagamentos')->insert([
            'id' => 2,
            'ds_nome' => 'Transferência Bancária',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('formas_pagamentos')->insert([
            'id' => 3,
            'ds_nome' => 'PIX',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
