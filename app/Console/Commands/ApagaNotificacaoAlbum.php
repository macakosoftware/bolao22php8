<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NotificacaoAlbum;
use App\Models\TransacaoProposta;

class ApagaNotificacaoAlbum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'figurinhas:apagarNotificacao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apaga Notificações de Ofertas com Transações já Encerradas';

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
        echo 'Executando Apagar Notificacao Album...';
        $notificacoes = NotificacaoAlbum::where('id_lido',false)->get();
        foreach($notificacoes as $notificacao){
            $oferta = TransacaoProposta::where('id',$notificacao->id_proposta)->first();
            if ($oferta != null){
            	if ($oferta->cd_status == TransacaoProposta::STATUS_CANCELADA){
                    $notificacao->id_lido = true;
                    $notificacao->save();
                }
            }
        }
    }
}
