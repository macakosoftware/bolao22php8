@extends('template')

@section('titulo'){{ config('app.name') }} - Selecionar Ranking para Pagamento de Prêmio @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-users"></i>
								Usuários
								&nbsp;
								<i class="ace-icon fa fa-flag-checkered"></i>
								Prêmio
								&nbsp;
								<i class="ace-icon fa fa-credit-card"></i>
								Realizar Pagamento
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Prêmio
								</small>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Selecionar Ranking para Pagamento
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
								<form class="form-horizontal" role="form" id="formPremio" name="formPremio" method="GET" action="{{ route('usuarios.telaSelecionarGanhador') }}">
									{{ csrf_field() }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil">Ranking</label>

										<div class="col-sm-9">
										{!! Form::select('id_ranking', $tb_rankings, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Selecionar
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
