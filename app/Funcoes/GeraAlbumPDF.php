<?php

namespace App\Funcoes;

use App\Models\Selecao;
use App\Models\Jogador;
use App\Models\JogadorUsuario;
use Storage;
use App\Models\User;

class GeraAlbumPDF 
{
    private const TEMPLATE_CAPA = "assets/templates/capa_album.pdf";
    private const TEMPLATE_FINAL = "assets/templates/capa_final.pdf";
    private const TEMPLATE_PAGINA_IMPAR = "assets/templates/pagina_album_impar.pdf";
    private const TEMPLATE_PAGINA_PAR = "assets/templates/pagina_album_par.pdf";
    private const DIRETORIO_TMP = "/tmp";
       
    public const METODO_TELA = 'T';
    public const METODO_GRAVA = 'G';
    
    protected const INI_X = 9;
    protected const INI_Y_1 = 48;
    protected const INI_Y_2 = 5;
    protected const Y_SOMA = 55;
    protected const X_SOMA = 50;
    
    public $id_user;
    public $ds_file;
    public $ds_arquivo;
            
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($id_user)    
    {                
        $this->id_user = $id_user;
    }
    
    public function gerar($cd_metodo){
        
        $usuario = User::where('id',$this->id_user)->first();
        
        $pdf = new TemplateAlbum('P','mm','A4');
        $pdf->SetMargins(0,0);
        $pdf->AddFont('dusha','','Dusha.php');
        
        $pdf->template_capa = public_path($this::TEMPLATE_CAPA);
        $pdf->template_final = public_path($this::TEMPLATE_FINAL);
        $pdf->template_par = public_path($this::TEMPLATE_PAGINA_PAR);
        $pdf->template_impar = public_path($this::TEMPLATE_PAGINA_IMPAR);
        $pdf->ds_nome_usuario = $usuario->name;
        
        $pdf->id_capa = true; 
        $pdf->AliasNbPages();
        $pdf->AddPage();        
        
        $nr_pagina = 0;
        
        $selecoes = Selecao::where('id','<',Selecao::PAGINA_MAXIMA_ALBUM)
                    ->with('grupo')
                    ->get();
        foreach($selecoes as $selecao){
            $jogadores = Jogador::where('id_selecao',$selecao->id)->get();
            
            $nr_pagina++;
            $pdf->ds_icone = public_path('/images/federacoes/'.$selecao->ds_icone);
            $pdf->ds_selecao = $selecao->ds_nome;
            $pdf->ds_grupo = $selecao->grupo->ds_grupo;            
            $pdf->AddPage();
            $pdf->id_capa = false;
            $pdf->nr_pagina = $nr_pagina;
            $pdf->ds_selecao_footer = $selecao->ds_nome;
            
            $x = $this::INI_X;
            $y = $this::INI_Y_1;
            for ($i=0;$i<4;$i++){
                if (isset($jogadores[$i])){
                    
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {                        
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image                
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');                
                }
                $x += $this::X_SOMA;             
            }
            $x = $this::INI_X;
            $y += $this::Y_SOMA;
            for ($i=4;$i<8;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            $x = $this::INI_X;
            $y+= $this::Y_SOMA;
            for ($i=8;$i<12;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            $x = $this::INI_X;
            $y+= $this::Y_SOMA;
            for ($i=12;$i<16;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
           
            $nr_pagina++;
            $pdf->AddPage();
            $pdf->id_capa = false;
            $pdf->ds_selecao = $selecao->ds_nome;
            $pdf->nr_pagina = $nr_pagina;

            $x = $this::INI_X;
            $y = $this::INI_Y_2;
            for ($i=16;$i<20;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            $x = $this::INI_X;
            $y += $this::Y_SOMA;
            for ($i=20;$i<24;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            $x = $this::INI_X;
            $y += $this::Y_SOMA;
            for ($i=24;$i<28;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            $x = $this::INI_X;
            $y += $this::Y_SOMA;
            for ($i=28;$i<32;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            $x = $this::INI_X;
            $y += $this::Y_SOMA;
            for ($i=32;$i<36;$i++){
                if (isset($jogadores[$i])){
                    $figUsuario = JogadorUsuario::where('id_jogador',$jogadores[$i]->id)
                    ->where('id_user',$this->id_user)
                    ->first();
                    
                    if ($figUsuario == null){
                        $gerador = new GeraFigurinha($jogadores[$i]->id);
                        $image = $gerador->vazia();
                        $image->encode('png');
                    }
                    else {
                        $image = Storage::get('figurinhas/figurinha_'.$jogadores[$i]->id.'.png');
                    }
                    
                    $pic = 'data://text/plain;base64,' . base64_encode($image);
                    // extract dimensions from image
                    
                    $pdf->Image($pic, $x, $y, 40, 50, 'png');
                }
                $x += $this::X_SOMA;
            }
            
        }
        
        $pdf->AddPage();
        
        if ($cd_metodo == $this::METODO_TELA){
            $pdf->Output();
        }
        else {
            $this->ds_file = 'albumCopaBrothers18_'.$this->id_user.'.pdf';
            $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.$this->ds_file;
            $pdf->Output($this->ds_arquivo, 'F');
        }        
    }
}
