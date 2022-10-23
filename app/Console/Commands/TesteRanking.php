<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Funcoes\CalculaRanking;

class TesteRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:atualiza';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza Ranking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $qt_posicao = 0;
        
        $rankings = CalculaRanking::queryRanking(1);
        foreach($rankings as $ranking){
            $qt_posicao++;
            $ranking->qt_posicao = $qt_posicao;
            $ranking->save();
        }
    }
}
