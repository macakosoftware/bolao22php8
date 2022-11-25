<?php

namespace App\Funcoes;

use App\Models\Ranking;
use App\Models\TipoRanking;
use App\Models\FaseRanking;
use App\Models\Premio;

class GeraChequePremio 
{
    private const TEMPLATE_PREMIO = "assets/templates/template_premio.pdf";
    private const TEMPLATE_PREMIO_2 = "assets/templates/template_premio_2.pdf";
    private const TEMPLATE_PREMIO_3 = "assets/templates/template_premio_3.pdf";
    
    private const DIRETORIO_TMP = "/tmp";
    public const METODO_TELA = 'T';
    public const METODO_GRAVA = 'G';
    
    public $premio;    
    public $ds_arquivo;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Premio $premio)    
    {                
        $this->premio = $premio;        
    }
    
    public function gerar($cd_metodo){
                
        $pdf = new \setasign\Fpdi\Fpdi('L','mm','A4');
        $pdf->SetMargins(1,1,1);
        //$pdf->AddFont('shark','','SRF2.php');
        $pdf->AddPage('L');
        $path = '';
        if ($this->premio->nr_posicao == 1){
            $path = public_path($this::TEMPLATE_PREMIO);
        }
        else if ($this->premio->nr_posicao == 2){
            $path = public_path($this::TEMPLATE_PREMIO_2);
        }
        else if ($this->premio->nr_posicao == 3){
            $path = public_path($this::TEMPLATE_PREMIO_3);
        }
        $pdf->setSourceFile($path);
        $tplIdx = $pdf->importPage(1);        
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf->SetFont('arial','',36);
        $pdf->ln(100);
        $pdf->Cell(289,10,utf8_decode($this->premio->usuario->name), 0, 0, 'C');
        $pdf->ln(15);
        $pdf->Cell(289,10,utf8_decode($this->premio->tipoRanking->ds_nome), 0, 0, 'C');
        $pdf->ln(15);
        $pdf->Cell(289,10,utf8_decode('R$ '.number_format($this->premio->vl_premio, 2, ',', '.')), 0, 0, 'C');
        $pdf->SetXY(228,100);
        $pdf->setFont('arial','',100);        
        $pdf->Cell(44,6,utf8_decode($this->premio->nr_posicao.'º'),0,0,'C');
        $pdf->SetXY(225,120);
        $pdf->setFont('arial','',40);
        $pdf->Cell(44,6,'lugar',0,0,'C');
        /*
        $pdf->ln(10);
        $pdf->SetFont('arial','',14);
        $pdf->SetXY(50, 110);
        $pdf->MultiCell(200,5,utf8_decode('O '.config('app.name').' orgulhosamente concede-lhe o certificado '.$calculo->ds_tipo_certificado.' por alcançar com méritos a pontuação de '.number_format($calculo->qt_pontos, 2, ',', '').' e a consequente primeira colocação na '.$tipoRanking->ds_nome.' do bolão.'),0,'J');
        $pdf->SetXY(236,183);
        $pdf->setFont('shark','',20);
        $pdf->SetTextColor(0, 34, 85);
        $pdf->Cell(44,6,$tipoRanking->ds_abreviado,0,0,'C');
        */ 
        
        if ($cd_metodo == $this::METODO_TELA){
            $pdf->Output();
        }
        else {
            $ds_file = date('Y-m-d').'_'.date('H:i:s').'_'.$this->premio->id_user.'_premio.pdf';
            $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.$ds_file;
            $pdf->Output($this->ds_arquivo, 'F');
        }        
    }
}
