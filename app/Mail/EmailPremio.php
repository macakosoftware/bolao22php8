<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Premio;
use App\Funcoes\GeraChequePremio;

class EmailPremio extends Mailable
{
    use Queueable, SerializesModels;
    
    public $premio;
        
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Premio $premio)
    {            
        $this->premio = $premio;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cheque = new GeraChequePremio($this->premio);
        $cheque->gerar(GeraChequePremio::METODO_GRAVA);
                
        view()->share('premio',$this->premio);
                
        return $this->view('email.envioPremio')
                ->attach($cheque->ds_arquivo, [
                        'as' => 'cheque_premio.pdf',
                        'mime' => 'application/pdf',
                ]);
    }
}
