<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\HistoricoPontoXP;
use App\Models\JogadorUsuario;
use App\Models\TransacaoFigurinha;
use App\Models\TransacaoProposta;
use App\Models\Pagamento;
use App\Models\Jogo;
use App\Models\Selecao;
use Illuminate\Support\Facades\DB;

class CreditaPontosXPDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pontosxp:creditodiario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crédito Diário de Pontos XP';

    protected const PONTOS_LOGIN = 10;
    protected const PONTOS_COMPRA_FIGURINHA = 5;
    protected const PONTOS_TRANSACAO_FECHADA = 5;
    protected const PONTOS_OFERTA_ACEITA = 5;
    protected const PONTOS_ABERTURA = 30;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();         
        $corrente = new \DateTime();
           
        $teste_24_horas = 60 * 24;
        
        DB::beginTransaction();
        
        // PROMOCOES - VERIFICA
        $id_abertura = false;
        $id_brasil = false;
        
        $dt_abertura = Jogo::min('dt_jogo');
        if (date('Y-m-d') == $dt_abertura){
            echo 'Data de Abertura --> '.$dt_abertura.' '.PHP_EOL;
            $id_abertura = true;
        }
        
        $selecaoBrasil = Selecao::where('ds_nome','Brasil')->first();
        if ($selecaoBrasil != null){
            $jogosBrasil = Jogo::where(function ($q) use ($selecaoBrasil){
                            $q->where('id_selecao1',$selecaoBrasil->id)
                            ->orWhere('id_selecao2',$selecaoBrasil->id);
                        })
                        ->get();
            foreach($jogosBrasil as $jogoBrasil){
                if (date('Y-m-d') == $jogoBrasil->dt_jogo){
                    $id_brasil = true;
                }
            }
        }
        
        foreach($users as $user){ 
            $total_pontos = 0;
            if ($user->cd_pagamento == Pagamento::PAGO){
                if ($id_abertura){
                    echo 'Usuario '.$user->name.' credito '.$this::PONTOS_ABERTURA.' PELA ABERTURA DA COPA '.PHP_EOL;
                    
                    $user->qt_pontos_xp += $this::PONTOS_ABERTURA;
                    $user->save();
                    
                    $hist = new HistoricoPontoXP();
                    $hist->id_user = $user->id;
                    $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
                    $hist->dt_transacao = date('Y-m-d');
                    $hist->ds_transacao = 'Bônus 30 pontos Abertura da Copa - A FESTA VAI COMEÇAR!';
                    $hist->vl_transacao = $this::PONTOS_ABERTURA;
                    $hist->save();
                }
                
                $dt_hr_login = $corrente->diff(new \DateTime($user->dt_hr_login));
                $minutes = $dt_hr_login->days * 24 * 60;
                $minutes += $dt_hr_login->h * 60;
                $minutes += $dt_hr_login->i;
                
                if ($minutes <= $teste_24_horas){
                    echo 'Usuario '.$user->name.' credito '.$this::PONTOS_LOGIN.' por login diario '.PHP_EOL;
                    
                    $user->qt_pontos_xp += $this::PONTOS_LOGIN;
                    $user->save();
                    
                    $total_pontos += $this::PONTOS_LOGIN;
                    
                    $hist = new HistoricoPontoXP();
                    $hist->id_user = $user->id;
                    $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
                    $hist->dt_transacao = date('Y-m-d');
                    $hist->ds_transacao = 'Bônus Diário de 10 pontos por login';
                    $hist->vl_transacao = $this::PONTOS_LOGIN;
                    $hist->save();
                }
                
                $tem_compra = false;
                $figurinhas = JogadorUsuario::where('id_user',$user->id)
                              ->get();
                foreach($figurinhas as $figurinha){
                    $dt_hr_compra = $corrente->diff(new \DateTime($figurinha->updated_at));
                    $minutes = $dt_hr_compra->days * 24 * 60;
                    $minutes += $dt_hr_compra->h * 60;
                    $minutes += $dt_hr_compra->i;
                    
                    if ($minutes <= $teste_24_horas){
                        $tem_compra = true;
                    }
                }
                
                if ($tem_compra){
                    echo 'Usuario '.$user->name.' credito '.$this::PONTOS_COMPRA_FIGURINHA.' por compra figurinha '.PHP_EOL;
                    
                    $user->qt_pontos_xp += $this::PONTOS_COMPRA_FIGURINHA;
                    $user->save();
                    
                    $total_pontos += $this::PONTOS_COMPRA_FIGURINHA;
                    
                    $hist = new HistoricoPontoXP();
                    $hist->id_user = $user->id;
                    $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
                    $hist->dt_transacao = date('Y-m-d');
                    $hist->ds_transacao = 'Bônus Diário de 5 pontos por compra de figurinha';
                    $hist->vl_transacao = $this::PONTOS_TRANSACAO_FECHADA;
                    $hist->save();
                }
                
                $tem_transacao = false;
                $transacoes = TransacaoFigurinha::where('id_user',$user->id)->get();
                foreach($transacoes as $transacao){
                    if ($transacao->cd_status == TransacaoFigurinha::STATUS_FECHADA){
                        $dt_hr_transa = $corrente->diff(new \DateTime($transacao->updated_at));
                        $minutes = $dt_hr_transa->days * 24 * 60;
                        $minutes += $dt_hr_transa->h * 60;
                        $minutes += $dt_hr_transa->i;
                        
                        if ($minutes <= $teste_24_horas){
                            foreach($transacao->propostas as $proposta){
                                if ($proposta->cd_status == TransacaoProposta::STATUS_ACEITA){
                                    $tem_transacao = true;
                                }
                            }
                        }
                    }
                }
                
                if ($tem_transacao){
                    echo 'Usuario '.$user->name.' credito '.$this::PONTOS_TRANSACAO_FECHADA.' por transacao_fechada '.PHP_EOL;
                    
                    $user->qt_pontos_xp += $this::PONTOS_TRANSACAO_FECHADA;
                    $user->save();
                    
                    $total_pontos += $this::PONTOS_TRANSACAO_FECHADA;
                    
                    $hist = new HistoricoPontoXP();
                    $hist->id_user = $user->id;
                    $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
                    $hist->dt_transacao = date('Y-m-d');
                    $hist->ds_transacao = 'Bônus Diário de 5 pontos por transação fechada com oferta aceita';
                    $hist->vl_transacao = $this::PONTOS_TRANSACAO_FECHADA;
                    $hist->save();
                }
                
                $tem_oferta = false;
                $ofertas = TransacaoProposta::where('id_user_proposta',$user->id)->get();
                foreach($ofertas as $oferta){
                    if ($oferta->cd_status == TransacaoProposta::STATUS_ACEITA){
                        $dt_hr_oferta = $corrente->diff(new \DateTime($oferta->updated_at));
                        $minutes = $dt_hr_oferta->days * 24 * 60;
                        $minutes += $dt_hr_oferta->h * 60;
                        $minutes += $dt_hr_oferta->i;
                        if ($minutes <= $teste_24_horas){
                            $tem_oferta = true;
                        }
                    }
                }
                
                if ($tem_oferta){
                    echo 'Usuario '.$user->name.' credito '.$this::PONTOS_OFERTA_ACEITA.' por oferta aceita '.PHP_EOL;
                    
                    $user->qt_pontos_xp += $this::PONTOS_OFERTA_ACEITA;
                    $user->save();
                    
                    $total_pontos += $this::PONTOS_OFERTA_ACEITA;
                    
                    $hist = new HistoricoPontoXP();
                    $hist->id_user = $user->id;
                    $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
                    $hist->dt_transacao = date('Y-m-d');
                    $hist->ds_transacao = 'Bônus Diário de 5 pontos por oferta aceita';
                    $hist->vl_transacao = $this::PONTOS_OFERTA_ACEITA;
                    $hist->save();
                }
                
                // Faz Crédito do Bonus Jogo do Brasil
                if ($id_brasil){
                    echo 'Usuario '.$user->name.' credito '.$total_pontos.' por ser dia de jogo do Brasil '.PHP_EOL;
                    
                    $user->qt_pontos_xp += $total_pontos;
                    $user->save();
                    
                    $hist = new HistoricoPontoXP();
                    $hist->id_user = $user->id;
                    $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
                    $hist->dt_transacao = date('Y-m-d');
                    $hist->ds_transacao = 'Bônus Especial Jogo do Brasil - DOBRA SUAS BROTHETAS DIÁRIAS';
                    $hist->vl_transacao = $total_pontos;
                    $hist->save();
                }
            }            
        }
        
        DB::commit();
    }
}
