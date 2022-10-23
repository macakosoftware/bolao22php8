<?php

namespace App\Mail;

use App\Models\TipoRanking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Funcoes\GeraFechamentoRanking;

class EmailFechamentoRanking extends Mailable
{
    use Queueable, SerializesModels;
    
    public $tipoRanking;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TipoRanking $tipoRanking)
    {            
        $this->tipoRanking = $tipoRanking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fechamento = new GeraFechamentoRanking($this->tipoRanking->id);
        $fechamento->gerar();        
        $fechamento->pdf->save($fechamento->ds_arquivo);
                        
        view()->share('tipoRanking',$this->tipoRanking);
        return $this->view('email.envioFechamentoRanking')
                ->attach($fechamento->ds_arquivo, [
                        'as' => 'fechamento_ranking.pdf',
                        'mime' => 'application/pdf',
                ]);
    }
}
