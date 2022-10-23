<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jogador;
use App\Funcoes\GeraFigurinha;

class GeraTodasFigurinhas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'figurinhas:gerar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar as Figurinhas';

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
        echo 'Inicio do Processamento'.PHP_EOL;
                
        $jogadores = Jogador::where('id','>',0)
                     ->with('selecao')
                     ->get();
        foreach($jogadores as $jogador){
            echo 'Gerando figurinha para '.$jogador->ds_nome.' de '.$jogador->selecao->ds_nome.' '.PHP_EOL;
            $gerador = new GeraFigurinha($jogador->id);
            $gerador->gerar();
            echo 'Gerado OK'.PHP_EOL;
        }
    }
}
