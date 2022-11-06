<?php

namespace App\Console;

use App\Console\Commands\ApagaNotificacaoAlbum;
use App\Console\Commands\CreditaPontosXPDiario;
use App\Console\Commands\EnviaAvisoAposta;
use App\Console\Commands\LembreteAposta;
use App\Console\Commands\TravaJogo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        CreditaPontosXPDiario::class,
        TravaJogo::class,
        LembreteAposta::class,
        EnviaAvisoAposta::class,
        ApagaNotificacaoAlbum::class
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        //$schedule->command('pontosxp:creditodiario')->dailyAt('06:00')->appendOutputTo(env('ARQ_LOG','/var/log/bolao18.log'));
        $schedule->command('pontosxp:creditodiario')->everyMinute()->appendOutputTo(env('ARQ_LOG','/var/log/bolao18.log'));
        $schedule->command('jogos:travajogo')->everyFifteenMinutes()->appendOutputTo('/var/log/cron_trava_jogo.log');
        $schedule->command('apostas:lembrete')->everyFifteenMinutes();
        $schedule->command('apostas:enviarAviso')->everyFifteenMinutes();
        $schedule->command('figurinhas:apagarNotificacao')->everyMinute()->appendOutputTo('/var/log/cron_notificacao.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
