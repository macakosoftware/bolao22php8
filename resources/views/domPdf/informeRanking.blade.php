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
 background-image: url({{asset('images/background_folha_caderno4.jpg')}});
 background-position: top left;
 background-repeat: no-repeat;
 background-size: 80%;
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
<table border=0 width="100%">
<tr>
	<td width="20%"><img src="{{asset('assets/images/copa_brothers_18_logo.png')}}" width="86" height="118"/></td>
	<td width="80%">
		<h1>{{config('app.name')}}</h1>
		<i>Informe de Rankings</i>
	</td>
</tr>
</table>
@foreach($rankings as $ranking)
<h2>{{$ranking['ds_nome']}}</h2>
@if($ranking['tem_ranking'])
<table border="0" width="100%">
    <tr>
    	<th width="5%">#</th>
    	<th width="35%">Nome</th>
    	<th width="10%">Apostas</th>
    	<th width="10%">Pontos</th>
    	<th width="10%">Qt.Resultados</th>
    	<th width="10%">Qt.Pl.Cheio</th>
    	<th width="10%">Qt.Pl.Parcial</th>
    	<th width="10%">Maior Pontuação</th>
    </tr>
    @foreach($ranking['tb_usuarios'] as $usuario)
    <tr>
    	<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['nr_posicao']}}</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>
		<div class="table">
  			<div>
  			@if (\App\Funcoes\VerificaAvatar::verificar($usuario['id_user']))
			<img width="25px" height="25px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$usuario['id_user']))}}" alt="Photo" />
			@else
			<img width="25px" height="25px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />
			@endif
  			</div>
  			<div>
  			{{$usuario['ds_nome']}}&nbsp;  			 
  			@if ($usuario['id_sobe'])
			<span style="font-family: DejaVu Sans, sans-serif;color: green;">&uarr; {{$usuario['dif']}}</span>			
			@elseif ($usuario['id_desce'])
			<span style="font-family: DejaVu Sans, sans-serif;color: red;">&darr; {{$usuario['dif']}}</span>						
			@endif
  			</div>
		</div>
		</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['qt_apostas']}}</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['qt_pontos']}}</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['qt_acertos_resultado']}}</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['qt_acertos_cheio']}}</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['qt_acertos_parcial']}}</td>
		<td @if($usuario['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$usuario['qt_pontos_maior']}}</td>
    </tr>
    @endforeach
</table>
@else
<p>Ranking ainda não gerado!</p>
@endif
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