@extends('template') @section('titulo'){{ config('app.name') }} - Visualizar Oferta @endsection 
@section('header_css')
@endsection

@section('content')
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li><i class="menu-icon fa fa-book"></i> Figurinhas
				&nbsp; 
				<i class="menu-icon fa fa-shopping-basket"></i>
				Ofertas
				&nbsp;
				<i class="menu-icon fa fa-eye"></i>
				Visualizar Oferta
				</li>

			</ul>
			<!-- /.breadcrumb -->

		</div>

		<div class="page-content">

			<div class="page-header">
				<h1>
					Figurinhas
					 <small>
					 <i class="ace-icon fa fa-angle-double-right"></i>
						Ofertas
					 <i class="ace-icon fa fa-angle-double-right"></i>
						Visualizar Oferta
					</small>
				</h1>
			</div>
			<!-- /.page-header -->

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
			
			@if (session('mensagem'))
            	<div class="alert alert-info">
					<button class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<ul>                                        
                        <li>
						<i class="ace-icon fa fa-info"></i>									                                            
                        {{ session('mensagem') }}</li>
                    </ul>
				</div>
			@endif
			
            @if (session('sucesso'))
            	<div class="alert alert-success">
					<button class="close" data-dismiss="alert">
						<i class="ace-icon fa fa-times"></i>
					</button>
					<ul>                                        
                        <li>
						<i class="ace-icon fa fa-check-square"></i>									                                            
                        {{ session('sucesso') }}</li>
                    </ul>
				</div>
			@endif		
			
			<div class="col-xs-12">
				<h2>
				@if ($proposta->cd_status == \App\TransacaoProposta::STATUS_ENVIADA) 
				<i class="ace-icon fa fa-arrow-circle-right blue"></i>
				ENVIADA                											
				@elseif ($proposta->cd_status == \App\TransacaoProposta::STATUS_ACEITA)
				<i class="ace-icon fa fa-check green"></i>
				ACEITA                									
				@elseif ($proposta->cd_status == \App\TransacaoProposta::STATUS_REJEITADA)
				<i class="ace-icon fa fa-times red"></i>
				REJEITADA                									
				@elseif ($proposta->cd_status == \App\TransacaoProposta::STATUS_CANCELADA)
				<i class="ace-icon fa fa-ban orange"></i>
				CANCELADA                									
				@endif
				</h2>		
				<h4>Figurinha Desejada</h4>
				<h5>
				<img width="50" height="50" src="{{ asset('images/federacoes') }}/{{$proposta->transacao->jogador->selecao->ds_icone}}" />				
				{{ $proposta->transacao->jogador->selecao->ds_nome }}
				<i class="ace-icon fa fa-angle-double-right bigger-110"></i>
				{{ $proposta->transacao->jogador->ds_nome }} 
				</h5>				
				<h4>Dono da Figurinha</h4>
				<p>
				@if (\App\Funcoes\VerificaAvatar::verificar($proposta->transacao->id_user))
				<img width="30px" height="30px" src="data:image/png;base64,{{ base64_encode(Storage::get('avatars/'.$proposta->transacao->id_user))}}" alt="Photo" />
				@else
				<img width="30px" height="30px" src="{{ asset('assets/images/avatars/user.jpg') }}" alt="Photo" />                                								
				@endif	
				{{$proposta->transacao->usuario->name}}
				</p>
				@if ($proposta->vl_proposta > 0)
				<h4>Valor</h4>
				<p>{{number_format($proposta->vl_proposta,2,',','')}}</p>
				@endif
				<h4>Observação</h4>
				<p>{{$proposta->ds_observacao}}</p>
				<h4>Resposta</h4>
				<p>{{$proposta->ds_resposta}}</p>
				<h4>Data/Hora</h4>
				<p>{{$proposta->updated_at}}</p>
				@if (isset($jogadores))
				@if (count($jogadores) > 0)
				<h4>Figurinhas Ofertadas</h4>
				<ul class="list-unstyled spaced2">
					@foreach($jogadores as $jogador)
					<li>
						<i class="ace-icon fa fa-angle-right bigger-110"></i>
						<img width="50" height="50" src="{{ asset('images/federacoes') }}/{{$jogador->jogador->selecao->ds_icone}}" />
						{{$jogador->jogador->selecao->ds_nome}} / 
						<img width="30" height="50" alt="30x50" src="{{url('figurinhas/mostrar')}}?id_jogador={{$jogador->jogador->id}}" />
						{{$jogador->jogador->ds_nome}} 
					</li>
					@endforeach					
				</ul>
				@endif
				@endif
				<hr/>
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" id="bt_voltar" type="button" >
						<i class="ace-icon fa fa-angle-left bigger-110"></i>
						Voltar
						</button>
					</div>
				</div>
				</div>
			</div><!-- /.row -->	
			
			<!-- /.row -->
		</div>
		<!-- /.page-content -->
	</div>
</div>
<!-- /.main-content -->
@endsection @section('pos_script')
<!-- page specific plugin scripts -->
<script type="text/javascript">
			jQuery(function($) {
				$("#bt_voltar").click(function(event) {				    
				    history.back(1);
				});
			});
		</script>
@endsection