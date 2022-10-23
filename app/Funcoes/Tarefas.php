<?php

namespace App\Funcoes;

use App\Models\User;
use App\Models\Jogo;
use App\Models\Aposta;
use App\Models\StatusJogo;

class Tarefas
{
    public $id_pgto_pendente;
    public $vl_pago;
    public $pc_pagto;
    public $id_aposta_pendente;
    public $qt_tarefas;
    public $qt_jogos;
    public $qt_apostas;
    public $pc_apostas;
    public $id_tarefas;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->id_pgto_pendente = false;
    	$this->vl_pago = 0;
    	$this->id_aposta_pendente = false;
    	$this->qt_tarefas = 0;
    	$this->qt_jogos = 0;
    	$this->qt_apostas = 0;
    	$this->id_tarefas = false;
    	$this->pc_pagto = 100;
    	$this->pc_apostas = 100;
    }
    
    public function verificar(User $user){
    	if ($user->vl_pagamento < User::VALOR_JOIA_PREMIO){
    		$this->qt_tarefas++;
    		$this->id_pgto_pendente = true;
    		$this->vl_pago = $user->vl_pagamento;
    		$this->id_tarefas = true;
    		$pc_pgto = ($user->vl_pagamento / User::VALOR_JOIA_PREMIO)*100;
    		$this->pc_pagto = number_format($pc_pgto, 2);
    	}
    		
    	$jogos = Jogo::where('cd_status',StatusJogo::JOGO_PROGRAMADO)->get();
    	$this->qt_jogos = count($jogos);
    		
    	$apostas = Aposta::where('id_user',$user->id)->get();
    	$this->qt_apostas = count($apostas);
    	
    	if ($this->qt_apostas < $this->qt_jogos){
    		$this->qt_tarefas++;
    		$this->id_aposta_pendente = true;
    		$this->id_tarefas = true;
    		$pc_apostas = ($this->qt_apostas / $this->qt_jogos)*100;
    		$this->pc_apostas = number_format($pc_apostas, 2);
    	}
    	
    	return $this->id_tarefas;
    }
}
