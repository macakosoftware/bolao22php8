<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Jogo;
use App\Funcoes\GeraReciboPalpites;
use App\Models\Aposta;
use App\Funcoes\PontuacaoUsuario;

class EmailReciboPalpites extends Mailable
{
    use Queueable, SerializesModels;
    
    public $tb_jogos;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tb_jogos)
    {            
        $this->tb_jogos = $tb_jogos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tb_saida = array();
        foreach($this->tb_jogos as $id_jogo){
            
            $jogo = Jogo::where('id',$id_jogo)
            ->with('selecao1')
            ->with('selecao2')
            ->first();
            
            $apostas = Aposta::where('id_jogo',$id_jogo)
            ->with('usuario')
            ->with('jogo')
            ->get()
            ->sortBy('usuario.name');
            $tb_apostas = array();
            foreach($apostas as $aposta){                
                $pontuacao = new PontuacaoUsuario();
                $pontuacao->calcularProgramadoJogo($aposta->id);
                
                $tb_apostas[] = array('aposta'=>$aposta,
                                      'pontuacao'=>$pontuacao
                                      );
            }
            
            $tb_saida[] = array('id_jogo'=>$id_jogo,
                'jogo'=>$jogo,
                'tb_apostas'=>$tb_apostas
            );
        }
        
        $recibo = new GeraReciboPalpites($tb_saida);
        $recibo->gerar();
        $recibo->pdf->save($recibo->ds_arquivo);
                        
        view()->share('tb_saida',$tb_saida);
        
        return $this->view('email.envioReciboPalpites')
                ->subject('Palpites Encerrados - Recibo Palpites')
                ->attach($recibo->ds_arquivo, [
                        'as' => 'recibo_palpites.pdf',
                        'mime' => 'application/pdf',
                ]);
    }
}
