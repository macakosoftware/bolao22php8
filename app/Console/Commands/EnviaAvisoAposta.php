<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AvisoAposta;
use Mail;
use App\Mail\EmailLembreAposta;
use App\Mail\EmailLembreteAposta;

class EnviaAvisoAposta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apostas:enviarAviso';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia Aviso de Aposta Não Feita';

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
        $avisos = AvisoAposta::where('id_enviado',false)
                  ->with('usuario')
                  ->with('jogo')
                  ->get();
        if (count($avisos) > 0){
            foreach($avisos as $aviso){
                $aviso->id_enviado = true;
                $aviso->save();
                
                $ds_subject = 'Lembrete para Criar Palpite - ';
                if ($aviso->tp_aviso == AvisoAposta::TIPO_AVISO_24){
                    $ds_subject .= '24 Horas';
                }
                else if ($aviso->tp_aviso == AvisoAposta::TIPO_AVISO_48){
                    $ds_subject .= '48 Horas';
                }
                else if ($aviso->tp_aviso == AvisoAposta::TIPO_AVISO_72){
                    $ds_subject .= '72 Horas';
                }
                $ds_subject .= $aviso->jogo->selecao1->ds_nome.' X '.$aviso->jogo->selecao2->ds_nome;
                
                echo 'Enviando Emails de Lembrete de Aposta para '.$aviso->usuario->name.PHP_EOL;                
                Mail::to($aviso->usuario)                
                ->send(new EmailLembreteAposta($aviso));
            }
        }
    }
}
