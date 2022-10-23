<?php

namespace App\Funcoes;

use App\Models\Aposta;
use App\Models\Placar;
use App\Models\Jogo;
use App\Models\StatusJogo;

/**
 * App\Funcoes\PontuacaoUsuario
 *
 * @property int $qt_pontos_maximo 
 * @property int $qt_pontos_resultado 
 * @property int $qt_pontos_placar_cheio 
 * @property int $qt_pontos_placar_parcial1 
 * @property int $qt_pontos_placar_parcial2  
 * @property int $qt_pontos_bonus  
 * @property int $qt_total_maximo  
 * @property int $qt_total_resultado  
 * @property int $qt_total_placar_cheio  
 * @property int $qt_total_placar_parcial  
 * @property int $qt_total_pontos_bonus  
 * @property int $qt_apostas  
 * @property string $dt_hr_ult_aposta  
 * 
 * @method void calcularUsuario(int $id_user)
 * @method void calcularProgramadoJogo(int $id_aposta)
 */ 
class PontuacaoUsuario 
{
    public $qt_pontos_maximo;
    public $qt_pontos_resultado;
    public $qt_pontos_placar_cheio;
    public $qt_pontos_placar_parcial1;
    public $qt_pontos_placar_parcial2;
    public $qt_pontos_bonus;
    
    public $qt_total_maximo;
    public $qt_total_resultado;
    public $qt_total_placar_cheio;
    public $qt_total_placar_parcial;
    public $qt_total_pontos_bonus;
    public $qt_apostas;
    public $dt_hr_ult_aposta;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()    
    {                
        $this->qt_pontos_maximo = "";
        $this->qt_pontos_resultado = "";
        $this->qt_pontos_placar_cheio = "";
        $this->qt_pontos_placar_parcial1 = "";
        $this->qt_pontos_placar_parcial2 = "";
        $this->qt_pontos_bonus = "";
        $this->qt_pontos_bonus = "";
        
        $this->qt_total_maximo = "";
        $this->qt_total_resultado = "";
        $this->qt_total_placar_cheio = "";
        $this->qt_total_placar_parcial = "";
        $this->qt_total_pontos_bonus = "";
        
        $this->qt_apostas = 0;
        $this->dt_hr_ult_aposta = "";
    }
    
    public function calcularUsuario($id_user){
        $apostas = Aposta::where('id_user', $id_user)           
                   ->get();
        
        if (count($apostas) > 0){
            $this->qt_total_maximo = 0;
            $this->qt_total_resultado = 0;
            $this->qt_total_placar_cheio = 0;
            $this->qt_total_placar_parcial = 0;
            $this->qt_total_pontos_bonus = 0;
            
            foreach($apostas as $aposta){
                
                $jogo = Jogo::where('id',$aposta->id_jogo)->first();
                if ($jogo->cd_status == StatusJogo::JOGO_FINALIZADO){
                    $calculo = new CalculaResultado();
                    $calculo->calcular($aposta->id);
                    
                    $this->qt_total_maximo += $calculo->qt_pontos_total;
                    $this->qt_total_resultado += $calculo->qt_pontos_resultado;
                    $this->qt_total_placar_cheio += $calculo->qt_pontos_placar_cheio;
                    $this->qt_total_placar_parcial += $calculo->qt_pontos_placar_parcial;
                    $this->qt_total_pontos_bonus += $calculo->qt_pontos_bonus;
                }
                else {
                    $calculo = new PontuacaoUsuario();
                    $calculo->calcularProgramadoJogo($aposta->id);
                    
                    $this->qt_total_maximo += $calculo->qt_pontos_maximo;
                    $this->qt_total_resultado += $calculo->qt_pontos_resultado;
                    $this->qt_total_placar_cheio += $calculo->qt_pontos_placar_cheio;
                    if ($calculo->qt_pontos_placar_parcial1 > $calculo->qt_pontos_placar_parcial2){
                        $this->qt_total_placar_parcial += $calculo->qt_pontos_placar_parcial1;
                    }
                    else{
                        $this->qt_total_placar_parcial += $calculo->qt_pontos_placar_parcial2;
                    }
                }
                
                $this->qt_apostas++;
                if ($aposta->updated_at > $this->dt_hr_ult_aposta){
                    $this->dt_hr_ult_aposta = $aposta->updated_at;
                }
            }
        }
    }
    
    public function calcularProgramadoJogo($id_aposta){        
        
        $aposta = Aposta::where('id', $id_aposta)
        ->with('jogo')
        ->with('jogo.tipoRanking')
        ->first();
        $qt_aposta_selecao1 = "";
        $qt_aposta_selecao2 = "";
        if ($aposta != null){
            $qt_aposta_selecao1 = intval($aposta->qt_gols_selecao1);
            $qt_aposta_selecao2 = intval($aposta->qt_gols_selecao2);
        }

        $this->qt_pontos_maximo = "";
        $this->qt_pontos_resultado = "";
        $this->qt_pontos_placar_cheio = "";
        $this->qt_pontos_placar_parcial = "";
        $this->qt_pontos_bonus = "";
        
        if ($qt_aposta_selecao1 !=="" && $qt_aposta_selecao2 !== ""){
            $handicapGol = new HandicapGol($aposta->jogo);
            $handicapGol->calcular($aposta->jogo->id_selecao1, $aposta->jogo->id_selecao2);
            
            $this->qt_pontos_maximo = 0;
            $this->qt_pontos_resultado = 0;
            $this->qt_pontos_placar_cheio = 0;
            $this->qt_pontos_placar_parcial = 0;
            $this->qt_pontos_bonus = 0;
            if ($qt_aposta_selecao1 == $qt_aposta_selecao2){
                $this->qt_pontos_resultado = $aposta->jogo->nr_pontos_handcapX;
                $this->qt_pontos_maximo = $aposta->jogo->nr_pontos_handcapX;
                
                $ds_placar = trim(str($qt_aposta_selecao1))."X".trim(str($qt_aposta_selecao2));
                $id_achou = false;
                $qt_pontos_outros = 0;
                foreach($handicapGol->tb_placarX as $placarX){
                    if (strtoupper($placarX['placar']) == $ds_placar){
                        $this->qt_pontos_placar_cheio = $placarX['pontos'];
                        $this->qt_pontos_maximo += $placarX['pontos'];
                        $id_achou = true;
                    }                    
                    if ($placarX['placar'] == Placar::OUTROS_PLACARES){
                        $qt_pontos_outros = $placarX['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_cheio = $qt_pontos_outros;
                    $this->qt_pontos_maximo += $qt_pontos_outros;
                }
                $this->qt_pontos_placar_parcial = 0;
                if ($aposta->jogo->id_penal){
                	$this->qt_pontos_bonus = Jogo::PONTOS_BONUS;
                	$this->qt_pontos_maximo += $this->qt_pontos_bonus;
                }
            }
            else if ($qt_aposta_selecao1 > $qt_aposta_selecao2){
                $this->qt_pontos_resultado = $aposta->jogo->nr_pontos_handcap1;
                $this->qt_pontos_maximo = $aposta->jogo->nr_pontos_handcap1;
                
                $ds_placar = trim($qt_aposta_selecao1)."X".trim($qt_aposta_selecao2);
                $id_achou = false;
                $qt_pontos_outros = 0;
                
                foreach($handicapGol->tb_placar1 as $placar1){
                    if (strtoupper($placar1['placar']) == $ds_placar){
                        $this->qt_pontos_placar_cheio = $placar1['pontos'];
                        $this->qt_pontos_maximo += $placar1['pontos'];
                        $id_achou = true;
                    }
                    if ($placar1['placar'] == Placar::OUTROS_PLACARES){
                        $qt_pontos_outros = $placar1['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_cheio = $qt_pontos_outros;
                    $this->qt_pontos_maximo += $qt_pontos_outros;
                }
                
                $id_achou = false;
                $qt_pontos_outros = 0;
                foreach($handicapGol->tb_parcial1 as $parcial1){
                    if ($parcial1['placar'] !== Placar::MAIS_DE_4){
                        if ($parcial1['placar'] == $qt_aposta_selecao1){
                            $this->qt_pontos_placar_parcial1 = $parcial1['pontos'];
                            $id_achou = true;
                        }
                    }
                    if ($parcial1['placar'] == Placar::MAIS_DE_4){
                        $qt_pontos_outros = $parcial1['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_parcial1 = $qt_pontos_outros;
                }
                $id_achou = false;
                $qt_pontos_outros = 0;                
                foreach($handicapGol->tb_parcial2 as $parcial2){                   
                    if ($parcial2['placar'] !== Placar::MAIS_DE_4){
                        if ($parcial2['placar'] == $qt_aposta_selecao2){
                            $this->qt_pontos_placar_parcial2 = $parcial2['pontos'];
                            $id_achou = true;
                        }
                    }
                    if ($parcial2['placar'] == Placar::MAIS_DE_4){
                        $qt_pontos_outros = $parcial2['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_parcial2 = $qt_pontos_outros;
                }
            }
            else if ($qt_aposta_selecao2 > $qt_aposta_selecao1){
                
                $this->qt_pontos_resultado = $aposta->jogo->nr_pontos_handcap2;
                $this->qt_pontos_maximo = $aposta->jogo->nr_pontos_handcap2;
                
                $ds_placar = trim($qt_aposta_selecao2)."X".trim($qt_aposta_selecao1);
                $id_achou = false;
                $qt_pontos_outros = 0;
                foreach($handicapGol->tb_placar2 as $placar2){
                    if (strtoupper($placar2['placar']) == $ds_placar){
                        $this->qt_pontos_placar_cheio = $placar2['pontos'];
                        $this->qt_pontos_maximo += $placar2['pontos'];
                        $id_achou = true;
                    }
                    if ($placar2['placar'] == Placar::OUTROS_PLACARES){
                        $qt_pontos_outros = $placar2['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_cheio = $qt_pontos_outros;
                    $this->qt_pontos_maximo += $qt_pontos_outros;
                }
                
                $id_achou = false;
                $qt_pontos_outros = 0;
                foreach($handicapGol->tb_parcial1 as $parcial1){
                    if ($parcial1['placar'] !== Placar::MAIS_DE_4){
                        if ($parcial1['placar'] == $qt_aposta_selecao1){
                            $this->qt_pontos_placar_parcial1 = $parcial1['pontos'];
                            $id_achou = true;
                        }
                    }
                    if ($parcial1['placar'] == Placar::MAIS_DE_4){
                        $qt_pontos_outros = $parcial1['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_parcial1 = $qt_pontos_outros;
                }
                $id_achou = false;
                $qt_pontos_outros = 0;
                foreach($handicapGol->tb_parcial2 as $parcial2){
                    if ($parcial2['placar'] !== Placar::MAIS_DE_4){
                        if ($parcial2['placar'] == $qt_aposta_selecao2){
                            $this->qt_pontos_placar_parcial2 = $parcial2['pontos'];
                            $id_achou = true;
                        }
                    }
                    if ($parcial2['placar'] == Placar::MAIS_DE_4){
                        $qt_pontos_outros = $parcial2['pontos'];
                    }
                }
                if ($id_achou == false){
                    $this->qt_pontos_placar_parcial2 = $qt_pontos_outros;
                }
            }
        }
    }
   
}
