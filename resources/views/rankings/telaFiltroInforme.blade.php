@extends('template')

@section('titulo'){{ config('app.name') }} - Consulta de Ranking @endsection

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
								Gerar Informe
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Ranking
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Selecione o(s) ranking(s) para gerar o informe
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
								<form class="form-horizontal" role="form" id="formInforme" name="formInforme" method="POST" action="{{ route('rankings.gerarInforme') }}" >
									{{ csrf_field() }}
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-top" for="duallist"> Rankings </label>

										<div class="col-sm-8">
											<select multiple="multiple" size="10" name="cd_ranking[]" id="cd_ranking">
												@foreach($tb_rankings as $ranking)
												<option value="{{$ranking['id']}}">{{$ranking['ds_nome']}}</option>
												@endforeach
											</select>

											<div class="hr hr-16 hr-dotted"></div>
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
<script src="{{ asset('assets/js/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-multiselect.min.js') }}"></script>
<script type="text/javascript">
	jQuery(function($){
	    var demo1 = $('select[name="cd_ranking[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Com Filtro</span>'});
		var container1 = demo1.bootstrapDualListbox('getContainer');
		container1.find('.btn').addClass('btn-white btn-info btn-bold');
		
		//////////////////
		$('.multiselect').multiselect({
		 enableFiltering: true,
		 enableHTML: true,
		 buttonClass: 'btn btn-white btn-primary',
		 templates: {
			button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
			ul: '<ul class="multiselect-container dropdown-menu"></ul>',
			filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
			filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
			li: '<li><a tabindex="0"><label></label></a></li>',
	        divider: '<li class="multiselect-item divider"></li>',
	        liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
		 }
		});
	
	});
</script>
@endsection
