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
        
        $this->pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true ,'chroot' => public_path()])->setPaper('a4', 'portrait')->loadView('domPdf.reciboPalpites');
    }
}
