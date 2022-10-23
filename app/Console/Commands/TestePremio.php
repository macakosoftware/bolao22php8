<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Premio;
use App\Events\PremioPagoEvent;

class TestePremio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'premio:testar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste Gerar Premio PDF';

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
        /*
        $premio = Premio::where('cd_ranking',1)
                  ->where('id_user',1)
                  ->first();
        
        $gerador = new GeraChequePremio($premio);
        $gerador->gerar(GeraChequePremio::METODO_GRAVA);
        */
        
        $premio = Premio::where('id',1)->first();
                
        event(new PremioPagoEvent($premio));
    }
}
