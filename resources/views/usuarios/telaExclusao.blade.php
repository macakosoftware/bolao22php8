@extends('template')

@section('titulo'){{ config('app.name') }} - Excluir Usuário @endsection

@section('header_css')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
@endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-users"></i>
								Usuários 
								&nbsp;
								<i class="ace-icon fa fa-trash-o"></i>
								Exclusao
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Excluir Usuário
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
								<form class="form-horizontal" role="form" id="formExclusao" name="formExclusao" method="POST" action="{{ route('usuario.excluir') }}">
									{{ csrf_field() }}									
									{{ Form::hidden('id_user_exclusao', $usuario_exclusao->id) }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="nome"> Nome </label>

										<div class="col-sm-9">
											<input readonly type="text" name="nome" id="nome" class="col-xs-10 col-sm-5" value="{{$usuario_exclusao->name}}" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="email"> Email </label>

										<div class="col-sm-9">
											<input readonly type="text" name="email" id="email" id="email" class="col-xs-10 col-sm-5" value="{{$usuario_exclusao->email}}" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="email"> Perfil </label>

										<div class="col-sm-9">
											<input readonly type="text" name="perfil" id="perfil" id="perfil" class="col-xs-10 col-sm-5" value="{{$usuario_exclusao->perfil->ds_perfil}}" />
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Excluir
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
@endsection