<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Funcoes\GeraRecibo;

class EmailRecibo extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $recibo = new GeraRecibo($this->usuario->id);
        $recibo->gerar(GeraRecibo::METODO_GRAVA);
        
        view()->share('ds_nome',$this->usuario->name);                
        return $this->view('email.envioRecibo')
                ->attach($recibo->ds_arquivo, [
                        'as' => 'recibo.pdf',
                        'mime' => 'application/pdf',
                ]);
    }
}
