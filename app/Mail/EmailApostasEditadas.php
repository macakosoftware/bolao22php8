<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Aposta;

class EmailApostasEditadas extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tb_apostas;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $tb_apostas)
    {
        $this->user = $user;
        $this->tb_apostas = $tb_apostas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $apostas = Aposta::whereIn('id',$this->tb_apostas)
                  ->with('jogo')
                  ->with('jogo.selecao1')
                  ->with('jogo.selecao2')
                  ->with('jogo.tipoRanking')
                  ->get();
        
        view()->share('user', $this->user);
        view()->share('apostas', $apostas);
        return $this->view('email.confirmacaoPalpites');
    }
}
