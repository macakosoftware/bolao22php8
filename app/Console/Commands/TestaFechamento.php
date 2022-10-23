<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Funcoes\CalculaRanking;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailCertificadoRanking;
use App\Models\TipoRanking;

class TestaFechamento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fechamento:testar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa Fechamento de Ranking';

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
        $tp_ranking = 1;
        
        $tipo = TipoRanking::where('id',$tp_ranking)->first();
        
        $calculo = new CalculaRanking($tp_ranking);
        $calculo->recuperaPrimeiro();
                
        
        Mail::to($calculo->usuario_campeao)->send(new EmailCertificadoRanking($tipo, $calculo->usuario_campeao));
        
        /*
        $trofeu = new GeraBadge($tp_ranking);
        $trofeu->gerar();
        */
        
        //Mail::to($user)->send(new EmailFechamentoRanking($tipo));
    }
}
