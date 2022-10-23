<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Funcoes\CalculaResultado;
use App\Funcoes\PontuacaoUsuario;
use App\Models\Aposta;
use App\Funcoes\HandicapGol;

class TesteFuncao extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'funcoes:teste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar Funcoes';

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
        $id_aposta = 316;
        
        $calcular = new CalculaResultado();
        $calcular->calcular($id_aposta);
        
        echo $calcular->qt_pontos_total.'<-- pontos total'.PHP_EOL;
        echo $calcular->qt_pontos_resultado.' <-- pontos resultado<'.PHP_EOL;
        echo $calcular->qt_pontos_placar_cheio.' <-- pontos placar cheio '.PHP_EOL;
        echo $calcular->qt_pontos_placar_parcial.' <-- pontos placar parcial '.PHP_EOL;
        echo $calcular->id_resultado.' <-- id resultado '.PHP_EOL;
        echo $calcular->id_placar_cheio.' <- id placar cheio '.PHP_EOL;
        echo $calcular->id_placar_parcial.'<-- id placar parcial '.PHP_EOL;
        echo '---------------------------'.PHP_EOL;
        
        $pontuacao = new PontuacaoUsuario();
        $pontuacao->calcularProgramadoJogo($id_aposta);
        
        echo $pontuacao->qt_pontos_maximo.PHP_EOL;
        echo $pontuacao->qt_pontos_resultado.PHP_EOL;
        echo $pontuacao->qt_pontos_placar_cheio.PHP_EOL;
        echo $pontuacao->qt_pontos_placar_parcial1.PHP_EOL;
        echo $pontuacao->qt_pontos_placar_parcial2.PHP_EOL;
        
        $aposta = Aposta::where('id',$id_aposta)->first();
                
        $handicapGol = new HandicapGol($aposta->jogo);
        $handicapGol->calcular($aposta->jogo->id_selecao1, $aposta->jogo->id_selecao2);
        
        foreach($handicapGol->tb_placarX as $placarX){
            echo $placarX['placar'].'--->'.$placarX['pontos'].PHP_EOL;
        }
    }
}
