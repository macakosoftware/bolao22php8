<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TipoRanking;
use App\Models\Jogo;

class EmailNovosJogos extends Mailable
{
    use Queueable, SerializesModels;

    public $jogo;
        
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Jogo $jogo)
    {
        $this->jogo = $jogo;    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $tipoRanking = TipoRanking::where('id',$this->jogo->cd_ranking)->first();
        
        $jogos = Jogo::where('cd_ranking',$this->jogo->cd_ranking)
                 ->with('selecao1')
                 ->with('selecao2')
                 ->with('tipoRanking')
                 ->get();
        
        view()->share('tipoRanking', $tipoRanking);
        view()->share('jogos', $jogos);        
        return $this->view('email.novosJogos');
    }
}
