<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestaEGEG extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testa:egeg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa EGEG';

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
    	
    	$client = new \GuzzleHttp\Client();
    	$res = $client->get('http://159.203.116.176/api/login?email=servicos@espacogourmet.online&password=EGEG2_2017!');
    	echo $res->getStatusCode(); // 200
    	echo $res->getBody(); 
    	
    	
    	
 		/*   	
    	$token = $response->body->token;
    	
    	$cd_escola = 1;
    	$dt_inicio = date('d/m/Y');
    	$tp_curso = 'R';
    	
    	$uri = 'http://159.203.116.176/api/recuperaCursosTipoList?cdEscola='.$cd_escola.'&tpCurso='.$tp_curso.'&dtInicio='.$dt_inicio;
    	echo $uri.'&token='.$token.'<BR>';
    	
    	$response = \Httpful\Request::get($uri.'&token='.$token)
    	->sendsXml()
    	->send();
    	
    	$cdRetorno = isset($response->body->cd_retorno)?$response->body->cd_retorno:0;
    	$dsRetorno = isset($response->body->ds_retorno)?$response->body->ds_retorno:'';
    	
    	echo 'Retorno'.$cdRetorno.'/'.utf8_decode($dsRetorno).'<BR>';
    	if ($cdRetorno == 0){
    		echo 'Quantidade de Cursos:'.$response->body->qt_registros.'<BR>';
    	}
    	if (isset($response->body->cursos)){
    		$cursos = $response->body->cursos;
    		foreach($cursos as $curso){
    			echo 'Codigo:'.$curso->cd_curso.' Nome:'.utf8_decode($curso->nm_curso).'-'.
      			$curso->ds_tipo.
      			'cd_modulo_chef:'.$curso->cd_modulo_chef.' de '.$curso->dt_inicio.' a '.$curso->dt_fim.
      			'periodicidade:'.$curso->ds_periodicidade.
      			' escola:'.$curso->cd_escola.'/'.$curso->ds_cescola.' Vaga:'.
      			$curso->nr_vagas.', Matriculados: '.$curso->nr_matriculados.'. Desc. Resumida:'.$curso->ds_resumida.'-'.
      			$curso->vl_matricula.
      			'2 parcelas:'.$curso->vl_2_parcelas.
      			'3 parcelas:'.$curso->vl_3_parcelas.'Condicoes:'.$curso->ds_condicoes.'.Desc:'.$curso->ds_curso.
      			' Dia Semana:'.$curso->ds_dia_semana.
      			' Turno:'.$curso->ds_turno.'Foto Mosaico:'.$curso->ds_foto_mosaico.
      			' Foto Relacionada1:'.$curso->ds_foto_relacionada1.' Relacionada2:'.
      			$curso->ds_foto_relacionada2.' Relacionada3:'.$curso->ds_foto_relacionada3.
      			'status:'.$curso->cd_status_curso.'/'.$curso->ds_status_curso.'<BR/>';
      			echo '----------------------------------------------------------<BR>';
    		}
    	}
    	*/
    }
}
