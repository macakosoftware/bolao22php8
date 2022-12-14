@extends('template')

@section('titulo'){{ config('app.name') }} - Regulamento @endsection

@section('header_css') @endsection

@section('content')
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="menu-icon fa fa-book"></i>
								Regulamento
							</li>
						</ul><!-- /.breadcrumb -->

					</div>

					<div class="page-content">

						<div class="page-header">
							<h1>
								Regulamento
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									{{ config('app.name') }}
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

                            @if (session('erro'))
                            	<div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>
									<ul>
                                        <li>
										<i class="ace-icon fa fa-check-square"></i>
                                        {{ session('erro') }}</li>
                                    </ul>
								</div>
        					@endif

							<div class="col-xs-12">

								<div class="row">
									<div class="space-6"></div>

									<div class="col-sm-12">
											<h2>1. OBJETIVO</h2>
											<ul>
												<li>
													1.1 O Bol??o Copa Brothes 2022 ?? uma iniciativa entre amigos e voltada para acompanhar os jogos da FIFA Copa do Mundo 2022 a ser realizada no Qatar de 20/11/2022 a 18/12/2022.
												</li>
											</ul>
											<h2>2. COMO PARTICIPAR</h2>
											<ul>
												<li>
													2.1 Poder??o participar apenas pessoas que forem convidadas pelo CGBCB (Comit?? Gestor Bol??o Copa Brothers). Os convidados dever??o informar seu e-mail para o CGBCB que proceder?? com a cria????o das credenciais de acesso ao site/sistema do bol??o (em www.bolao18.club) onde o participante poder?? registrar seus paliptes e acompanhar os resultados do bol??o e ranking de classifica????o.
												</li>
												<li>
													2.2 Cada participante dever?? pagar uma "Joia Ingresso" no valor de R$35,00 (trinta e cinco reais) para confirmar sua participa????o no bol??o.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														a. S?? estar??o aptos a participar do bol??o os usu??rios que estiverem com a situa????o de pagamento da "Joia Ingresso" confirmado.
    													</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
        													b. O pagamento dever?? ser realizado at?? uma semana antes do in??cio da FIFA Copa do Mundo 2022 - 13 de Novembro de 2022 as 18:00h.
        													<ul class="list-unstyled">
        													<li>
        														<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
        														?? Casos excepcionais de inscri????o entre 13/11/2022 a 19/11/2022 ser??o analisados individualmente pela CABCB (C??mara Arbitral Bol??o Copa Brothers).
        													</li>
        													</ul>
        												</li>
    												</ul>
    											</li>
    										</ul>
											<h2>3. DESIST??NCIA</h2>
											<ul>
												<li>
													3.1 O participante poder?? desistir da participa????o no bol??o a qualquer momento at?? o encerramento das inscri????es no dia 13 de novembro de 2022 as 18:00h.
												</li>
												<li>
													3.2 A desist??ncia dever?? ser protocolada pelo participante junto ao CGBCB dentro do prazo definido no item 3.1.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. Eventuais exce????es com rela????o a desist??ncia entre 13/11/2022 e 19/11/2022 ser??o analisadas individualmente pela CABCB, ficando a cargo da CABCB deferir ou indeferir o pedido da desist??ncia.
														</li>
													</ul>
												</li>
												<li>
													3.3 Quando do momento da desist??ncia, caso o participante j?? tenha realizado o pagamento da "Joia Ingresso" receber?? o reembolso integral do montante pago.
												</li>
												<li>
													3.4 Ap??s o prazo legal para desist??ncia n??o haver?? mais possibilidade do participante solicitar sua desist??ncia.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. Ap??s o prazo legal n??o haver?? mais possibilidade de reembolso da "Joia Ingresso".
														</li>
													</ul>
												</li>
											</ul>
											<h2>4. FASES DO BOL??O</h2>
											<ul>
												<li>
													4.1 O Bol??o ser?? compreendido de 8 fases definidas abaixo:
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															1) Primeira Rodada da Primeira Fase (16 Jogos dos Grupos "A" a "H")
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>
															2) Segunda Rodada da Primeira Fase (16 Jogos dos Grupos "A" a "H")
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>
															3) Terceira Rodada da Primeira Fase (16 Jogos dos Grupos "A" a "H")
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>
															4) Oitavas-de-final (8 jogos)
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>
															5) Quartas-de-final (4 jogos)
														</li>
														<li>
															<i class="ace-icon fa fa-caret-right blue"></i>
															6) Semifinal, Disputa de Terceiro Lugar e Final (4 Jogos)
														</li>
													</ul>
												</li>
												<li>
													4.2 Al??m das fases acima definidas, haver?? uma fase geral que ocorrer?? do primeiro ao ??ltimo jogo da Copa.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															1) Ranking Geral (Todos os 64 Jogos da Copa)
														</li>
													</ul>
												</li>
											</ul>
											<h2>5. PALPITES</h2>
											<ul>
												<li>
													5.1 Cada participante poder?? registrar uma ??nica aposta por jogo da Copa do Mundo.
													a. O participante poder?? alterar o palpite registrado a qualquer momento at?? a data/hora limite para registro dos palpites.
												</li>
												<li>
													5.2 Os palpites compreender??o os jogos das primeira fase (rodadas um, dois e tr??s), oitavas-de-final, quartas-de-final, semifinal, disputa de terceiro lugar e final.
												</li>
												<li>
													5.3 Para cada jogo o participante dever?? informar o placar da partida.
													a. Para partidas de car??ter eliminat??rio, caso seja informado um placar de empate, o participante poder?? informar tamb??m o vencedor da partida na disputa de p??naltis.
												</li>
												<li>
													5.4 Os palpites dever??o ser realizados at?? 1h (uma hora) antes do in??cio de cada partida. Ap??s esse prazo o sistema automaticamente encerr?? os palpites e travar?? o jogo para edi????o dos placares.
												</li>
												<li>
												5.5 Os jogos que o participante n??o registrar o palpite at?? o prazo limite ter??o seus palpites registrados como 10x10.
												</li>
											</ul>
											<h2>6. PONTUA????O</h2>
											<ul>
												<li>
    												6.1 Cada sele????o receber?? uma pontua????o baseada em seu ??ndice t??cnico e a probabilidade da mesma vencer, empatar ou sair derrotada da partida.
    												<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				a. A pontua????o ser?? baseada no ??ndice t??cnico de cada sele????o e na diferen??a de n??vel entre as duas sele????es envolvidas na partida.
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				b. Uma vit??ria de uma sele????o considerada "zebra" em uma partida reverter?? em mais pontos para um eventual acertador do palpite, j?? que estatisticamente esse evento possui uma probabilidade menor de ocorrer.
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				c. Palpites em sele????es consideradas "favoritas" reverter??o em menos pontos devido a maior probabilidade das mesmas vencerem seus confrontos.
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					d. Os pontos definidos para cada sele????o em uma partida ser??o exibidos junto aos jogos no momento de registrar o palpite.
                                        				</li>
                                        			</ul>
                                    			</li>
                                    			<li>
													6.2 Se o participante acertar o resultado da partida (vencedor sele????o 1, empate ou vencedor sele????o 2) ganhar?? os pontos definidos para aquela sele????o. Os pontos ser??o utilizados para o c??lculo do ranking de fase (Item 4.1) e para o c??lculo geral do ranking (Item 4.2).
												</li>
												<li>
													6.3 Al??m dos pontos ganhos por acertar o resultado da partida, o participante tamb??m poder?? somar pontos adicionais se:
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. Acertar o Placar Cheio da Partida: N??mero de gols anotados pelas duas sele????es;
														</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															b. Acetar o Placar Parcial da Partida:n??mero de gols do vencedor ou o numero de gols do perdedor;
														</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															?? Os pontos do placar parcial s?? ser??o computados se o participante acertar o resultado da partida (Item 6.2).
														</li>
													</ul>
												</li>
												<li>
													6.4 Os pontos defindiso para cada placar em uma partida ser??o exibidos junto aos jogos no momento de registrar o palpite.
												</li>
												<li>
													6.5 Os pontos definidos para o acerto de gols do vencedor ou do perdedor ser??o exibidos juntos aos jogos no momento de registrar o palpite.
												</li>
												<li>
													6.6 Partidas Eliminat??rias onde o participante realizar um palpite de empate e acertar o vencedor da disputa de p??naltis receber?? uma pontua????o b??nus de 2 (dois) pontos.
												</li>
												<li>
													6.7 Partidas Eliminat??rias ser??o computadas os 120 minutos de partida (quando houver prorroga????o) para fins de venedor e placar final do jogo. Caso o jogo n??o v?? para prorroga????o valer?? os 90 minutos. No caso de empate vale o item 6.6 para premia????o do vencedor dos penalties para quem jogar empate no resultado.
												</li>
											</ul>
											<h2>7. RANKING</h2>
											<ul>
												<li>
													7.1 O Ranking Geral ser?? computado pelos pontos ganhos pelo participante em todos os jogos da competi????o.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. No Caso de Empate entre dois competidores no Ranking Geral ser??o adotados os seguintes crit??rios de desempate:
														</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															1) Maior N??mero de Acertos em Placares Cheios;
														</li>
														<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					2) Maior N??mero de Acertos em Placares Parciais;
                                        				</li>
                                        				<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					3) Maior N??mero de Acertos de Resultados;
                                        				</li>
                                        				<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					4) Maior Pontua????o em um ??nico Jogo;
                                        				</li>
                                        				<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					5) Sorteio;
                                        				</li>
                                        				<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					??Em caso de necessidade de sorteio, esse ser?? realizado pela CGBCB em at?? 24 horas ap??s o encerramento da ??ltima partida da Copa. O Sorteio dever?? ser auditado e acompanhado por pelo menos 2 participantes do bol??o.
                                        				</li>
                                        			</ul>
												</li>
												<li>
													7.2 O Ranking das Fases ser?? computado pelos pontos ganhos pelo participante somente nas partidas daquela fase espec??fica.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				a. No Caso de Empate entre dois competidores no Ranking das Fases ser??o adotados os seguintes crit??rios de desempate:
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				1) Pontua????o no Ranking Geral no Momento de Conclus??o da Fase;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				2) Maior N??mero de Acertos em Placares Cheios;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				3) Maior N??mero de Acertos em Placares Parciais;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				4) Maior N??mero de Acertos de Resultados;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				5) Maior Pontua????o em um ??nico Jogo;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				6) Sorteio;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				??Em caso de necessidade de sorteio, esse ser?? realizado pela CGBCB em at?? 24 horas ap??s o encerramento da ??ltima partida da fase em quest??o. O Sorteio dever?? ser auditado e acompanhado por pelo menos 2 participantes do bol??o.
                                            			</li>
                                            		</ul>
												</li>
											</ul>
											<h2>8. PREMIA????O</h2>
											<ul>
												<li>
                                            	8.1 A Premia????o do bol??o ser?? feita com o rateio integral do montante arrecado das "Joias Ingresso"" de cada participante.
                                            	</li>
                                            	<li>
                                            	8.2 A regra de rateio dos pr??mios ser?? feita da seguinte maneira:
                                            	<ul class="list-unstyled">
    												<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			a. Ranking Geral	40% do Montante Geral<br/>
                                            			* dentro desse montante o valor ser?? rateado da seguinte maneira:
                                            			<ul class="list-unstyled">
        													<li>
        														<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
                                                				1) Primeiro Lugar 50% do Pr??mio (20% do Montante Geral)
                                                			</li>
                                                			<li>
                                                				<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
                                            					2) Segunda Lugar  30% do Pr??mio (12% do Montante Geral)
                                            				</li>
                                            				<li>
                                            					<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
                                            					3) Terceiro Lugar 20% do Pr??mio (8% do Montante Geral)
                                            				</li>
                                            			</ul>
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			b. Primeira Rodada da Primeira Fase 13% do Montante Geral<br/>
                                            			Esse pr??mio n??o ser?? rateado, ser?? entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			c. Segunda Rodada da Primeira Fase 13% do Montante Geral<br/>
                                            			Esse pr??mio n??o ser?? rateado, ser?? entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			d. Terceira Rodada da Primeira Fase 13% do Montante Geral<br/>
                                            			Esse pr??mio n??o ser?? rateado, ser?? entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			e. Oitavas-de-Final 9% do Montante Geral<br/>
                                            			Esse pr??mio n??o ser?? rateado, ser?? entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
                                            			<i class="ace-icon fa fa-caret-right blue"></i>
                                            			f. Quartas-de-Final 6% do Montante Geral<br/>
                                            			Esse pr??mio n??o ser?? rateado, ser?? entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
                                            			<i class="ace-icon fa fa-caret-right blue"></i>
                                            			g. Semifinal, Disputa de 3o. Lugar e Final 6% do Montante Geral<br/>
                                            			Esse pr??mio n??o ser?? rateado, ser?? entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            	</li>
                                            </ul>
                                            <h2>9. ??NDICE T??CNICO DAS SELE????ES</h2>
                                            <ul>
												<li>
                                            	9.1 Para c??lculo das probabilidades de vit??ria, empate e derrota as 32 sele????es participantes da FIFA Copa do Mundo 2022 foram divididas em 10 Grupos de Acorod com suas probabilidades de vit??rina na competi????o.
                                            	</li>
                                            	<li>
                                            	9.2 Para fins de 'rankeamento' foi utilizado o ranking publicado no site oddschecker para a 'bolsa' de cada sele????o.
                                            	</li>
                                            	<li>
                                            	9.3 Os grupos e suas sele????es foram estabelecidos da seguinte maneira:
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 1 : Brasil e Fran??a
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 2 : Inglaterra e Argentina
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 3 : Espanha, Alemanha e Holanda
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 4 : Portugal e B??lgica
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 5 : Dinamarca, Cro??cia e Uruguai
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 6 : Senegal, Sui??a, S??rvia e M??xico
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 7 : Pa??s de Gales, EUA e Polonia
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 8 : Equador, Camar??es, Gana e Marrocos
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 9 : Jap??o, Cor??ia do Sul, Canad?? e Austr??lia
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 10 : Qatar, Tun??sia, Ar??bia Saudita, Ir?? e Costa Rica
                                            			</li>
                                            		</ul>
                                            	</li>
                                            	<li>
                                            	9.4 Ap??s a finaliza????o da primeira fase ser?? realizado um Congresso T??cnico do CTBCB (C??mite T??cnico Bol??o Copa Brothers) para revis??o dos ??ndices t??cnicos das sele????es classificadas.
                                            		a. Ap??s a revis??o os novos grupos e ??ndices t??cnicos ser??o divulgados a todos os participantes.
                                            	</li>
                                            </ul>
                                            <h2>10. C??LCULO DE PONTUA????O DOS PLACARES</h2>
                                            <ul>
												<li>
                                            	10.1 O c??lculo de pontua????o de cada placar foi definido pelas estat??sticas de cada placar ocorrer em uma Copa do Mundo baseado no hist??rico das copas realizadas de 1930 a 2010.
                                            	</li>
                                            	<li>
                                            	10.2 Quanto maior a probabilidade de um placar ocorrer, menor a pontua????o que esse reverter??.
                                            	</li>
                                            	<li>
                                            	10.3 Para c??lculo da pontua????o dos placares tamb??m ?? utilizado o ??ndice t??cnico das sele????es podendo ser aplicado uma redu????o ou acr??scimo percentual que pode variar at?? 40%.
                                            	</li>
                                            	<li>
                                            	10.4 A pontua????o m??xima que um acerto em placar cheio poder?? chegar ?? de 15 (quinze) pontos.
                                            	</li>
                                            	<li>
                                            	10.5 A pontua????o do placar do vencedor ou perdedor ser?? a metade da menor pontua????o dada para o placar em que o n??mero de gols ocorre.
                                            	</li>
                                            </ul>
                                            <h2>11. DEMAIS DISPOSI????ES</h2>
                                            <ul>
												<li>
                                            	11.1 Eventuais disposi????es n??o cobertas por esse regulamento dever??o ser deliberadas pela CABCB e divulgadas a todos os participantes.
                                            	</li>
                                            	<li>
                                            	11.2 Eventuais aditivos poder??o ser inclu??dos nesse regulamento em virtude de situa????es que venham a ocorrer e o CTBCB considere oportuno sua inclus??o. Os aditivos dever??o ser divulgados a todos os participantes.
                                            	</li>
                                            </ul>
                                            <h2>12. BROTHETAS</h2>
                                            <ul>
												<li>
                                            	12.1 As Brothetas ?? a moeda virtual do Bol??o Copa Brothers 2022 utilizada para a compra de figurinhas Bol??o Copa Brothers 2022.
                                            	</li>
                                            	<li>
                                            	12.2 As Brothetas n??o s??o comercializadas pois o intuito de sua exist??ncia ?? apenas para o uso recreativo de seus participantes.
                                            	</li>
                                            	<li>
                                            	12.3 As Brothetas ser??o creditadas automaticamente na conta de cada participante seguindo os crit??rios pr??-estabelecidos abaixo:
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 a) No pagamento da Joia Ingresso - Cr??dito Imediato de 100 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 b) No dia que o participante logar no site - Cr??dito no Dia Seguinte de 10 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 c) No dia que o participante comprar novas figurinhas - Cr??dito no Dia Seguinte de 5 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 d) No dia que o participante criar uma nova proposta, receber uma oferta e aceitar - Cr??dito no Dia Seguinte de 5 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 e) No dia que o participante fizer uma oferta por proposta aberta e o proponente aceitar - Cr??dito no Dia Seguinte de 5 Brothetas
                                            			</li>
    											</ul>
    											</li>
    											<li>
                                            	12.4 Fica a crit??rio do CGBCB (Comit?? Gestor Bol??o Copa Brothers) o lan??amento de promo????es para o cr??dito de Brothetas extras. Nessas situa????es a promo????o ser?? divulgada a todos os participantes atrav??s de notifica????o ou aviso no site.
                                            	</li>
                                            </ul>
                                            <h2>13. FIGURINHAS</h2>
                                            <ul>
												<li>
                                            	13.1 Os participantes com Brothetas em sua conta poder??o adquirir figurinhas Bol??o Copa Brothers atrav??s do site na Op????o Figurinhas > Comprar Figurinhas.
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 a) A compra ?? limitada a 10 figurinhas de cada vez para n??o sobrecarregar a p??gina que exibe as figurinhas adquiridas.
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 b) N??o h?? limite de compras di??rias, respeitando-se o saldo de Brothetas e o limite de at?? 10 por cada compra.
                                            			</li>
                                            	</ul>
                                            	</li>
                                            	<li>
                                            	13.2 As figurinhas adquiridas ser??o aleat??rias e o sistema utiliza um algoritmo onde quanto maior o valor de mercado do jogador, menor a probabilidade que a figurinha sai no momento da aquisi????o.
                                            	</li>
                                            	<li>
                                            	13.3 As figurinhas repetidas poder??o ser trocadas de duas maneiras:
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 a) Atrav??s da Op????o Figurinhas > Propostas > Oferecer Figurinha: Nesse caso o proponente dever?? aguardar ofertas por sua figurinha. Se uma oferta for postada ser?? exibido o ??cone de notifica????o na barra superior.
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 b) Atrav??s da Op??ao Figurinhas > Ofertas > Procurar Propostas : Nesse caso o ofertante dever?? procurar uma proposta que o agrade. Em encontrando, clicar?? em Criar Oferta e poder?? oferecer figurinha(s) pela troca, ou Brothetas por aquela figurinha. Ser?? exibida notifica????o na barra superior com o resultado de sua oferta quando o proponente aceitar/declinar sua oferta.
                                            			</li>
                                            	</ul>
                                            	</li>
                                            	<li>
                                            	13.4 As propostas criadas poder??o a qualquer momento serem fechadas pelo proponente atrav??s da op????o Figurinhas > Propostas > Encerrar Proposta.
                                            	</li>
                                            	<li>
                                            	13.5 As ofertas criadas poder??o a qualquer momento serem canceladas pelo ofertante atrav??s da op????o Figurinhas > Ofertas > Cancelar Oferta.
                                            	</li>
                                            	<li>
                                            	13.6 O participante poder?? ver seu ??lbum com todas as figurinhas que j?? possui atrav??s da op????o Album que fica no canto superior direito embaixo do seu avatar/nome pr??ximo ao bot??a de logout.
                                            	</li>
                                            	<li>
                                            	13.7 Ser?? disponibilizada op????o para gera????o do ??lbum em formato PDF para os participantes que desejarem imprimir o ??lbum.
                                            	</li>
									</div>

								</div><!-- /.row -->

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
@endsection

@section('pos_script')
@endsection