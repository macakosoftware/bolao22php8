@extends('template')

@section('titulo'){{ config('app.name') }} - Consulta de Notificação @endsection

@section('header_css') @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-bell"></i>
								Notificações 
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Consulta
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Notificações
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Consulta Notificação
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
								
								<div class="widget-box">
									<div class="widget-header widget-header-flat">
										<i class="btn btn-xs no-hover btn-{{$notificacao->ds_cor}} fa fa-{{$notificacao->ds_icon}}"></i>
										<h4 class="widget-title smaller">Notificação #{{$notificacao->id}}</h4>
									</div>

									<div class="widget-body">
										<div class="widget-main">
											<dl id="dt-list-1">
												<dt>Título</dt>
												<dd>{{$notificacao->ds_texto}}</dd>
												<dt>Mensagem</dt>
												<dd>{{$notificacao->ds_descricao}}</dd>												
											</dl>
										</div>
									</div>
								</div>
							
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')	
@endsection