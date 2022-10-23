<?php

namespace App\Funcoes;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Jogador;

class GeraFigurinha 
{
    public const DIR_STORAGE = "/figurinhas/";
    public const DIR_JOGADOR = "/images/jogadores/";
    public const DIR_FONTES ='/assets/fonts/';
    public const DIR_FEDERACOES = "/images/federacoes/";
    
    public const IMAGE_MISTERY = "mistery.jpg";
        
    public const FONTE_SHARK ='SRF2.ttf';
    public const FONTE_ADIDAS ='Adidas2018.ttf';
    public const FONTE_BRASIL ='Brasil2018.ttf';
    public const FONTE_PUMA ='Puma2012.ttf';
    
    public const TEMPLATE_FIGURINHA = "images/template_figurinha.png";
    public const TEMPLATE_FIGURINHA_GOLDEN = "images/template_figurinha_golden.png";
    public const TEMPLATE_FIGURINHA_SILVER = "images/template_figurinha_silver.png";
    public const TEMPLATE_VAZIA = "images/template_vazia.png";
    
    public const TEMPLATE_CAMISA = "images/camisa_";
    public const COR_DOURADA = "dourada";
    public const COR_PRATEADA = "prateada";
    
    public const COR_BRANCO = "#ffffff";
    public const COR_PRETO = "#000000";
    public const COR_VERMELHO = "#800000";
    
    public const COR_GOLEIRO = "#ff6600";
    public const COR_DEFESA = "#a02c2c";
    public const COR_MEIO = "#2a7fff";
    public const COR_ATAQUE = "#37c871";
    
    public $id_jogador;
    public $ds_arquivo;
    public $ds_full_path;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($id_jogador)    
    {                
        $this->id_jogador = $id_jogador;
    }
    
    public function gerar(){
        
        $jogador = Jogador::where('id',$this->id_jogador)
                  ->with('selecao')
                  ->with('posicao')
                  ->first();
                
                  
        if (file_exists(public_path($this::DIR_JOGADOR.$this->id_jogador.".jpg"))){
            $ds_arquivo_fig = public_path($this::DIR_JOGADOR.$this->id_jogador.".jpg");
        }
        else{
            $ds_arquivo_fig = public_path($this::DIR_JOGADOR.$this::IMAGE_MISTERY);
        }
        
        $img_jogador = Image::make($ds_arquivo_fig)
        ->resize(287, 375);
                
        
        $img_federacao = Image::make(public_path($this::DIR_FEDERACOES.$jogador->selecao->ds_icone))
        ->resize(50, 50);
        
        if ($jogador->tp_jogador == Jogador::TIPO_GOLDEN){
            $ds_cor = $this::COR_DOURADA;   
        }
        else if ($jogador->tp_jogador == Jogador::TIPO_SILVER){
            $ds_cor = $this::COR_PRATEADA;
        }
        else {
            if ($jogador->selecao->ds_cor == ""){
                $ds_cor = 'preta';
            }
            else {
                $ds_cor = $jogador->selecao->ds_cor;
            }
        }
        
        $img_camisa = Image::make(public_path($this::TEMPLATE_CAMISA.$ds_cor.'.png'))
        ->resize(55,50);
        
        $nr_fonte1 = 32;
        $nr_fonte2 = 20;
        if (strlen($jogador->ds_abreviado) > 15){
            $nr_fonte1 = 24;
            $nr_fonte2 = 20;
        }
        
        $nr_fonte3 = 36;
        if (strlen($jogador->selecao->ds_nome) > 15){
            $nr_fonte3 = 24;
        }
        
        $ds_template_figurinha = $this::TEMPLATE_FIGURINHA;
        if ($jogador->tp_jogador == Jogador::TIPO_GOLDEN){
            $ds_template_figurinha = $this::TEMPLATE_FIGURINHA_GOLDEN;
        }
        else if ($jogador->tp_jogador == Jogador::TIPO_SILVER){
            $ds_template_figurinha = $this::TEMPLATE_FIGURINHA_SILVER;
        }
        
        $ds_cor_pos1 = '';
        $ds_cor_pos2 = '';
        if ($jogador->posicao->cd_posicao == "G"){
            $ds_cor_pos1 = $this::COR_GOLEIRO;
            $ds_cor_pos2 = $this::COR_BRANCO;
        }
        else if ($jogador->posicao->cd_posicao == "D"){
            $ds_cor_pos1 = $this::COR_DEFESA;
            $ds_cor_pos2 = $this::COR_BRANCO;
        }
        else if ($jogador->posicao->cd_posicao == "M"){
            $ds_cor_pos1 = $this::COR_MEIO;
            $ds_cor_pos2 = $this::COR_BRANCO;
        }
        else if ($jogador->posicao->cd_posicao == "A"){
            $ds_cor_pos1 = $this::COR_ATAQUE;
            $ds_cor_pos2 = $this::COR_BRANCO;
        }
        
        $image = Image::make(public_path($ds_template_figurinha));
        $image->insert($img_jogador, 'top-left',3, 3);
        $image->insert($img_federacao, 'top-right',10, 10);
        
        if ($jogador->ds_numero != "" && $jogador->ds_numero != "-"){
            $image->insert($img_camisa, 'top-right',5,380);
            if ($jogador->tp_jogador == Jogador::TIPO_GOLDEN ||
                $jogador->tp_jogador == Jogador::TIPO_SILVER){
                $ds_cor_numero = '#000000';
            }
            else {
                if ($jogador->selecao->ds_cor2 == ""){
                    $ds_cor_numero = '#000000';
                }
                else {
                    $ds_cor_numero = $jogador->selecao->ds_cor2;
                }
            }
            
            if ($jogador->selecao->ds_fonte == ""){
                $ds_fonte_numero = 'Dusha';
            }
            else {
                $ds_fonte_numero = $jogador->selecao->ds_fonte;
            }
            
            $image->text($jogador->ds_numero, 312, 418, function($font) use($ds_fonte_numero, $ds_cor_numero){
                $font->file(public_path($this::DIR_FONTES.$ds_fonte_numero.'.ttf'));
                $font->size(26);
                $font->color($ds_cor_numero);
                $font->align('center');
            });
        }
        
        $image->text($jogador->ds_abreviado, 180, 410, function($font) use($nr_fonte1){
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size($nr_fonte1);
            $font->color("#800000");
            $font->align('center');
        });
        $image->text($jogador->ds_time, 180, 430, function($font) use($nr_fonte2){
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size($nr_fonte2);
            $font->color("#800000");
            $font->align('center');
        });
        $image->text($jogador->selecao->ds_nome, 330, 250, function($font) use($nr_fonte3){
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size($nr_fonte3);
            $font->color("#ffffff");
            $font->align('center');
            $font->angle(90);
        });
        
        $image->circle(40, 310, 90, function ($draw) use($ds_cor_pos1){
            $draw->background($ds_cor_pos1);
        });        
        $image->text($jogador->posicao->ds_abreviado, 310, 100, function($font) use($ds_cor_pos2){
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size(26);
            $font->color($ds_cor_pos2);
            $font->align('center');            
        });
            
        $this->ds_arquivo = 'figurinha_'.$this->id_jogador.'.png';
        $this->ds_full_path = $this::DIR_STORAGE.$this->ds_arquivo;
        
        $image->encode('png');
        
        Storage::put(
            $this->ds_full_path,
            $image
            );
    }
    
    public function vazia(){

        $jogador = Jogador::where('id',$this->id_jogador)
        ->with('selecao')
        ->with('posicao')
        ->first();
        
        $ds_template_figurinha = $this::TEMPLATE_VAZIA;
        
        $image = Image::make(public_path($ds_template_figurinha));
        /*
        $image->text($this->id_jogador, 170, 310, function($font) {
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size(48);
            $font->color("#000000");
            $font->align('center');
        });
        */
        $image->text($jogador->ds_nome, 170, 380, function($font) {
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size(36);
            $font->color("#000000");
            $font->align('center');
        });
        $image->text(strtoupper($jogador->selecao->ds_nome), 170, 410, function($font) {
            $font->file(public_path($this::DIR_FONTES.$this::FONTE_SHARK));
            $font->size(24);
            $font->color("#000000");
            $font->align('center');
        });
        
        return $image;        
    }
}
