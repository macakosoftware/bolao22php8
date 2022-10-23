@extends('template')

@section('titulo'){{ config('app.name') }} - Minhas Figurinhas @endsection

@section('header_css')
<link rel="stylesheet" href="{{asset('assets/css/colorbox.min.css')}}" /> 
@endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-id-card-o"></i>
								Figurinhas
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Minhas Figurinhas
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Figurinhas
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Listar Minhas Figurinhas
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
								<div>
									<ul class="ace-thumbnails clearfix">
										@foreach($tb_figurinhas as $figurinha)
										<li>
											<a href="{{url('figurinhas/mostrar')}}?id_jogador={{$figurinha['id_jogador']}}" title="{{$figurinha['jogador']->ds_nome}}" data-rel="colorbox">
												<img width="180" height="270" alt="150x150" src="{{url('figurinhas/mostrar')}}?id_jogador={{$figurinha['id_jogador']}}" />
											</a>
							
											@if ($figurinha['qt_figurinhas'] > 1)
											<div class="tags">
												<span class="label-holder">
													<span class="label label-warning arrowed-in">{{($figurinha['qt_figurinhas'] - 1)}} Repetida</span>
												</span>
											</div>
											@endif

											<div class="tools">
												<a href="{{url('figurinhas/telaTrocar')}}?id_jogador={{$figurinha['id_jogador']}}">
													<i class="ace-icon fa fa-exchange"></i>
												</a>

												<a href="{{url('figurinhas/telaVender')}}?id_jogador={{$figurinha['id_jogador']}}">
													<i class="ace-icon fa fa-money"></i>
												</a>
											</div>
										</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
<script src="{{asset('assets/js/jquery.colorbox.min.js')}}"></script>	
<script>
  $(function(){
    $('#id_selecao').on('change', function () {
        var id = $(this).val(); // get selected value
        if (id) { 
            window.location = "{{url('figurinhas/verAlbum')}}?id_selecao="+id; 
        }
        return false;
    });
  });
  jQuery(function($) {
		var $overflow = '';
		var colorbox_params = {
			rel: 'colorbox',
			photo:true,
			reposition:true,
			scalePhotos:true,
			scrolling:false,
			
			current:'{current} de {total}',
			maxWidth:'100%',
			maxHeight:'100%',			
			onOpen:function(){
				$overflow = document.body.style.overflow;
				document.body.style.overflow = 'hidden';
			},
			onClosed:function(){
				document.body.style.overflow = $overflow;
			},
			onComplete:function(){
				$.colorbox.resize();
			}
		};

		$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
		$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon
		
		
		$(document).one('ajaxloadstart.page', function(e) {
			$('#colorbox, #cboxOverlay').remove();
	   });
	})	  
</script>	
@endsection