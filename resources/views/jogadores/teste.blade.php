@extends('template')

@section('titulo'){{ config('app.name') }} - Perfil @endsection

@section('header_css') @endsection

@section('content')
		<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-male"></i>
								Jogadores
								&nbsp;
								<i class="ace-icon fa fa-search"></i>
								Consultar
							</li>							
							
						</ul><!-- /.breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h1>
								Jogadores
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Minhas Figurinhas
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
									@foreach($figurinhas as $figurinha)
									<div class="col-sm-4 col-xs-12">											
										<img src="data:image/png;base64,{{ base64_encode(Storage::get('figurinhas/figurinha_'.$figurinha['id'].'.png'))}}" alt="Photo" />									
									</div>
									@endforeach
								</div>
							</div><!-- /.row -->						
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')	
@endsection