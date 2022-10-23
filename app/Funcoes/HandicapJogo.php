<?php

namespace App\Funcoes;

use App\Models\Selecao;
use App\Models\Handcap;

class HandicapJogo 
{
    public $id_handicap_casa;
    public $nr_pontos_handcap1;
    public $nr_pontos_handcapX;
    public $nr_pontos_handcap2;
    public $pc_handcap1;
    public $pc_handcapX;
    public $pc_handcap2;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($id_handicap_casa)    
    {                
        $this->id_handicap_casa = $id_handicap_casa;
        $this->nr_pontos_handcap1 = 0;
        $this->nr_pontos_handcapX = 0;
        $this->nr_pontos_handcap2 = 0;
        $this->pc_handcap1 = 0;
        $this->pc_handcapX = 0;
        $this->pc_handcap2 = 0;
    }
    
    public function calcular($id_selecao1, $id_selecao2){        
        
        $selecao1 = Selecao::where('id',$id_selecao1)
                    ->with('handcap')
                    ->first();
        $selecao2 = Selecao::where('id',$id_selecao2)
                    ->with('handcap')
                    ->first();
        
        if ($this->id_handicap_casa){
            $dif = ($selecao1->handcap->nr_pontuacao * (1 +(Handcap::PERCENTUAL_CASA/100))) - $selecao2->handcap->nr_pontuacao;
        }
        else {
            $dif = $selecao1->handcap->nr_pontuacao - $selecao2->handcap->nr_pontuacao;
        }
                
        $id_negativo = false;
        if ($dif < 0){
            $id_negativo = true;
            $dif = $dif * -1;
        }
        
        if ($dif == 0){
            $this->pc_handcap1 = 33;
            $this->pc_handcapX = 34;
            $this->pc_handcap2 = 33;
        }
        else if ($dif <= 8){
            $this->pc_handcap1 = 40;
            $this->pc_handcapX = 34;
            $this->pc_handcap2 = 31;
        }
        else if ($dif <= 10){
            $this->pc_handcap1 = 42;
            $this->pc_handcapX = 33;
            $this->pc_handcap2 = 30;
        }
        else if ($dif <= 15){
            $this->pc_handcap1 = 42;
            $this->pc_handcapX = 32;
            $this->pc_handcap2 = 27;
        }
        else if ($dif <= 20){
            $this->pc_handcap1 = 45;
            $this->pc_handcapX = 31;
            $this->pc_handcap2 = 25;
        }
        else if ($dif <= 25){
            $this->pc_handcap1 = 46;
            $this->pc_handcapX = 30;
            $this->pc_handcap2 = 24;
        }
        else if ($dif <= 30){
            $this->pc_handcap1 = 48;
            $this->pc_handcapX = 29;
            $this->pc_handcap2 = 23;
        }
        else if ($dif <= 35){
            $this->pc_handcap1 = 49;
            $this->pc_handcapX = 28;
            $this->pc_handcap2 = 22;
        }
        else if ($dif <= 40){
            $this->pc_handcap1 = 49;
            $this->pc_handcapX = 29;
            $this->pc_handcap2 = 23;
        }
        else if ($dif <= 45){
            $this->pc_handcap1 = 50;
            $this->pc_handcapX = 30;
            $this->pc_handcap2 = 23;
        }
        else if ($dif <= 50){
            $this->pc_handcap1 = 55;
            $this->pc_handcapX = 27;
            $this->pc_handcap2 = 20;
        }
        else if ($dif <= 60){
            $this->pc_handcap1 = 65;
            $this->pc_handcapX = 26;
            $this->pc_handcap2 = 18;
        }
        else if ($dif <= 65){
            $this->pc_handcap1 = 68;
            $this->pc_handcapX = 26;
            $this->pc_handcap2 = 17;
        }
        else if ($dif <= 70){
            $this->pc_handcap1 = 70;
            $this->pc_handcapX = 25;
            $this->pc_handcap2 = 17;
        }
        else if ($dif <= 75){
            $this->pc_handcap1 = 75;
            $this->pc_handcapX = 25;
            $this->pc_handcap2 = 17;
        }
        else if ($dif <= 80){
            $this->pc_handcap1 = 80;
            $this->pc_handcapX = 21;
            $this->pc_handcap2 = 16;
        }
        else if ($dif <= 85){
            $this->pc_handcap1 = 82;
            $this->pc_handcapX = 19;
            $this->pc_handcap2 = 14;
        }
        else if ($dif <= 90){
            $this->pc_handcap1 = 85;
            $this->pc_handcapX = 17;
            $this->pc_handcap2 = 12;
        }
        else {
            $this->pc_handcap1 = 90;
            $this->pc_handcapX = 15;
            $this->pc_handcap2 = 8;
        }
        
        if ($id_negativo){
            $pc_aux = $this->pc_handcap2;
            $this->pc_handcap2 = $this->pc_handcap1;
            $this->pc_handcap1 = $pc_aux;
        }
        
        $this->nr_pontos_handcap1 = number_format((100 / $this->pc_handcap1), 2);
        $this->nr_pontos_handcapX = number_format((100 / $this->pc_handcapX), 2);
        $this->nr_pontos_handcap2 = number_format((100 / $this->pc_handcap2), 2);
    }
   
}
