@extends('template')

@section('titulo'){{ config('app.name') }} - Detalhar Votação @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-users"></i>
								Usuários 
								&nbsp;
								<i class="ace-icon fa fa-thumbs-up"></i>
								Votação
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Consultar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Usuários
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Votação
									<i class="ace-icon fa fa-angle-double-right"></i>
									Detalhar Votação
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
								
								<div class="col-sm-12">
										<div class="widget-box">
											<div class="widget-header widget-header-flat widget-header-small">
												<h5 class="widget-title">
													<i class="ace-icon fa fa-signal"></i>
													{{$votacao->ds_titulo}} - Total de Votos: {{$total_votos}}
												</h5>
											</div>

											<div class="widget-body">
												<div class="widget-main">
													<div id="piechart-placeholder"></div>

													<div class="hr hr8 hr-double"></div>

													<div class="clearfix">
														<p>{{$votacao->ds_descricao}}</p>
													</div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
								
							</div>								
						</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection
@section('pos_script')
<script src="{{ asset('assets/js/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.pie.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.resize.min.js') }}"></script>
<script>
jQuery(function($) {
    var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
    var data = [
        @foreach($tb_valores as $valor)
        @if ($valor['nr'] > 1) , @endif
    	{ label: "{{$valor['ds_valor']}} - {{$valor['qt_votos']}}",  data: {{$valor['qt_votos']}}, color: "{{$valor['ds_cor']}}"}    		
    	@endforeach    	
    ]
    function drawPieChart(placeholder, data, position) {
    	  $.plot(placeholder, data, {
    		series: {
    			pie: {
    				show: true,
    				tilt:0.8,
    				highlight: {
    					opacity: 0.25
    				},
    				stroke: {
    					color: '#fff',
    					width: 2
    				},
    				startAngle: 2
    			}
    		},
    		legend: {
    			show: true,
    			position: position || "ne", 
    			labelBoxBorderColor: null,
    			margin:[-30,15]
    		}
    		,
    		grid: {
    			hoverable: true,
    			clickable: true
    		}
    	 })
    }
    drawPieChart(placeholder, data);
    
    /**
    we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
    so that's not needed actually.
    */
    placeholder.data('chart', data);
    placeholder.data('draw', drawPieChart);
    
    
    //pie chart tooltip example
    var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
    var previousPoint = null;
    
    placeholder.on('plothover', function (event, pos, item) {
    	if(item) {
    		if (previousPoint != item.seriesIndex) {
    			previousPoint = item.seriesIndex;
    			var tip = item.series['label'] + " : " + item.series['percent']+'%';
    			$tooltip.show().children(0).text(tip);
    		}
    		$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
    	} else {
    		$tooltip.hide();
    		previousPoint = null;
    	}
    	
    });
});
</script>
@endsection