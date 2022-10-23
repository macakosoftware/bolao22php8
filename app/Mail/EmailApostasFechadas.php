<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Jogo;
use App\Models\Aposta;

class EmailApostasFechadas extends Mailable
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
                                   
            $tb_saida[] = array('id_jogo'=>$id_jogo,
                                'jogo'=>$jogo,
                                'apostas'=>$apostas 
                               );
        }
        
        view()->share('tb_saida',$tb_saida);
            
        return $this->view('email.apostasFechadas');
    }
}
