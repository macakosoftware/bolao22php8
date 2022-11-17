<?php

namespace App\Funcoes;

use App\Models\Selecao;
use App\Models\PlacarPonto;
use App\Models\Placar;
use App\Models\Handcap;
use App\Models\Jogo;

class HandicapGol 
{
    public const DATA_CORTE = '2018-06-20';
    
    public $jogo;
    public $id_handicap_casa;
    public $tb_placar1;
    public $tb_placarX;
    public $tb_placar2;
    public $tb_parcial1;
    public $tb_parcial2;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Jogo $jogo){
        $this->jogo = $jogo;
        $this->id_handicap_casa = $this->jogo->tipoRanking->id_handicap_casa;
    }
        
    public function calcular($id_selecao1, $id_selecao2){        
        
        $selecao1 = Selecao::where('id',$id_selecao1)
                    ->with('handcap')
                    ->first();
        $selecao2 = Selecao::where('id',$id_selecao2)
                    ->with('handcap')
                    ->first();
        
        if($this->id_handicap_casa){
            $dif = ($selecao1->handcap->nr_pontuacao * (1 + (Handcap::PERCENTUAL_CASA))) - $selecao2->handcap->nr_pontuacao;
        }
        else{
            $dif = $selecao1->handcap->nr_pontuacao - $selecao2->handcap->nr_pontuacao;
        }
        
        $id_negativo = false;
        if ($dif < 0){
            $id_negativo = true;
            $dif = $dif * -1;
        }
        
        $dif = $selecao1->handcap->nr_pontuacao -
        $selecao2->handcap->nr_pontuacao;
        $id_negativo = false;
        if ($dif < 0){
            $dif = $dif * -1;
            $id_negativo = true;
        }
        
        
        $placaresPonto = PlacarPonto::where('nr_dif_inicial','<=',$dif)
        ->where('nr_dif_final','>=',$dif)
        ->with('placar')
        ->get();

        
        foreach($placaresPonto as $placarPonto){
            $placar = $placarPonto->placar->ds_placar;
            if ($placar == Placar::OUTROS_PLACARES){
                $this->tb_placar1[] = array('placar'=>$placar,
                    'pontos'=>$placarPonto->qt_pontos1);
                $this->tb_placar2[] = array('placar'=>$placar,
                    'pontos'=>$placarPonto->qt_pontos2);
                $this->tb_parcial1[] = array('placar'=>'MAIS DE 4',
                                             'pontos'=>number_format(($placarPonto->qt_pontos1/2),2));
                $this->tb_parcial2[] = array('placar'=>'MAIS DE 4',
                                             'pontos'=>number_format(($placarPonto->qt_pontos2/2),2));
                $media = ($placarPonto->qt_pontos1 + $placarPonto->qt_pontos2) / 2;
                $this->tb_placarX[] = array('placar'=>$placar,
                    'pontos'=>number_format($media,2));
            }
            else {
                $tb_placar_aux = explode('X',strtoupper($placar));
                if ($tb_placar_aux[0] == $tb_placar_aux[1]){
                    $this->tb_placarX[] = array('placar'=>$placar,
                        'pontos'=>$placarPonto->qt_pontos1);
                }
                else {
                    $this->tb_placar1[] = array('placar'=>$placar,
                        'pontos'=>$placarPonto->qt_pontos1);
                    $this->tb_placar2[] = array('placar'=>$placar,
                        'pontos'=>$placarPonto->qt_pontos2);
                    if (strtoupper($placar) == "1X0" ||
                        strtoupper($placar) == "2X1" ||
                        strtoupper($placar) == "3X1" ||
                        strtoupper($placar) == "4X1"){
                        if (strtoupper($placar) == "1X0"){
                            if ($this->jogo->dt_jogo <= $this::DATA_CORTE){           
                                $this->tb_parcial1[] = array('placar'=>intval(0),
                                    'pontos'=>number_format(($placarPonto->qt_pontos2/2),2));
                                $this->tb_parcial2[] = array('placar'=>intval(0),
                                    'pontos'=>number_format(($placarPonto->qt_pontos1/2),2));
                            }
                            else{
                                $this->tb_parcial1[] = array('placar'=>intval(0),
                                    'pontos'=>number_format(($placarPonto->qt_pontos1/2),2));
                                $this->tb_parcial2[] = array('placar'=>intval(0),
                                    'pontos'=>number_format(($placarPonto->qt_pontos2/2),2));
                            }
                        }
                        $this->tb_parcial1[] = array('placar'=>intval(trim($tb_placar_aux[0])),
                            'pontos'=>number_format(($placarPonto->qt_pontos1/2),2));
                        $this->tb_parcial2[] = array('placar'=>intval(trim($tb_placar_aux[0])),
                            'pontos'=>number_format(($placarPonto->qt_pontos2/2),2));
                    }
                    if ($placar == Placar::OUTROS_PLACARES){
                        $this->tb_parcial1[] = array('placar'=>Placar::OUTROS_PLACARES,
                            'pontos'=>number_format(($placarPonto->qt_pontos1/2),2));
                        $this->tb_parcial2[] = array('placar'=>Placar::OUTROS_PLACARES,
                            'pontos'=>number_format(($placarPonto->qt_pontos2/2),2));                    
                    }
                }
            }
        }
        if ($id_negativo){
            $placar_aux = $this->tb_placar2;
            $this->tb_placar2 = $this->tb_placar1;
            $this->tb_placar1 = $placar_aux;
        }
        if ($this->jogo->dt_jogo > $this::DATA_CORTE){            
            for($i=0;$i<count($this->tb_placar1);$i++){
                if ($this->tb_placar1[$i]['placar'] != Placar::OUTROS_PLACARES){                    
                    $tb_gols = explode('X',strtoupper($this->tb_placar1[$i]['placar']));
                    $qt_soma = 0;
                    
                    for($j=0;$j<count($this->tb_parcial1);$j++){
                        if ($this->tb_parcial1[$j]['placar'] == $tb_gols[0]){
                            $qt_soma += $this->tb_parcial1[$j]['pontos'];
                        }
                    }
                    for($j=0;$j<count($this->tb_parcial2);$j++){                        
                        if ($this->tb_parcial2[$j]['placar'] == $tb_gols[1]){
                            $qt_soma += $this->tb_parcial2[$j]['pontos'];
                        }                        
                    }
                    
                    if ($qt_soma > $this->tb_placar1[$i]['pontos']){
                        $this->tb_placar1[$i]['pontos'] = $qt_soma;
                    }                    
                }
            }
            for($i=0;$i<count($this->tb_placar2);$i++){
                if ($this->tb_placar2[$i]['placar'] != Placar::OUTROS_PLACARES){                    
                    $tb_gols = explode('X',strtoupper($this->tb_placar2[$i]['placar']));
                    $qt_soma = 0;
                    for($j=0;$j<count($this->tb_parcial2);$j++){
                        if ($this->tb_parcial2[$j]['placar'] == $tb_gols[0]){
                            $qt_soma += $this->tb_parcial2[$j]['pontos'];
                        }
                    }
                    for($j=0;$j<count($this->tb_parcial1);$j++){                        
                        if ($this->tb_parcial1[$j]['placar'] == $tb_gols[1]){
                            $qt_soma += $this->tb_parcial1[$j]['pontos'];
                        }                        
                    }
                    if ($qt_soma > $this->tb_placar2[$i]['pontos']){
                        $this->tb_placar2[$i]['pontos'] = $qt_soma;
                    }                    
                }
            }
        }
    }
   
}
