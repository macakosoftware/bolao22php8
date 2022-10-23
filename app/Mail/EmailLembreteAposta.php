<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\AvisoAposta;

class EmailLembreteAposta extends Mailable
{
    use Queueable, SerializesModels;

    public $aviso;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AvisoAposta $aviso)
    {
        $this->aviso = $aviso;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ds_subject = 'Lembrete para Criar Palpite - ';
        if ($this->aviso->tp_aviso == AvisoAposta::TIPO_AVISO_24){
            $ds_subject .= '24 Horas ';
        }
        else if ($this->aviso->tp_aviso == AvisoAposta::TIPO_AVISO_48){
            $ds_subject .= '48 Horas ';
        }
        else if ($this->aviso->tp_aviso == AvisoAposta::TIPO_AVISO_72){
            $ds_subject .= '72 Horas ';
        }
        $ds_subject .= $this->aviso->jogo->selecao1->ds_nome.' X '.$this->aviso->jogo->selecao2->ds_nome;
        
        view()->share('aviso',$this->aviso);
            
        return $this->subject($ds_subject)
               ->view('email.lembreteAposta');
    }
}
