@extends('template')

@section('titulo'){{ config('app.name') }} - Criar Notificação @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-users"></i>
								Usuários 
								&nbsp;
								<i class="ace-icon fa fa-bell"></i>
								Notificação
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Criar Nova Notificação Simples
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
								<form class="form-horizontal" role="form" id="formNotificacao" name="formNotificacao" method="POST" action="{{ route('usuario.criarNotificacao') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_titulo"> Título </label>

										<div class="col-sm-9">
											<input type="text" name="ds_titulo" id="ds_titulo" placeholder="Título" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="ds_icone"> Ícone </label>

										<div class="col-sm-9">
										{!! Form::select('ds_icone', $tb_icones, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ds_mensagem"> Mensagem </label>
										
										<div class="col-sm-9">
											<textarea class="form-control limited" id="ds_mensagem" name="ds_mensagem" maxlength="250" rows="6"></textarea>
										</div>
									</div>
									
									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="id_notificacao"> Enviar Email? </label>
										
										<div class="col-sm-9">
											<label>
												<input name="id_email" id="id_email" class="ace ace-switch ace-switch-6" type="checkbox" />
												<span class="lbl"></span>
											</label>
										</div>
									</div>
			
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Incluir
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
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
<script src="{{ asset('assets/js/jquery.inputlimiter.min.js') }}"></script>
<script>
$('textarea.limited').inputlimiter({
	remText: '%n caractere%s restante...',
	limitText: 'máximo permitido : %n.'
});
</script>
@endsection