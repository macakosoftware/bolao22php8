<?php

namespace App\Funcoes;

use App\Models\Aposta;
use App\Models\Jogo;

class CalculaResultado
{
    public $qt_pontos_total;
    public $qt_pontos_resultado;
    public $qt_pontos_placar_cheio;
    public $qt_pontos_placar_parcial;
    public $qt_pontos_bonus;
    public $id_resultado;
    public $id_placar_cheio;
    public $id_placar_parcial;
    public $id_bonus;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->qt_pontos_total = 0;
        $this->qt_pontos_resultado = 0;
        $this->qt_pontos_placar_cheio = 0;
        $this->qt_pontos_placar_parcial = 0;        
        $this->qt_pontos_bonus = 0;
        $this->id_resultado = false;
        $this->id_placar_cheio = false;
        $this->id_placar_parcial = false;
        $this->id_bonus = false;
    }
    
    public function calcular($id_aposta){
        $aposta = Aposta::where('id',$id_aposta)->first();
        
        $id_resultado_aposta = "";
        if ($aposta->qt_gols_selecao1 == $aposta->qt_gols_selecao2){
            $id_resultado_aposta = "X";
        }
        else if ($aposta->qt_gols_selecao1 > $aposta->qt_gols_selecao2){
            $id_resultado_aposta = "1";
        }
        else {
            $id_resultado_aposta = "2";
        }
        
        $jogo = Jogo::where('id',$aposta->id_jogo)->first();
        
        $id_resultado_jogo = "";
        $nr_pontos_resultado = 0;
        $id_vencedor = 0;
        if ($jogo->qt_gols_selecao1 == $jogo->qt_gols_selecao2){
            $id_resultado_jogo = "X";
            $nr_pontos_resultado = $jogo->nr_pontos_handcapX;
            $id_vencedor = $jogo->id_vencedor; 
        }
        else if ($jogo->qt_gols_selecao1 > $jogo->qt_gols_selecao2){
            $id_resultado_jogo = "1";
            $nr_pontos_resultado = $jogo->nr_pontos_handcap1;
        }
        else {
            $id_resultado_jogo = "2";
            $nr_pontos_resultado = $jogo->nr_pontos_handcap2;
        }
        
        if ($id_resultado_aposta == $id_resultado_jogo){
            $this->qt_pontos_resultado = $nr_pontos_resultado;
            $this->qt_pontos_total = $nr_pontos_resultado;
            $this->id_resultado = true;
            
            $pontuacao = new PontuacaoUsuario();
            $pontuacao->calcularProgramadoJogo($aposta->id);
            
            if ($aposta->qt_gols_selecao1 == $jogo->qt_gols_selecao1 &&
                $aposta->qt_gols_selecao2 == $jogo->qt_gols_selecao2){
                $this->qt_pontos_placar_cheio = $pontuacao->qt_pontos_placar_cheio;
                $this->qt_pontos_total += $this->qt_pontos_placar_cheio;
                $this->id_placar_cheio = true;
            }
            else if ($aposta->qt_gols_selecao1 == $jogo->qt_gols_selecao1){
                $this->qt_pontos_placar_parcial = $pontuacao->qt_pontos_placar_parcial1;
                $this->qt_pontos_total += $this->qt_pontos_placar_parcial;
                $this->id_placar_parcial = true;
            }
            else if ($aposta->qt_gols_selecao2 == $jogo->qt_gols_selecao2){
                $this->qt_pontos_placar_parcial = $pontuacao->qt_pontos_placar_parcial2;
                $this->qt_pontos_total += $this->qt_pontos_placar_parcial;
                $this->id_placar_parcial = true;
            }
            if ($id_resultado_jogo == 'X' && $jogo->id_penal == true){
            	if ($aposta->id_selecao_penal == $id_vencedor){
            		$this->qt_pontos_bonus = Jogo::PONTOS_BONUS;
            		$this->qt_pontos_total += $this->qt_pontos_bonus;
            		$this->id_bonus = true;
            	}
            }
        }
    }
}
