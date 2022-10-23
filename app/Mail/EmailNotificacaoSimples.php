<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notificacao;

class EmailNotificacaoSimples extends Mailable
{
    use Queueable, SerializesModels;

    public $notificacao;
        
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notificacao $notificacao)
    {
        $this->notificacao = $notificacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        view()->share('notificacao', $this->notificacao);
                
        return $this->view('email.notificacaoSimples');
    }
}
