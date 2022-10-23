<?php

namespace App\Funcoes;

use App\Models\TipoRanking;

class GeraCertificado 
{
    private const TEMPLATE_TRIPLETE = "assets/templates/certificado_triplete.pdf";
    private const TEMPLATE_DOBLETE_A = "assets/templates/certificado_doblete_a.pdf";
    private const TEMPLATE_DOBLETE_B = "assets/templates/certificado_doblete_b.pdf";
    private const TEMPLATE_RODADA = "assets/templates/certificado_rodada.pdf";
    private const TEMPLATE_RODADA_WC = "assets/templates/certificado_rodada_wc.pdf";
    private const TEMPLATE_WC_1 = "assets/templates/certificado_geral_1.pdf";
    private const TEMPLATE_WC_2 = "assets/templates/certificado_geral_2.pdf";
    private const TEMPLATE_WC_3 = "assets/templates/certificado_geral_3.pdf";
    private const DIRETORIO_TMP = "/tmp";
    public const METODO_TELA = 'T';
    public const METODO_GRAVA = 'G';
    
    public $cd_ranking;
    public $nr_posicao;
    public $ds_arquivo;
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($cd_ranking, $nr_posicao)    
    {                
        $this->cd_ranking = $cd_ranking;
        $this->nr_posicao = $nr_posicao;
    }
    
    public function gerar($cd_metodo){
        
    	$tipoRanking = TipoRanking::where('id', $this->cd_ranking)->first();
    	
    	$calculo = new CalculaRanking($this->cd_ranking);
    	$calculo->recuperaPrimeiro();
        
        $ds_tipo_certificado = "";
        $ds_file_certificado = "";
        if ($this->nr_posicao == 1){
            if ($calculo->ds_tipo_certificado == CalculaRanking::TRIPLETE){        	
            	$ds_file_certificado = $this::TEMPLATE_TRIPLETE;
            }
            else if ($calculo->ds_tipo_certificado == CalculaRanking::DOBLETE_A){        	
            	$ds_file_certificado = $this::TEMPLATE_DOBLETE_A;        	
            }
            else if ($calculo->ds_tipo_certificado == CalculaRanking::DOBLETE_B){        	        	        	
            	$ds_file_certificado = $this::TEMPLATE_DOBLETE_B;        	
            }
            else {
                if (env('TIPO_BOLAO','WC') == 'WC'){
                    if ($calculo->tp_ranking == TipoRanking::TIPO_FASE_GERAL){
                       $ds_file_certificado = $this::TEMPLATE_WC_1;
                    }
                    else {
                       $ds_file_certificado = $this::TEMPLATE_RODADA_WC;                        
                    }
                }
                else {
            	   $ds_file_certificado = $this::TEMPLATE_RODADA;
                }
            }
        }
        else if ($this->nr_posicao == 2){
            if ($calculo->tp_ranking == TipoRanking::TIPO_FASE_GERAL){
                $ds_file_certificado = $this::TEMPLATE_WC_2;
            }
        }
        else if ($this->nr_posicao == 3){
            if ($calculo->tp_ranking == TipoRanking::TIPO_FASE_GERAL){
                $ds_file_certificado = $this::TEMPLATE_WC_3;
            }
        }
        
        $pdf = new \setasign\Fpdi\Fpdi('L','mm','A4');
        $pdf->SetMargins(1,1,1);        
        if (env('TIPO_BOLAO','WC') == 'WC' && $calculo->tp_ranking != TipoRanking::TIPO_FASE_GERAL){
            $pdf->SetTextColor(255,255,255);
        }
        $pdf->AddFont('shark','','SRF2.php');
        $pdf->AddPage('L');
        $path = public_path($ds_file_certificado);
        $pdf->setSourceFile($path);
        $tplIdx = $pdf->importPage(1);        
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf->SetFont('arial','',36);
        $pdf->ln(85);
        $ds_nome = $calculo->usuario_campeao->name;
        $ds_colocacao = "primeira";
        $qt_pontos = $calculo->qt_pontos;
        if ($this->nr_posicao == 2){            
            $ds_nome = $calculo->usuario_2->name;
            $ds_colocacao = "segunda";
            $qt_pontos = $calculo->qt_pontos_2;
        }
        else if ($this->nr_posicao == 3){
            $ds_nome = $calculo->usuario_3->name;
            $ds_colocacao = "terceira";
            $qt_pontos = $calculo->qt_pontos_3;
        }
        $pdf->Cell(289,10,utf8_decode($ds_nome), 0, 0, 'C');
        $pdf->ln(10);
        $pdf->SetFont('arial','',14);
        $pdf->SetXY(50, 110);
        $pdf->MultiCell(200,5,utf8_decode('O '.config('app.name').' orgulhosamente concede-lhe o certificado '.$calculo->ds_tipo_certificado.' por alcançar com méritos a pontuação de '.number_format($qt_pontos, 2, ',', '').' e a consequente '.$ds_colocacao.' colocação na '.$tipoRanking->ds_nome.' do bolão.'),0,'J');
        $pdf->SetXY(236,183);
        $pdf->setFont('shark','',20);
        $pdf->SetTextColor(0, 34, 85);
        if ($calculo->tp_ranking != TipoRanking::TIPO_FASE_GERAL){
            $pdf->Cell(44,6,$tipoRanking->ds_abreviado,0,0,'C');
        }
        else {
            $pdf->Cell(44,6,$this->nr_posicao.'o. Lugar',0,0,'C');
        }
        
        if ($cd_metodo == $this::METODO_TELA){
            $pdf->Output();
        }
        else {
            $ds_file = date('Y-m-d').'_'.date('H:i:s').'_'.$calculo->id_usuario_campeao.'_recibo.pdf';
            $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.$ds_file;
            $pdf->Output($this->ds_arquivo, 'F');
        }        
    }
}
