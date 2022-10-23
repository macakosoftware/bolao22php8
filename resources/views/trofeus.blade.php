@extends('template')

@section('titulo'){{ config('app.name') }} - Perfil @endsection

@section('header_css') @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-trophy"></i>
								Troféus
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Consultar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Troféus
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Minha Sala de Troféus
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
									@if ($qt_badges == 0)	
									<div class="col-sm-4 col-xs-12">
										<img src="{{ asset('images/badges') }}/{{\App\Models\Badge::SEM_BADGE}}" />									
									</div>
									@else
										@foreach($badges as $badge)
										<div class="col-sm-4 col-xs-12">
											<img src="{{ asset('images/badges') }}/{{$badge->badge->ds_link_badge}}" />									
										</div>
										@endforeach
									@endif
								</div>
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')	
@endsection