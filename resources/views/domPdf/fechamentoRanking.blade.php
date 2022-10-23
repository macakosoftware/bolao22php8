<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><!-- /IE7 mode/ -->
  <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
<title>Fechamento Ranking - {{config('app.name')}}</title>
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
  font-size: 24px;
  color: #000;
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
		<div class="titulo">Fechamento do Ranking {{$tipoRanking->ds_nome}}</div>
	</td>
</tr>
</table>
<div align="center">
<h1>{{$usuario_campeao->name}}</h1>
<h2>CAMPEÃO {{$tipoRanking->ds_nome}}</h2>
</div>
<table border=0 width="100%">
<tr>
	<td width="30%"></td>
	<td width="40%" align="center">		
		<img src="{{asset('images/badges/'.$ds_badge)}}"/>
	</td>	
	<td width="30%"></td>
</tr>
</table>
<br/>
<br/>
<table border=0 width="100%">
<tr>
<td width="20%">&nbsp;</td>
<td width="80%" align="left">
	<img src="{{$ds_arq_podium}}" />
</td>
<td width="20%">&nbsp;</td>
</tr>
</table>
<div style="page-break-after: always;"></div>
<div align="center">
<h3>Classificação Final</h3>
</div>
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
    @foreach($tb_ranking as $ranking)
    <tr>
    	<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['nr_posicao']}}</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>
		<div class="table">
  			<div>
  			@if (\App\Funcoes\VerificaAvatar::verificar($ranking['id_user']))
			<img width="25px" height="25px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$ranking['id_user']))}}" alt="Photo" />
			@else
			<img width="25px" height="25px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />
			@endif
  			</div>
  			<div>
  			{{$ranking['ds_nome']}}
  			</div>
		</div>
		</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['qt_apostas']}}</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['qt_pontos']}}</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['qt_acertos_resultado']}}</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['qt_acertos_cheio']}}</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['qt_acertos_parcial']}}</td>
		<td @if($ranking['nr_posicao']%2 == 0) bgcolor="LightGray" @endif>{{$ranking['qt_pontos_maior']}}</td>
    </tr>
    @endforeach
</table>
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