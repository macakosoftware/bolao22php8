<?php

namespace App\Funcoes;

use App\Models\MovimentoPagamento;
use Carbon\Carbon;
use App\Models\User;

class GeraRecibo 
{
    private const TEMPLATE_RECIBO = "assets/templates/template_recibo.pdf";
    private const DIRETORIO_TMP = "/tmp";
    public const METODO_TELA = 'T';
    public const METODO_GRAVA = 'G';
    
    public $id_user;
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
        
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->AddPage();
        $path = public_path($this::TEMPLATE_RECIBO);
        $pdf->setSourceFile($path);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf->SetFont('arial','',14);
        $pdf->ln(70);
        $pdf->Cell(10,10,'Participante: '.utf8_decode($usuario->name), 0, 'L');
        $pdf->ln(10);
        $pdf->Cell(10,10,'Email: '.$usuario->email,0,'L');
        $pdf->ln(10);
        $pdf->SetXY(10, 120);
        $pdf->MultiCell(185,5,utf8_decode('Confirmamos o pagamento de sua Joia Premio no valor de R$30,00 (trinta reais) e sua participação no Bolão Copa Brothers 2018. Segue abaixo os detalhes do seu pagamento:'),0,'J');
        $pdf->ln(10);
        
        $w = [50, 70, 70];
        $pdf->cell($w[0],10,'Data', 0, 'L');
        $pdf->cell($w[1],10,'Forma Pagamento', 0, 'L');
        $pdf->cell($w[2],10,'Valor Pagamento', 0, 'L');
        
        $movimentos = MovimentoPagamento::where('id_user', $this->id_user)
        ->with('formaPagamento')
        ->get();
        foreach($movimentos as $movimento){
            $pdf->ln(5);
            $pdf->cell($w[0],10,Carbon::parse($movimento->dt_hr_pagamento)->format('d/m/Y'), 0, 'L');
            $pdf->cell($w[1],10,utf8_decode($movimento->formaPagamento->ds_nome), 0, 'L');
            $pdf->cell($w[2],10,'R$'.number_format($movimento->vl_movimento, 2, ',', ''), 0, 'L');
        }
        
        if ($cd_metodo == $this::METODO_TELA){
            $pdf->Output();
        }
        else {
            $ds_file = date('Y-m-d').'_'.date('H:i:s').'_'.$this->id_user.'_recibo.pdf';
            $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.$ds_file;
            $pdf->Output($this->ds_arquivo, 'F');
        }
    }
}
