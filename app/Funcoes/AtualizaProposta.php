<?php

namespace App\Funcoes;

use App\Models\TransacaoProposta;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoricoPontoXP;
use App\Models\PropostaJogador;
use App\Models\JogadorUsuario;
use App\Models\TransacaoFigurinha;
use Illuminate\Support\Facades\DB;
use App\Models\NotificacaoAlbum;
use App\Models\User;

class AtualizaProposta
{
    public const ACAO_ACEITAR = "aceitar";
    public const ACAO_REJEITAR = "rejeitar";
    
    public $id_oferta;
    public $acao;
    public $ds_mensagem;
    
    
    public function __construct($id_oferta, $acao)
    {
        $this->id_oferta = $id_oferta;
        $this->acao = $acao;
    }
    
    public function atualizar(){
        
        $oferta = $this->getOferta();
        
        if ($oferta == null){
            $this->ds_mensagem = 'Oferta Não Localizada!';
            return false;
        }
        
        DB::beginTransaction();
        
        if ($this->acao == $this::ACAO_ACEITAR){
            
            $userDebito = $oferta->usuarioProposta;
            
            if ($userDebito->qt_pontos_xp < $oferta->vl_proposta){
                $this->ds_mensagem = 'Usuário não possui saldo suficiente para pagar essa oferta!';
                DB::rollBack();
                return false;
            }
            
            $this->atualizaPropostaAceita($userDebito, $oferta);
            
            $this->ds_mensagem = 'Oferta Aceita com Sucesso!';

        }
        else if ($this->acao == $this::ACAO_REJEITAR){
            
            $this->atualizaPropostaRejeitada($oferta);

            $this->ds_mensagem = 'Oferta Rejeitada com Sucesso!';
        }
        
        DB::commit();
        
        return true;
    }

    public function getOferta(){
        return TransacaoProposta::where('id',$this->id_oferta)
                  ->with('transacao')
                  ->first();
    }

    public function atualizaPropostaAceita(User $userDebito, TransacaoProposta $oferta){
        if ($oferta->vl_proposta > 0){
            // Debita de Quem fez a Oferta
            $userDebito->qt_pontos_xp = $userDebito->qt_pontos_xp - $oferta->vl_proposta;
            $userDebito->save();
            
            // Historico Debito
            $hist = new HistoricoPontoXP();
            $hist->id_user = $userDebito->id;
            $hist->tp_transacao = HistoricoPontoXP::TIPO_SAIDA;
            $hist->ds_transacao = 'Débito pontos oferta '.$oferta->id.' em '.date('d/m/Y').' as '.date('H:i:s').' ';
            $hist->vl_transacao = $oferta->vl_proposta;
            $hist->dt_transacao = date('Y-m-d');
            $hist->save();
            
            // Credita para quem fez a Proposta
            $userCredito = Auth::user();
            $userCredito->qt_pontos_xp = $userCredito->qt_pontos_xp + $oferta->vl_proposta;
            $userCredito->save();
            
            // Historico Credito                
            $hist = new HistoricoPontoXP();
            $hist->id_user = $userCredito->id;
            $hist->tp_transacao = HistoricoPontoXP::TIPO_ENTRADA;
            $hist->ds_transacao = 'Crédito pontos oferta '.$oferta->id.' em '.date('d/m/Y').' as '.date('H:i:s').' ';
            $hist->vl_transacao = $oferta->vl_proposta;
            $hist->dt_transacao = date('Y-m-d');
            $hist->save();
        }
        
        // Atualiza o Jogador da Oferta para o Dono da Proposta - VINDO
        $jogadores = PropostaJogador::where('id_proposta',$this->id_oferta)->get();
        if (count($jogadores) > 0){
            foreach($jogadores as $jogador){                
                $jogVindo = JogadorUsuario::where('id_user',$oferta->id_user_proposta)
                ->where('id_jogador',$jogador->id_jogador)
                ->first();
                $jogVindo->id_user = $oferta->transacao->id_user;
                $jogVindo->save();
            }
        }
        
        // Atualiza o Jogador da Proposta para o ofertante - INDO
        $jogIndo = JogadorUsuario::where('id_user',$oferta->transacao->id_user)
        ->where('id_jogador',$oferta->transacao->id_jogador)
        ->first();
        $jogIndo->id_user = $oferta->id_user_proposta;
        $jogIndo->save();
        
        // Atualiza Status da Proposta para Aceita
        $oferta->cd_status = TransacaoProposta::STATUS_ACEITA;
        $oferta->save();
        
        // Baixa Notificacao Enviada
        $notifacacaoEnviada = NotificacaoAlbum::where('id_proposta',$oferta->id)->first();
        if ($notifacacaoEnviada != null){
            $notifacacaoEnviada->id_lido = true;
            $notifacacaoEnviada->save();
        }
        
        // Cria Notificação de Oferta Aceita
        $notificacao = new NotificacaoAlbum();
        $notificacao->id_user = $oferta->id_user_proposta;
        $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
        $notificacao->id_transacao = $oferta->transacao->id;
        $notificacao->id_proposta = $oferta->id;
        $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_APROVADO;
        $notificacao->id_user_from = $oferta->transacao->id_user;
        $notificacao->id_lido = false;
        $notificacao->ds_observacao = 'Oferta ACEITA por '.$oferta->transacao->jogador->ds_nome.' de '.$oferta->transacao->jogador->selecao->ds_nome;
        $notificacao->save();
        
        // Baixa todas as outras ofertas dessa proposta que estiverem abertas
        $outrasOfertas = TransacaoProposta::where('id_transacao',$oferta->id_transacao)
        ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
        ->with('transacao')
        ->get();
        if (count($outrasOfertas) > 0){
            foreach($outrasOfertas as $outra){
                $outra->cd_status = TransacaoProposta::STATUS_REJEITADA;
                $outra->save();
                
                $notificacao = new NotificacaoAlbum();
                $notificacao->id_user = $outra->id_user_proposta;
                $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
                $notificacao->id_transacao = $outra->transacao->id;
                $notificacao->id_proposta = $outra->id;
                $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_REJEITADO;
                $notificacao->id_user_from = $outra->transacao->id_user;
                $notificacao->id_lido = false;
                $notificacao->ds_observacao = 'Oferta REJEITADA por '.$outra->transacao->jogador->ds_nome.' de '.$outra->transacao->jogador->selecao->ds_nome;
                $notificacao->save();
            }
        }
            
        // Atualiza Status da Proposta para Fechada
        $transacao = TransacaoFigurinha::where('id',$oferta->transacao->id)->first();
        $transacao->cd_status = TransacaoFigurinha::STATUS_FECHADA;
        $transacao->save();
        
        // Verifica se a Figurinha do Ofertante está em Outras Transações
        $jogadores = PropostaJogador::where('id_proposta',$this->id_oferta)->get();
        if (count($jogadores) > 0){
            foreach($jogadores as $jogador){   
                $id_jogador = $jogador->id_jogador;
                
                // Verifica se Ofertante tem a Figurinha em outras ofertas abertas e cancela
                $ofertasEnviadas = TransacaoProposta::where('id_user_proposta',$oferta->id_user_proposta)
                ->where('id','<>',$oferta->id)
                ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)                    
                ->whereHas('jogadoresTroca',function ($q) use($id_jogador){
                    $q->where('id_jogador',$id_jogador);
                })
                ->get();
                                    
                if (count($ofertasEnviadas) > 0){
                    foreach($ofertasEnviadas as $enviada){
                        $enviada->cd_status = TransacaoProposta::STATUS_CANCELADA;
                        $enviada->ds_resposta = 'Transação Cancelada pois figurinha foi utilizada na oferta '.$oferta->id.' ';
                        $enviada->save();
                        
                        $notificacao = new NotificacaoAlbum();
                        $notificacao->id_user = $enviada->id_user_proposta;
                        $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
                        $notificacao->id_transacao = $enviada->transacao->id;
                        $notificacao->id_proposta = $enviada->id;
                        $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_CANCELADO;
                        $notificacao->id_user_from = $enviada->transacao->id_user;
                        $notificacao->id_lido = false;
                        $notificacao->ds_observacao = 'Oferta CANCELADA por '.$enviada->transacao->jogador->ds_nome.' de '.$enviada->transacao->jogador->selecao->ds_nome;
                        $notificacao->save();
                    }
                }
        
                // Verifica se Ofertante tem a Figurinha em Proposta Aberta e baixa
                $propostas = TransacaoFigurinha::where('id_user',$oferta->id_user_proposta)
                ->where('id_jogador',$id_jogador)
                ->where('cd_status',TransacaoFigurinha::STATUS_ABERTA)
                ->get();
                if (count($propostas) > 0){
                    foreach($propostas as $proposta){
                        // Recupera as Ofertas Abertas e Cancela
                        $ofertasAbertas = TransacaoProposta::where('id_transacao',$proposta->id)
                        ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
                        ->get();
                        if (count($ofertasAbertas) > 0){
                            foreach($ofertasAbertas as $aberta){
                                $aberta->cd_status = TransacaoProposta::STATUS_CANCELADA;
                                $aberta->ds_resposta = 'Cancelada pois proposta foi fechada. Figurinha já foi trocada!';
                                $aberta->save();
                                
                                $notificacao = new NotificacaoAlbum();
                                $notificacao->id_user = $aberta->id_user_proposta;
                                $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
                                $notificacao->id_transacao = $aberta->transacao->id;
                                $notificacao->id_proposta = $aberta->id;
                                $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_CANCELADO;
                                $notificacao->id_user_from = $aberta->transacao->id_user;
                                $notificacao->id_lido = false;
                                $notificacao->ds_observacao = 'Oferta CANCELADA por '.$aberta->transacao->jogador->ds_nome.' de '.$aberta->transacao->jogador->selecao->ds_nome;
                                $notificacao->save();
                            }
                        }
                        
                        $proposta->cd_status = TransacaoFigurinha::STATUS_FECHADA;
                        $proposta->save();
                    }
                }
                
                // Verifica se Figurinha da Proposta está em outras ofertas abertas
                $id_jogador = $oferta->transacao->id_jogador;
                $ofertasAbertas = TransacaoProposta::where('id_user_proposta',$oferta->transacao->id_user)
                ->where('cd_status',TransacaoProposta::STATUS_ENVIADA)
                ->whereHas('jogadoresTroca',function($q) use($id_jogador){
                    $q->where('id_jogador',$id_jogador);
                })
                ->get();
                if (count($ofertasAbertas) > 0){
                    foreach($ofertasAbertas as $aberta){
                        $aberta->cd_status = TransacaoProposta::STATUS_CANCELADA;
                        $aberta->ds_resposta = 'Oferta Cancelada. Ofertante já trocou a figurinha';
                        $aberta->save();
                        
                        // Cria Notificação de Oferta Aceita
                        $notificacao = new NotificacaoAlbum();
                        $notificacao->id_user = $aberta->id_user_proposta;
                        $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
                        $notificacao->id_transacao = $aberta->transacao->id;
                        $notificacao->id_proposta = $aberta->id;
                        $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_CANCELADO;
                        $notificacao->id_user_from = $aberta->transacao->id_user;
                        $notificacao->id_lido = false;
                        $notificacao->ds_observacao = 'Oferta CANCELADA por '.$aberta->transacao->jogador->ds_nome.' de '.$aberta->transacao->jogador->selecao->ds_nome;
                        $notificacao->save();
                    }
                }
            }
        }
    }

    public function atualizaPropostaRejeitada(TransacaoProposta $oferta){
        $oferta->cd_status = TransacaoProposta::STATUS_REJEITADA;
        $oferta->save();
        
        // Baixa Notificacao Enviada
        $notifacacaoEnviada = NotificacaoAlbum::where('id_proposta',$oferta->id)->first();
        if ($notifacacaoEnviada != null){
            $notifacacaoEnviada->id_lido = true;
            $notifacacaoEnviada->save();
        }
                    
        $notificacao = new NotificacaoAlbum();
        $notificacao->id_user = $oferta->id_user_proposta;
        $notificacao->tp_notificacao = NotificacaoAlbum::TIPO_NOTIFICACAO_OFERTA;
        $notificacao->id_transacao = $oferta->transacao->id;
        $notificacao->id_proposta = $oferta->id;
        $notificacao->tp_resposta = NotificacaoAlbum::TIPO_RESPOSTA_REJEITADO;
        $notificacao->id_user_from = $oferta->transacao->id_user;
        $notificacao->id_lido = false;
        $notificacao->ds_observacao = 'Oferta REJEITADA por '.$oferta->transacao->jogador->ds_nome.' de '.$oferta->transacao->jogador->selecao->ds_nome;
        $notificacao->save();
    }
}
