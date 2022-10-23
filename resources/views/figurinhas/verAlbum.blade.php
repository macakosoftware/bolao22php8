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
								<i class="ace-icon fa fa-book"></i>
								Album
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Visualizar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Album
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Ver meu Album
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
								<h1 class="header smaller lighter blue"><img src="{{asset('images/federacoes')}}/{{$selecao->ds_icone}}"/>{{$selecao->ds_nome}}
								@if (env('TIPO_BOLAO') == 'WC')<small>{{$selecao->grupo->ds_grupo}}</small> @endif
								</h3>
							</div>
							
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
													<span class="label label-warning arrowed-in">{{($figurinha['qt_figurinhas'] - 1) }} Repetida</span>
												</span>
											</div>
											@endif

											<div class="tools">
												<a href="#">
													<i class="ace-icon fa fa-exchange"></i>
												</a>

												<a href="#">
													<i class="ace-icon fa fa-money"></i>
												</a>
											</div>
										</li>
										@endforeach
									</ul>
								</div>
							</div>
							
							<div class="col-xs-12">
								<h3 class="header smaller lighter blue"></h3>
								
								<div class="form-group">
										<label class="col-sm-12 control-label no-padding-right"  for="id_ranking">Ir para Seleção:</label>

										<div class="col-sm-12">
										{!! Form::select('id_selecao', $tb_selecoes, $id_selecao, $attributes = ['class'=>'col-xs-10 col-sm-5', 'tabindex'=>'-1', 'id'=>'id_selecao']) !!}
										</div>
								</div>

								<div>
									<ul class="pagination">
										<li @if($id0 == 0) class="disabled" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id0}}">
												<i class="ace-icon fa fa-angle-double-left"></i>
											</a>
										</li>

										<li @if($id_selecao == $id1) class="active" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id1}}">{{$id1}}</a>
										</li>

										<li @if($id_selecao == $id2) class="active" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id2}}">{{$id2}}</a>
										</li>

										<li @if($id_selecao == $id3) class="active" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id3}}">{{$id3}}</a>
										</li>

										<li @if($id_selecao == $id4) class="active" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id4}}">{{$id4}}</a>
										</li>

										<li @if($id_selecao == $id5) class="active" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id5}}">{{$id5}}</a>
										</li>

										<li @if($id6 == 0) class="disabled" @endif>
											<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id6}}">
												<i class="ace-icon fa fa-angle-double-right"></i>
											</a>
										</li>
									</ul>
								</div>

								<p></p>
								<ul class="pager">
									@if ($id_ant != 0)
									<li class="previous">
										<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id_ant}}">&larr; Página Anterior</a>
									</li>
									@endif
									
									@if ($id_prox != 0)
									<li class="next">
										<a href="{{url('figurinhas/verAlbum')}}?id_selecao={{$id_prox}}">Próxima Página &rarr;</a>
									</li>
									@endif
								</ul>
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