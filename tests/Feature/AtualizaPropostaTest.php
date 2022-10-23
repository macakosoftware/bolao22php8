<?php

namespace Tests\Feature;

use App\Funcoes\AtualizaProposta;
use App\Models\TransacaoProposta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtualizaPropostaTest extends TestCase
{
    public function test_atualiza_proposta_que_nao_existe()
    {
        $atualiza = new AtualizaProposta(99999999, "");
        $resultado = $atualiza->atualizar();

        $this->assertFalse($resultado);
        $this->assertEquals($atualiza->ds_mensagem, 'Oferta Não Localizada!');
    }

    public function test_aceita_proposta_e_nao_tem_saldo()
    {
        $stub_oferta = $this->criaStubOferta(20, AtualizaProposta::ACAO_ACEITAR);
        $retorno = $stub_oferta->atualizar();

        $this->assertFalse($retorno);
        $this->assertEquals($stub_oferta->ds_mensagem, 'Usuário não possui saldo suficiente para pagar essa oferta!');
    }

    public function test_aceita_proposta_e_tem_saldo()
    {
        $stub_oferta = $this->criaStubOferta(9, AtualizaProposta::ACAO_ACEITAR);
        $retorno = $stub_oferta->atualizar();

        $this->assertTrue($retorno);
        $this->assertEquals($stub_oferta->ds_mensagem, 'Oferta Aceita com Sucesso!');
    }

    public function test_rejeita_proposta()
    {
        $stub_oferta = $this->criaStubOferta(9, AtualizaProposta::ACAO_REJEITAR);
        $retorno = $stub_oferta->atualizar();

        $this->assertTrue($retorno);
        $this->assertEquals($stub_oferta->ds_mensagem, 'Oferta Rejeitada com Sucesso!');
    }

    private function criaStubOferta($vl_proposta, $acao){
        $stub_oferta = $this->getMockBuilder(AtualizaProposta::class)
                       ->setMethods(array('getOferta','atualizaPropostaAceita', 'atualizaPropostaRejeitada'))                       
                       ->setConstructorArgs(array(999999,$acao))
                       ->getMock();        
        $stub_oferta->expects($this->any())
                    ->method('getOferta')
                    ->will($this->returnValue($this->criaOferta($vl_proposta)));
        $stub_oferta->expects($this->any())
                    ->method('atualizaPropostaAceita')
                    ->will($this->returnValue(true));
        $stub_oferta->expects($this->any())
                    ->method('atualizaPropostaRejeitada')
                    ->will($this->returnValue(true));

        return $stub_oferta;
    }

    private function criaOferta($vl_proposta){
        $transacao = new TransacaoProposta();
        $transacao->vl_proposta = $vl_proposta;
        $transacao->usuarioProposta = $this->criaUsuario();

        return $transacao;
    }

    private function criaUsuario(){
        $usuario = new User();
        $usuario->name = "Teste";
        $usuario->qt_pontos_xp = 10;

        return $usuario;
    }
}