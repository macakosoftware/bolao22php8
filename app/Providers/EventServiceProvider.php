<?php

namespace App\Providers;

use App\Events\ApostaAtualizadaEvent;
use App\Events\JoiaPagaEvent;
use App\Events\NotificacaoSimplesEvent;
use App\Events\NovoJogoEvent;
use App\Events\ResultadoAtualizadoEvent;
use App\Events\TipoRankingFechadoEvent;
use App\Events\UsuarioIncluidoEvent;
use App\Events\PremioPagoEvent;
use App\Listeners\AtualizaLoginListener;
use App\Listeners\AtualizaRankingListener;
use App\Listeners\CreditaPontosXPPagamentoListener;
use App\Listeners\EnviaEmailApostasEditadasListener;
use App\Listeners\EnviaEmailBoasVindasListener;
use App\Listeners\EnviaEmailCertificadoListener;
use App\Listeners\EnviaEmailFechamentoRankingListener;
use App\Listeners\EnviaEmailInformeRankingListener;
use App\Listeners\EnviaEmailNotificacaoSimplesListener;
use App\Listeners\EnviaEmailNovosJogosListener;
use App\Listeners\EnviaEmailPremioListener;
use App\Listeners\EnviaEmailReciboListener;
use App\Listeners\GeraTrofeuListener;
use App\Listeners\NotificaTelegramApostaEditadaListener;
use App\Listeners\NotificaTelegramJoiaPagaListener;
use App\Listeners\NotificaTelegramNovoJogoListener;
use App\Listeners\NotificaTelegramResultadoListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ResultadoAtualizadoEvent::class => [
            AtualizaRankingListener::class,
            NotificaTelegramResultadoListener::class,
            EnviaEmailInformeRankingListener::class
        ],
        UsuarioIncluidoEvent::class => [
            EnviaEmailBoasVindasListener::class
        ],
        ApostaAtualizadaEvent::class => [
            EnviaEmailApostasEditadasListener::class,
            NotificaTelegramApostaEditadaListener::class
        ],
        NovoJogoEvent::class => [
            NotificaTelegramNovoJogoListener::class,
            EnviaEmailNovosJogosListener::class
        ],
        JoiaPagaEvent::class => [
            EnviaEmailReciboListener::class,
            NotificaTelegramJoiaPagaListener::class,
            CreditaPontosXPPagamentoListener::class
        ],
        TipoRankingFechadoEvent::class => [
            EnviaEmailFechamentoRankingListener::class,
            EnviaEmailCertificadoListener::class,
            GeraTrofeuListener::class
        ],
        NotificacaoSimplesEvent::class => [
            EnviaEmailNotificacaoSimplesListener::class
        ],
        PremioPagoEvent::class => [
            EnviaEmailPremioListener::class
        ],
        Login::class => [
            AtualizaLoginListener::class
        ]
    ];   
    
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
