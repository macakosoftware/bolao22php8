@extends('template')

@section('titulo'){{ config('app.name') }} - Visualizar Mensagem @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-envelope"></i>
								Mensagens 
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Visualizar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Mensagens
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Visualizar Mensagem Recebida
								</small>
							</h1>
						</div><!-- /.page-header -->
						
						<div class="row">

                            @if ($errors->any())                              
                                <div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>
                                        @foreach ($errors->all() as $error)
                                            <li>
											<i class="ace-icon fa fa-exclamation-circle"></i>									                                            
                                            {{ $error }}</li>
                                        @endforeach
                                    </ul>
								</div>
                            @endif
							
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" id="formMensagem" name="formMensagem" method="GET" action="{{ route('mensagens.tratarMensagem') }}">
									{{ csrf_field() }}
									<input type="hidden" name="id_mensagem" id="id_mensagem" value="{{$mensagem->id}}"/>
									
									<h3>De:</h3>
									<p class="lead">{{$mensagem->usuarioDe->name}}
									
									<h3>Para:</h3>
									<p class="lead">
									@foreach($mensagem->destinatarios as $destinatario)
									{{$destinatario->usuarioPara->name}}<br/>
									@endforeach
									</p>
									
									<h3>Título:</h3>
									<p class="lead">{{$mensagem->ds_titulo}}</p>
									
									<h3>Mensagem de {{$mensagem->usuarioDe->name}} em {{\Carbon\Carbon::parse($mensagem->created_at)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($mensagem->created_at)->format('H:i:s')}}:</h3>									
									<p>
									{!!$mensagem->ds_mensagem!!}
									</p>
									
									@if (isset($relacionadas))									
									@if (count($relacionadas) > 0)
										@foreach($relacionadas as $relacionada)
										<h4>&nbsp;&nbsp;Mensagem de {{$relacionada->usuarioDe->name}} em {{\Carbon\Carbon::parse($relacionada->created_at)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($relacionada->created_at)->format('H:i:s')}}</h4>									
										<p>&nbsp;&nbsp;<i>
										{!!$relacionada->ds_mensagem!!}
										</i></p>
										@endforeach
									@endif
									@endif
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" id="bt_responder" name="submit" value="{{App\Http\Controllers\Mensagens\MensagensController::BOTAO_RESPONDER}}">
												<i class="ace-icon fa fa-reply bigger-110"></i>
												Responder
											</button>
											&nbsp;&nbsp;
											<button class="btn btn-danger" type="submit" id="bt_deletar" name="submit" value="{{App\Http\Controllers\Mensagens\MensagensController::BOTAO_APAGAR}}">
												<i class="ace-icon fa fa-trash"></i>
												Apagar
											</button>
										</div>
									</div>
									
									</form>
								</div>
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
<script src="{{ asset('assets/js/bootbox.js') }}"></script>
<script type="text/javascript">
$(window).on('load',function() {	
    $("#bt_deletar").click(function(e) {
    	e.preventDefault();
        var msg = 'Confirma a Deleção da Mensagem ?';
        bootbox.confirm(msg, function(result) {
            if (result) {
                window.location = "{{url('mensagens/tratarMensagem')}}?_token="+$('input[name=_token]').val()+"&id_mensagem="+$('#id_mensagem').val()+"&submit="+$('#bt_deletar').val();
            }
        });
    });
});
</script>
@endsection