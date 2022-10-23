@extends('template')

@section('titulo'){{ config('app.name') }} - Gerar Fechamento @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-line-chart"></i>
								Ranking
								&nbsp;
								<i class="ace-icon fa fa-print"></i>
								Gerar Fechamento
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Ranking
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Selecione o(s) ranking(s) para gerar o fechamento
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
								<form class="form-horizontal" role="form" id="formFechamento" name="formFechamento" method="POST" action="{{ route('rankings.gerarFechamento') }}" >
									{{ csrf_field() }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"  for="cd_perfil">Ranking</label>

										<div class="col-sm-9">
										{!! Form::select('cd_ranking', $tb_rankings, 0, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1']) !!}
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Gerar
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
