<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\TipoRanking;
use App\Funcoes\CalculaRanking;
use App\Mail\EmailCertificadoRanking;
use App\Mail\EmailCertificadoRanking2;
use App\Mail\EmailCertificadoRanking3;

class TesteEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:teste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar Email';

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
        $user = User::where('id',1)->first();
        /*
        Mail::to($user)->send(new EmailInformeRanking());
                
        $tb_jogos[] = 1;
        Mail::to($user)->send(new EmailApostasFechadas($tb_jogos));
        */
        
        //$tb_jogos[] = 54;        
        //$users = User::all();
        //Mail::to($user)->send(new EmailReciboPalpites($tb_jogos));
        
        $tipoRanking = TipoRanking::where('id',8)->first();
        
        $calculo = new CalculaRanking($tipoRanking->id);
        $calculo->recuperaPrimeiro();
                
        Mail::to($user)->send(new EmailCertificadoRanking($tipoRanking, $calculo->usuario_campeao));
        
        if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_GERAL){
            Mail::to($user)->send(new EmailCertificadoRanking2($tipoRanking, $calculo->usuario_2));
            
            Mail::to($user)->send(new EmailCertificadoRanking3($tipoRanking, $calculo->usuario_3));
        }
    }
}
