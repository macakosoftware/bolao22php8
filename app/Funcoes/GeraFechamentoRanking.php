<?php

namespace App\Funcoes;

use App\Models\TipoRanking;
use PDF;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class GeraFechamentoRanking 
{
    private const DIRETORIO_TMP ='/tmp';
    private const IMAGEM_PODIUM = "/images/podium.png";
    //private const GOLDEN_MEDAL = "/images/golden_medal.png";
    //private const SILVER_MEDAL = "/images/silver_medal.png";
    //private const BRONZE_MEDAL = "/images/bronze_medal.png";
    private const GOLDEN_RIBBON = "/images/golden_ribbon.png";
    private const SILVER_RIBBON = "/images/silver_ribbon.png";
    private const BRONZE_RIBBON = "/images/bronze_ribbon.png";
    
    public $cd_ranking;
    public $pdf;    
    public $ds_arquivo;
    public $ds_arq_podium;
            
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
        
        $rankingsDB = CalculaRanking::queryRanking($this->cd_ranking);
        
        $qt_posicao = 0;
        $avatar1 = '';
        $avatar2 = '';
        $avatar3 = '';
        $usuario_campeao = 0;
        $tb_ranking = array();
        foreach($rankingsDB as $ranking){
            $qt_posicao++;
            
            $tb_ranking[] = array('nr_posicao'=>$qt_posicao,
                        'ds_nome'=>$ranking->usuario->name,
                        'qt_pontos'=>$ranking->qt_pontos,
                        'qt_acertos_resultado'=>$ranking->qt_acertos_resultado,
                        'qt_acertos_cheio'=>$ranking->qt_acertos_cheio,
                        'qt_acertos_parcial'=>$ranking->qt_acertos_parcial,
                        'qt_pontos_resultado'=>$ranking->qt_pontos_resultado,
                        'qt_pontos_placar_cheio'=>$ranking->qt_pontos_placar_cheio,
                        'qt_pontos_placar_parcial'=>$ranking->qt_pontos_placar_parcial,
                        'qt_pontos_maior'=>$ranking->qt_pontos_maior,
                        'qt_apostas'=>$ranking->qt_apostas,
                        'id_ranking'=>$ranking->cd_ranking,
                        'id_user'=>$ranking->usuario->id
                         );
            for($i=1;$i<=3;$i++){
                if ($qt_posicao == $i){                
                    if (VerificaAvatar::verificar($ranking->usuario->id)){
                        ${'avatar'.$i} = Image::make(Storage::get('avatars/'.$ranking->usuario->id));                        
                    }
                    else{
                        ${'avatar'.$i} = Image::make(public_path('assets/images/avatars/user.jpg'));
                        ${'avatar'.$i}->resize(128,128);
                    }
                }                
            }
            if ($qt_posicao == 1){
                $usuario_campeao = $ranking->usuario;                
            }
        }
                
        view()->share('tipoRanking',$tipoRanking);        
        view()->share('tb_ranking',$tb_ranking);

        $this->ds_arquivo = $this::DIRETORIO_TMP.'/'.date('Y-m-d').'_'.date('H:i:s').'_fechamento_'.$this->cd_ranking.'.pdf';

        $img_golden = Image::make(public_path($this::GOLDEN_RIBBON))
        ->resize(60, 60);        
        $img_silver = Image::make(public_path($this::SILVER_RIBBON))
        ->resize(60, 60);
        $img_bronze = Image::make(public_path($this::BRONZE_RIBBON))
        ->resize(60, 60);
        
        $image = Image::make(public_path($this::IMAGEM_PODIUM));
        $image->insert($avatar2, 'top-left',26, 72);
        $image->insert($avatar1, 'top-left',206, 0);
        $image->insert($avatar3, 'top-left',399, 112);
        $image->insert($img_silver, 'top-left',87, 147);
        $image->insert($img_golden, 'top-left',262, 74);
        $image->insert($img_bronze, 'top-left',457, 189);        
        $this->ds_arq_podium = $this::DIRETORIO_TMP.'/podium_'.$this->cd_ranking.".png";
        $image->save($this->ds_arq_podium);
                
        view()->share('usuario_campeao', $usuario_campeao);        
        view()->share('ds_arq_podium',$this->ds_arq_podium);
        
        $badge = new GeraBadge($this->cd_ranking);
        $badge->gerar();
        view()->share('ds_badge',$badge->ds_imagem);
        
        $this->pdf = PDF::loadView('domPdf.fechamentoRanking');
    }
}
