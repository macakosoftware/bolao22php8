<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><!-- /IE7 mode/ -->
  <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
<title>Informe Ranking - {{config('app.name')}}</title>
</head>
<style>
@page {
    size: a4;
    margin:0;padding:0;
} 
body {
 background-image: url("{{\App\Funcoes\ImagemBase64::converter('images/recibo_palpites.png')}}");
 background-position: top left;
 background-repeat: no-repeat;
 background-size: 100%;
 overflow: none;
 display: block; 
 font-family: helvetica;  
}
TH{font-family: helvetica; font-size: 8pt;}
TD{font-family: helvetica; font-size: 8pt;}
.titulo{
  font-size: 16px;
  color: #fff;
}
.rodape{
  font-size: 12px;
  color: #797b7e;
}
.titulo_chef{
  font-size: 12px;
  color: #fff;
}
.table {
  display: table;
}
.table > div {
  display: table-cell;
  vertical-align: middle;
}
</style>
<body>
<table border="0" width="100%">
<tr>
	<td width="20%"><img src="{{\App\Funcoes\ImagemBase64::converter('assets/images/copa_brothers_18_logo.png')}}" width="86" height="118"/></td>
	<td width="80%">
		<h1>{{config('app.name')}}</h1>
		<i>PALPITES ENCERRADOS</i>
	</td>
</tr>
</table>
@foreach($tb_saida as $jogo)
   <h1>{{\Carbon\Carbon::parse($jogo['jogo']->dt_jogo)->format('d/m/Y')}} - {{substr($jogo['jogo']->hr_jogo, 0, 5)}} {{$jogo['jogo']->selecao1->ds_nome}} x {{$jogo['jogo']->selecao2->ds_nome}}</h1>
   <table border="0" width="100%">
   <tr>
   <th>Usuário</th>   
   <th>Time 1</th>
   <th>Placar 1</th>
   <th>X</th>
   <th>Placar 2</th>
   <th>Time 2</th>
   <th>Resultado</th>
   <th>Placar Cheio</th>
   <th>Parcial 1</th>
   <th>Parcial 2</th>   
   <th>Penalti</th>   
   <th>Máximo</th>
   </tr>
   @foreach($jogo['tb_apostas'] as $reg_aposta)
   <tr>
   	<td>{{$reg_aposta['aposta']->usuario->name}}</td>
   	<td align="left">
   	<img src="{{ \App\Funcoes\ImagemBase64::converter('images/brasoes') }}/{{$reg_aposta['aposta']->jogo->selecao1->ds_icone}}" />
   	{{$reg_aposta['aposta']->jogo->selecao1->ds_nome}}
   	@if ($reg_aposta['aposta']->id_selecao_penal == $reg_aposta['aposta']->jogo->id_selecao1)
   	(*) Penalty
   	@endif
   	</td>
   	<td align="center">{{$reg_aposta['aposta']->qt_gols_selecao1}}</td>
   	<td align="left">X</td>
   	<td align="center">{{$reg_aposta['aposta']->qt_gols_selecao2}}</td>
   	<td align="left">
   	<img src="{{ \App\Funcoes\ImagemBase64::converter('images/brasoes') }}/{{$reg_aposta['aposta']->jogo->selecao2->ds_icone}}" />
   	{{$reg_aposta['aposta']->jogo->selecao2->ds_nome}}
   	@if ($reg_aposta['aposta']->id_selecao_penal == $reg_aposta['aposta']->jogo->id_selecao2)
   	(*) Penalty
   	@endif
   	</td>
   	<td>
   	{{number_format(floatval($reg_aposta['pontuacao']->qt_pontos_resultado),2,',','')}}
   	</td>
   	<td>
   	{{number_format(floatval($reg_aposta['pontuacao']->qt_pontos_placar_cheio),2,',','')}}
   	</td>
   	<td>
   	{{number_format(floatval($reg_aposta['pontuacao']->qt_pontos_placar_parcial1),2,',','')}}
   	</td>   	
   	<td>
   	{{number_format(floatval($reg_aposta['pontuacao']->qt_pontos_placar_parcial2),2,',','')}}
   	</td>
   	<td>
   	{{number_format(floatval($reg_aposta['pontuacao']->qt_pontos_bonus),2,',','')}}
   	</td>
   	<td>
   	{{number_format(floatval($reg_aposta['pontuacao']->qt_pontos_maximo),2,',','')}}
   	</td>
   </tr>   
   @endforeach
   </table>
@endforeach
<br/>
<br/>
<table border=0 width="100%">
<tr>
	<td width="50%">&nbsp;</td>
	<td width="50%" align="right">
		{{config('app.name')}}<br/>
		{{config('app.url')}}<br/>
		(c) Macako Software
	</td>
</tr>
</table>
</body>
</html>