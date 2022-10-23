<?php

namespace App\Funcoes;
use App\Models\TipoRanking;
use Intervention\Image\ImageManagerStatic as Image;

class GeraBadge 
{
    public const DIRETORIO_BADGES ='/images/badges/';
    public const DIRETORIO_FONTES ='/assets/fonts/';
    
    public const FONTE_SHARK ='SRF2.ttf';
    
    public const TEMPLATE_SERIE_A = 'template_badge_serie_A.png';
    public const TEMPLATE_SERIE_B = 'template_badge_serie_B.png';
    public const TEMPLATE_TRIPLETE = 'template_badge_triplete.png';
    public const TEMPLATE_DOBLETE_A = 'template_badge_doblete_a.png';
    public const TEMPLATE_DOBLETE_B = 'template_badge_doblete_b.png';
    public const TEMPLATE_CAMPEAO_RODADA = 'template_badge_campeao_rodada.png';
    public const TEMPLATE_RODADA_WC = 'template_badge_rodada_wc.png';
    
    public const COR_SERIE_A = "#0088aa";
    public const COR_SERIE_B = "#0044aa";
    public const COR_COMPOSTO = "#2667b7";
    
    public $cd_ranking;
    public $ds_imagem;
                
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($cd_ranking)    
    {                
        $this->cd_ranking = $cd_ranking;
    }
    
    public function gerar(){   
              
        $tipoRanking = TipoRanking::where('id',$this->cd_ranking)->first();
        
        $ds_template = $this::DIRETORIO_BADGES;
        $ds_cor = '';
        $x = 0;
        $y = 0;
        if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_SIMPLES ||
        	$tipoRanking->tp_fase == TipoRanking::TIPO_FASE_GERAL){
            $ds_color = $this::COR_SERIE_A;
            if (env('TIPO_BOLAO','WC') == 'WC'){
                $ds_cor = $this::COR_COMPOSTO;
                $ds_template .= $this::TEMPLATE_RODADA_WC;
                $x = 125;
                $y = 205;                
            }
            else if ($tipoRanking->tp_serie == TipoRanking::TIPO_SERIE_A){
                $ds_template .= $this::TEMPLATE_SERIE_A; 
                $ds_cor = $this::COR_SERIE_A;
                $x = 120;
                $y = 218;
            }
            else if ($tipoRanking->tp_serie == TipoRanking::TIPO_SERIE_B){
                $ds_template .= $this::TEMPLATE_SERIE_B;
                $ds_cor = $this::COR_SERIE_B;
                $x = 102;
                $y = 215;
            }
        }
        else if ($tipoRanking->tp_fase == TipoRanking::TIPO_FASE_COMPOSTO){
            $ds_cor = $this::COR_COMPOSTO;
            
            $calculo = new CalculaRanking($this->cd_ranking);
            $calculo->recuperaPrimeiro();
            
            if ($calculo->ds_tipo_certificado == CalculaRanking::TRIPLETE){
                $ds_template .= $this::TEMPLATE_TRIPLETE;                
                $x = 125;
                $y = 205;
            }
            else if ($calculo->ds_tipo_certificado == CalculaRanking::DOBLETE_A){
                $ds_template .= $this::TEMPLATE_DOBLETE_A;
                $x = 125;
                $y = 205;
            }
            else if ($calculo->ds_tipo_certificado == CalculaRanking::DOBLETE_B){
                $ds_template .= $this::TEMPLATE_DOBLETE_B;
                $x = 125;
                $y = 205;
            }
            else if ($calculo->ds_tipo_certificado == CalculaRanking::CAMPEAO_RODADA){
                $ds_template .= $this::TEMPLATE_CAMPEAO_RODADA;
                $x = 125;
                $y = 205;
            }
        }
                
        $image = Image::make(public_path($ds_template));
        $image->text($tipoRanking->ds_abreviado, $x, $y, function($font) use($ds_cor){
            $font->file(public_path(GeraBadge::DIRETORIO_FONTES.GeraBadge::FONTE_SHARK));
            $font->size(36);
            $font->color($ds_cor);
            $font->align('center');            
        });
                
        $this->ds_imagem = 'badge_'.$tipoRanking->id.'.png';
        $image->save(public_path($this::DIRETORIO_BADGES.$this->ds_imagem));        
    }
}
