<?php

namespace App\Mail;

use App\Models\TipoRanking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Funcoes\GeraCertificado;

class EmailCertificadoRanking3 extends Mailable
{
    use Queueable, SerializesModels;
    
    public $tipoRanking;
    public $usuario_campeao;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TipoRanking $tipoRanking, User $usuario_campeao)
    {            
        $this->tipoRanking = $tipoRanking;
        $this->usuario_campeao = $usuario_campeao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $certificado = new GeraCertificado($this->tipoRanking->id, 3);
        $certificado->gerar(GeraCertificado::METODO_GRAVA);
        
        view()->share('usuario_campeao',$this->usuario_campeao);
        view()->share('tipoRanking',$this->tipoRanking);
        
        return $this->view('email.envioCertificado')
                ->attach($certificado->ds_arquivo, [
                        'as' => 'certificado.pdf',
                        'mime' => 'application/pdf',
                ]);
    }
}
