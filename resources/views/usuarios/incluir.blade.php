@extends('template')

@section('titulo'){{ config('app.name') }} - Incluir Usuário @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-users"></i>
								Usuários 
								&nbsp;
								<i class="ace-icon fa fa-plus-square"></i>
								Incluir
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Incluir novo usuário
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
								<form class="form-horizontal" role="form" id="formIncluirUusario" name="formIncluirUsuario" method="POST" action="{{ route('usuario.incluir') }}">
									{{ csrf_field() }}
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="nome"> Nome </label>

										<div class="col-sm-9">
											<input type="text" name="nome" id="nome" placeholder="Nome" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="email"> Email </label>

										<div class="col-sm-9">
											<input type="text" name="email" id="email" id="email" placeholder="Email" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="password"> Senha Inicial </label>

										<div class="col-sm-9">
											<input type="password" name="password" id="password" placeholder="Senha" class="col-xs-10 col-sm-5" required/>											
										</div>
									</div>
									
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="password_confirmation"> Confirmar Senha Inicial </label>

										<div class="col-sm-9">
											<input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Senha" class="col-xs-10 col-sm-5" required/>											
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil">Perfil</label>

										<div class="col-sm-9">
										{!! Form::select('cd_perfil', $tb_perfis, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
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
@endsection