<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Funcoes\GeraAlbumPDF;

class GeraAlbum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'album:gerar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar Album de Figurinhas em PDF';

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
        $gerador = new GeraAlbumPDF(1);
        $gerador->gerar($gerador::METODO_GRAVA);
    }
}
