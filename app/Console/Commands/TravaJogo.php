<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StatusJogo;
use App\Models\Jogo;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailReciboPalpites;

class TravaJogo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jogos:travajogo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trava Jogos 1 hora antes do jogo';

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
        $corrente = new \DateTime();
        
        echo 'Testando Travamento de Jogos as '.$corrente->format('d/m/Y H:i:s').PHP_EOL;
        
        $limite = 60;
        
        $jogos = Jogo::where('cd_status',StatusJogo::JOGO_PROGRAMADO)
                 ->with('selecao1')
                 ->with('selecao2')
                 ->get();
        
        foreach($jogos as $jogo){
            $ds_dt_hr_jogo = $jogo->dt_jogo.' '.$jogo->hr_jogo;
            $dt_hr_jogo = new \DateTime($ds_dt_hr_jogo);
            $dif_jogo = $corrente->diff($dt_hr_jogo);
            
            $minutes = $dif_jogo->days * 24 * 60;
            $minutes += $dif_jogo->h * 60;
            $minutes += $dif_jogo->i;
            
            if (($minutes <= $limite) || ($dt_hr_jogo < $corrente)){
                
                echo 'Travando Jogo '.$jogo->selecao1->ds_nome.' X '.$jogo->selecao2->ds_nome.' de '.$jogo->dt_jogo.' as '.$jogo->hr_jogo.' '.PHP_EOL;
                
                $tb_jogos[] = $jogo->id;
                
                $jogo->cd_status = StatusJogo::JOGO_APOSTA_ENCERRADA;
                $jogo->save();
            }            
        }
        
        if (isset($tb_jogos)){
            
        	/*
            $jogosTrava = Jogo::whereIn('id',$tb_jogos)
            ->with('selecao1')
            ->with('selecao2')
            ->get();
            if (count($jogosTrava) > 0){
                foreach($jogosTrava as $jogoTrava){
                    $usersTrava = User::all();
                    foreach($usersTrava as $userTrava){
                        $aposta = Aposta::where('id_jogo',$jogoTrava->id)
                        ->where('id_user',$userTrava->id)
                        ->first();
                        if ($aposta == null){
                            $aposta10 = new Aposta();
                            $aposta10->id_jogo = $jogoTrava->id;
                            $aposta10->id_user = $userTrava->id;
                            $aposta10->qt_gols_selecao1 = 10;
                            $aposta10->qt_gols_selecao2 = 10;
                            $aposta10->save();
                            echo 'Criado Placar 10x10 em '.$jogoTrava->selecao1->ds_nome.' X '.$jogoTrava->selecao2->ds_nome.' para '.$userTrava->name.' '.PHP_EOL;
                        }
                    }
                }
            }
            */
            
            echo 'Enviando Emails de Apostas Finalizadas '.PHP_EOL;
            $users = User::all();            
            Mail::bcc($users)->send(new EmailReciboPalpites($tb_jogos));
        }
        
        echo 'Finalizacao Processo de Trava Jogos '.PHP_EOL;
    }
}
