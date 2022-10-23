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
								<i class="ace-icon fa fa-edit"></i>
								Responder Mensagem
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Mensagens
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Responder Mensagem Recebida
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
								<form class="form-horizontal" role="form" id="formMensagem" name="formMensagem" method="POST" action="{{ route('mensagens.enviarResposta') }}">
									{{ csrf_field() }}
									<input type="hidden" name="id_mensagem" id="id_mensagem" value="{{$mensagem->id}}"/>
									<input type="hidden" name="ds_mensagem" id="ds_mensagem" value=""/>
									
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
									
									<h3>Resposta:</h3>
									<div class="wysiwyg-editor" id="editor1"></div>
									
									<h3>Mensagem em {{\Carbon\Carbon::parse($mensagem->created_at)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($mensagem->created_at)->format('H:i:s')}}:</h3>									
									<p>
									{!!$mensagem->ds_mensagem!!}
									</p>
									
									@if (isset($relacionadas))									
									@if (count($relacionadas) > 0)
										@foreach($relacionadas as $relacionada)
										<h4>&nbsp;&nbsp;Mensagem de {{$relacionada->usuarioDe->name}} em {{\Carbon\Carbon::parse($relacionada->created_at)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($relacionada->created_at)->format('H:i:s')}}:</h4>									
										<p>&nbsp;&nbsp;<i>
										{!!$relacionada->ds_mensagem!!}
										</i></p>
										@endforeach
									@endif
									@endif
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" id="bt_enviar" >
												<i class="ace-icon fa fa-check bigger-110"></i>
												Enviar
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
<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/markdown.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-markdown.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.hotkeys.index.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-wysiwyg.min.js') }}"></script>
<script>
jQuery(function($){
	$('textarea[data-provide="markdown"]').each(function(){
        var $this = $(this);

		if ($this.data('markdown')) {
		  $this.data('markdown').showEditor();
		}
		else $this.markdown()
		
		$this.parent().find('.btn').addClass('btn-white');
    })
	
  //$('#editor1').ace_wysiwyg();//this will create the default editor will all buttons

	//but we want to change a few buttons colors for the third style
	$('#editor1').ace_wysiwyg({
		toolbar:
		[
			'font',
			null,
			'fontSize',
			null,
			{name:'bold', className:'btn-info'},
			{name:'italic', className:'btn-info'},
			{name:'strikethrough', className:'btn-info'},
			{name:'underline', className:'btn-info'},
			null,
			{name:'insertunorderedlist', className:'btn-success'},
			{name:'insertorderedlist', className:'btn-success'},
			{name:'outdent', className:'btn-purple'},
			{name:'indent', className:'btn-purple'},
			null,
			{name:'justifyleft', className:'btn-primary'},
			{name:'justifycenter', className:'btn-primary'},
			{name:'justifyright', className:'btn-primary'},
			{name:'justifyfull', className:'btn-inverse'},
			null,
			{name:'createLink', className:'btn-pink'},
			{name:'unlink', className:'btn-pink'},
			null,
			null,
			null,
			'foreColor',
			null,
			{name:'undo', className:'btn-grey'},
			{name:'redo', className:'btn-grey'}
		]		
	}).prev().addClass('wysiwyg-style2');

	$('#bt_enviar').on('click',function(){        

	    $('#ds_mensagem').val($('#editor1').html());

	})
});
</script>
@endsection