<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AvisoAposta;
use App\Models\User;
use App\Models\Aposta;
use App\Models\Jogo;
use App\Models\StatusJogo;

class LembreteAposta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apostas:lembrete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera Aviso que Aposta Não Foi Feita!';

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
        echo 'Inicializa Processo de Lembrete de Apostas '.PHP_EOL;
        
        $corrente = new \DateTime();
        
        $teste_24_horas = 60 * 24;
        $teste_48_horas = 60 * 48;
        $teste_72_horas = 60 * 72;
                
        $jogos = Jogo::where('cd_status',StatusJogo::JOGO_PROGRAMADO)
                 ->orderBy('dt_jogo')
                 ->orderBy('hr_jogo')
                 ->get();
        foreach($jogos as $jogo){
            $dt_hr_jogo = $corrente->diff(new \DateTime($jogo->dt_jogo.' '.$jogo->hr_jogo));
            $minutes =  $dt_hr_jogo->days * 24 * 60;
            $minutes += $dt_hr_jogo->h * 60;
            $minutes += $dt_hr_jogo->i;
            
            $usuarios = User::all();
            foreach($usuarios as $usuario){
                $aposta = Aposta::where('id_jogo',$jogo->id)
                          ->where('id_user',$usuario->id)
                          ->first();
                if ($aposta == null){
                    if ($minutes <= $teste_72_horas && $minutes > $teste_48_horas){
                        $avisoAux = AvisoAposta::where('id_jogo',$jogo->id)
                                 ->where('id_user',$usuario->id)
                                 ->first();
                        if ($avisoAux == null){
                            $aviso = new AvisoAposta();
                            $aviso->id_user = $usuario->id;
                            $aviso->id_jogo = $jogo->id;
                            $aviso->tp_aviso = AvisoAposta::TIPO_AVISO_72;
                            $aviso->id_enviado = false;
                            $aviso->save();
                            echo 'Gravando Lembrete 72 Horas para'.$usuario->name.' '.PHP_EOL;
                        }
                    }
                    if ($minutes <= $teste_48_horas && $minutes > $teste_24_horas ){
                        $avisoAux = AvisoAposta::where('id_jogo',$jogo->id)
                                 ->where('id_user',$usuario->id)
                                 ->first();
                        if ($avisoAux == null){
                            $aviso = new AvisoAposta();
                            $aviso->id_user = $usuario->id;
                            $aviso->id_jogo = $jogo->id;
                            $aviso->tp_aviso = AvisoAposta::TIPO_AVISO_48;
                            $aviso->id_enviado = false;
                            $aviso->save();
                            echo 'Gravando Lembrete 48 Horas para'.$usuario->name.' '.PHP_EOL;
                        }
                    }
                    if ($minutes <= $teste_24_horas){
                        $avisoAux = AvisoAposta::where('id_jogo',$jogo->id)
                                 ->where('id_user',$usuario->id)
                                 ->first();
                        if ($avisoAux == null){
                            $aviso = new AvisoAposta();
                            $aviso->id_user = $usuario->id;
                            $aviso->id_jogo = $jogo->id;
                            $aviso->tp_aviso = AvisoAposta::TIPO_AVISO_24;
                            $aviso->id_enviado = false;
                            $aviso->save();
                            echo 'Gravando Lembrete 24 Horas para'.$usuario->name.' '.PHP_EOL;
                        }
                    }
                }
            }
        }
        
        echo 'Finalizacao Lembrete de Apostas '.PHP_EOL;
    }
}
