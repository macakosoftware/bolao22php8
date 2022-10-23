<?php
namespace App\Funcoes;

class TemplateAlbum extends \setasign\Fpdi\Fpdi
{
    public $template_capa;
    public $template_final;
    public $template_impar;
    public $template_par;
    public $id_capa;
    public $ds_selecao;
    public $ds_selecao_footer;
    public $ds_grupo;
    public $ds_icone;
    public $nr_pagina;
    public $ds_nome_usuario;
    
    protected $_tplIdx;
    
    // Page header
    public function Header()
    {
        
        if ($this->PageNo() == 1) {
            $this->setSourceFile($this->template_capa);
        }
        else {
            if ($this->PageNo() > 63){
                $this->setSourceFile($this->template_final);   
            }
            else {
                if ($this->PageNo() % 2 == 0){
                    $this->setSourceFile($this->template_impar);
                }
                else {
                    $this->setSourceFile($this->template_par);
                }
            }
        }
        $this->_tplIdx = $this->importPage(1);
        
        
        $this->useImportedPage($this->_tplIdx);
        
       
        if ($this->PageNo() > 1 && $this->PageNo() < 64){
            
            if ($this->PageNo() % 2 == 0){
                $this->Image($this->ds_icone,2,2,40,40,'png');
                $this->setFont('dusha','',48);
                $this->SetTextColor(0, 0, 0);
                $this->SetY(20);
                $this->SetX(45);
                $this->Cell(140,1,utf8_decode($this->ds_selecao),0,0,'L');
                $this->setFont('dusha','',24);
                $this->SetTextColor(0, 0, 0);
                $this->SetY(30);
                $this->SetX(45);
                $this->Cell(140,1,utf8_decode($this->ds_grupo),0,0,'L');
            }
            
        }       

    }
            
    // Page footer
    public function Footer()
    {   
        if ($this->PageNo() > 1 && $this->PageNo() < 64){
            $this->setFont('dusha','',20);
            $this->SetTextColor(255, 255, 255);
            $this->SetY(-10);
            if ($this->nr_pagina % 2 == 0){
                $this->SetX(1);
                $this->Cell(50,0,utf8_decode($this->nr_pagina),0,0,'C');                
                $this->SetX(18);
                $this->Cell(163,0,utf8_decode($this->ds_selecao_footer),0,0,'R');
            }
            else {
                $this->SetX(30);
                $this->Cell(100,0,utf8_decode($this->ds_selecao_footer),0,0,'L');
                $this->SetX(160);
                $this->Cell(50,0,utf8_decode($this->nr_pagina),0,0,'C');
            }
        }
    }
    
    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);        
        $this->Rotate(0);
    }
    
    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
            if($y==-1)
                $y=$this->y;
                if($angle!=0)
                    $this->_out('Q');
                    $this->angle=$angle;
                    if($angle!=0)
                    {
                        $angle*=M_PI/180;
                        $c=cos($angle);
                        $s=sin($angle);
                        $cx=$x*$this->k;
                        $cy=($this->h-$y)*$this->k;
                        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
                    }
    }
}