<?php

namespace App\Funcoes;
use PDF;

class GeraReciboPalpites 
{
    private const DIRETORIO_TMP ='/tmp';
   
    public $pdf;    
    public $ds_arquivo;
    public $tb_saida;
            
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($tb_saida)    
    {   
        $this->tb_saida = $tb_saida;
    }
    
    public function gerar(){   
        
        view()->share('tb_saida',$this->tb_saida);

        $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.date('Y-m-d').'_'.date('H:i:s').'_recibo_palpites.pdf';
        
        //############ Permitir ver imagenes si falla ################################
          $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);

        $pdf = \PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($contxt);
        //#################################################################################
        $this->pdf = PDF::loadView('domPdf.reciboPalpites');
    }
}
