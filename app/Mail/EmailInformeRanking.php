<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Funcoes\GeraInformeRanking;
use App\Models\TipoRanking;
use App\Models\StatusRanking;
use App\Models\StatusJogo;
use App\Models\Jogo;

class EmailInformeRanking extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {            
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tipos = TipoRanking::where('cd_status',StatusRanking::ABERTO)->get();
        $tb_rankings = array();
        foreach($tipos as $tipo){            
            $jogos = Jogo::where('cd_status',StatusJogo::JOGO_FINALIZADO)
                     ->where('cd_ranking',$tipo->id)
                     ->get();
            if (count($jogos) > 0 || $tipo->id == env('CLASSIFICACAO_GERAL')){
                $tb_rankings[] = $tipo->id;
            }
        }
        
        $informe = new GeraInformeRanking($tb_rankings);
        $informe->gerar();
        $informe->pdf->save($informe->ds_arquivo);
                        
        return $this->view('email.envioInformeRanking')
                ->attach($informe->ds_arquivo, [
                        'as' => 'informe_ranking.pdf',
                        'mime' => 'application/pdf',
                ]);
    }
}
