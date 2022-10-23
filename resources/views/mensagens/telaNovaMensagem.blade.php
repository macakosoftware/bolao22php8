@extends('template')

@section('titulo'){{ config('app.name') }} - Enviar Mensagem @endsection

@section('header_css')
<link rel="stylesheet" href="{{asset('assets/css/chosen.min.css')}}" /> 
@endsection

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
								Nova
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Mensagens
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Criar Nova Mensagen
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
							
							@if (session('erro'))
                            	<div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>                                        
                                        <li>
										<i class="ace-icon fa fa-check-square"></i>									                                            
                                        {{ session('erro') }}</li>
                                    </ul>
								</div>
        					@endif
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" id="formMensagem" name="formMensagem" method="POST" action="{{ route('mensagens.enviar') }}">
									{{ csrf_field() }}
									{{ Form::hidden('ds_mensagem', '', array('id'=>'ds_mensagem')) }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="vl_saldo"> Para </label>

										<div class="col-sm-9">
										{!! Form::select('tb_destinatarios[]', $tb_usuarios, 0, $attributes = ['class'=>'chosen-select form-control', 'tabindex'=>'-1', 'multiple' => '', 'data-placeholder' => 'Selecione Destinatário', 'id'=>'form-field-select-4']) !!}	
										</div>
									</div>

									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_titulo"> Título </label>

										<div class="col-sm-9">
											<input type="text" name="ds_titulo" id="ds_titulo" placeholder="Título" class="col-xs-10 col-sm-12" value="{{old('ds_titulo')}}" required/>
										</div>
									</div>
									
									<div class="space-4"></div>
									
									<div class="wysiwyg-editor" id="editor1"></div>
									
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="bt_enviar" id="bt_enviar">
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
<script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
<script>
if(!ace.vars['touch']) {
	$('.chosen-select').chosen({allow_single_deselect:true}); 
	//resize the chosen on window resize

	$(window)
	.off('resize.chosen')
	.on('resize.chosen', function() {
		$('.chosen-select').each(function() {
			 var $this = $(this);
			 $this.next().css({'width': $this.parent().width()});
		})
	}).trigger('resize.chosen');
	//resize chosen on sidebar collapse/expand
	$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
		if(event_name != 'sidebar_collapsed') return;
		$('.chosen-select').each(function() {
			 var $this = $(this);
			 $this.next().css({'width': $this.parent().width()});
		})
	});


	$('#chosen-multiple-style .btn').on('click', function(e){
		var target = $(this).find('input[type=radio]');
		var which = parseInt(target.val());
		if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
		 else $('#form-field-select-4').removeClass('tag-input-style');
	});
}
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