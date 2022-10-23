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
													1.1 O Bolão Copa Brothes 2022 é uma iniciativa entre amigos e voltada para acompanhar os jogos da FIFA Copa do Mundo 2022 a ser realizada no Qatar de 20/11/2022 a 18/12/2022.
												</li>
											</ul>
											<h2>2. COMO PARTICIPAR</h2>
											<ul>
												<li>
													2.1 Poderão participar apenas pessoas que forem convidadas pelo CGBCB (Comitê Gestor Bolão Copa Brothers). Os convidados deverão informar seu e-mail para o CGBCB que procederá com a criação das credenciais de acesso ao site/sistema do bolão (em www.bolao18.club) onde o participante poderá registrar seus paliptes e acompanhar os resultados do bolão e ranking de classificação.
												</li>
												<li>
													2.2 Cada participante deverá pagar uma "Joia Ingresso" no valor de R$35,00 (trinta e cinco reais) para confirmar sua participação no bolão.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														a. Só estarão aptos a participar do bolão os usuários que estiverem com a situação de pagamento da "Joia Ingresso" confirmado.
    													</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
        													b. O pagamento deverá ser realizado até uma semana antes do início da FIFA Copa do Mundo 2022 - 13 de Novembro de 2022 as 18:00h.
        													<ul class="list-unstyled">
        													<li>
        														<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
        														§ Casos excepcionais de inscrição entre 13/11/2022 a 19/11/2022 serão analisados individualmente pela CABCB (Câmara Arbitral Bolão Copa Brothers).
        													</li>
        													</ul>
        												</li>
    												</ul>
    											</li>
    										</ul>
											<h2>3. DESISTÊNCIA</h2>
											<ul>
												<li>
													3.1 O participante poderá desistir da participação no bolão a qualquer momento até o encerramento das inscrições no dia 13 de novembro de 2022 as 18:00h.
												</li>
												<li>
													3.2 A desistência deverá ser protocolada pelo participante junto ao CGBCB dentro do prazo definido no item 3.1.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. Eventuais exceções com relação a desistência entre 13/11/2022 e 19/11/2022 serão analisadas individualmente pela CABCB, ficando a cargo da CABCB deferir ou indeferir o pedido da desistência.
														</li>
													</ul>
												</li>
												<li>
													3.3 Quando do momento da desistência, caso o participante já tenha realizado o pagamento da "Joia Ingresso" receberá o reembolso integral do montante pago.
												</li>
												<li>
													3.4 Após o prazo legal para desistência não haverá mais possibilidade do participante solicitar sua desistência.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. Após o prazo legal não haverá mais possibilidade de reembolso da "Joia Ingresso".
														</li>
													</ul>
												</li>
											</ul>
											<h2>4. FASES DO BOLÃO</h2>
											<ul>
												<li>
													4.1 O Bolão será compreendido de 8 fases definidas abaixo:
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
													4.2 Além das fases acima definidas, haverá uma fase geral que ocorrerá do primeiro ao último jogo da Copa.
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
													5.1 Cada participante poderá registrar uma única aposta por jogo da Copa do Mundo.
													a. O participante poderá alterar o palpite registrado a qualquer momento até a data/hora limite para registro dos palpites.
												</li>
												<li>
													5.2 Os palpites compreenderão os jogos das primeira fase (rodadas um, dois e três), oitavas-de-final, quartas-de-final, semifinal, disputa de terceiro lugar e final.
												</li>
												<li>
													5.3 Para cada jogo o participante deverá informar o placar da partida.
													a. Para partidas de caráter eliminatório, caso seja informado um placar de empate, o participante poderá informar também o vencedor da partida na disputa de pênaltis.
												</li>
												<li>
													5.4 Os palpites deverão ser realizados até 1h (uma hora) antes do início de cada partida. Após esse prazo o sistema automaticamente encerrá os palpites e travará o jogo para edição dos placares.
												</li>
												<li>
												5.5 Os jogos que o participante não registrar o palpite até o prazo limite terão seus palpites registrados como 10x10.
												</li>
											</ul>
											<h2>6. PONTUAÇÃO</h2>
											<ul>
												<li>
    												6.1 Cada seleção receberá uma pontuação baseada em seu índice técnico e a probabilidade da mesma vencer, empatar ou sair derrotada da partida.
    												<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				a. A pontuação será baseada no índice técnico de cada seleção e na diferença de nível entre as duas seleções envolvidas na partida.
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				b. Uma vitória de uma seleção considerada "zebra" em uma partida reverterá em mais pontos para um eventual acertador do palpite, já que estatisticamente esse evento possui uma probabilidade menor de ocorrer.
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				c. Palpites em seleções consideradas "favoritas" reverterão em menos pontos devido a maior probabilidade das mesmas vencerem seus confrontos.
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					d. Os pontos definidos para cada seleção em uma partida serão exibidos junto aos jogos no momento de registrar o palpite.
                                        				</li>
                                        			</ul>
                                    			</li>
                                    			<li>
													6.2 Se o participante acertar o resultado da partida (vencedor seleção 1, empate ou vencedor seleção 2) ganhará os pontos definidos para aquela seleção. Os pontos serão utilizados para o cálculo do ranking de fase (Item 4.1) e para o cálculo geral do ranking (Item 4.2).
												</li>
												<li>
													6.3 Além dos pontos ganhos por acertar o resultado da partida, o participante também poderá somar pontos adicionais se:
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. Acertar o Placar Cheio da Partida: Número de gols anotados pelas duas seleções;
														</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															b. Acetar o Placar Parcial da Partida:número de gols do vencedor ou o numero de gols do perdedor;
														</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															§ Os pontos do placar parcial só serão computados se o participante acertar o resultado da partida (Item 6.2).
														</li>
													</ul>
												</li>
												<li>
													6.4 Os pontos defindiso para cada placar em uma partida serão exibidos junto aos jogos no momento de registrar o palpite.
												</li>
												<li>
													6.5 Os pontos definidos para o acerto de gols do vencedor ou do perdedor serão exibidos juntos aos jogos no momento de registrar o palpite.
												</li>
												<li>
													6.6 Partidas Eliminatórias onde o participante realizar um palpite de empate e acertar o vencedor da disputa de pênaltis receberá uma pontuação bônus de 2 (dois) pontos.
												</li>
											</ul>
											<h2>7. RANKING</h2>
											<ul>
												<li>
													7.1 O Ranking Geral será computado pelos pontos ganhos pelo participante em todos os jogos da competição.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															a. No Caso de Empate entre dois competidores no Ranking Geral serão adotados os seguintes critérios de desempate:
														</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
															1) Maior Número de Acertos em Placares Cheios;
														</li>
														<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					2) Maior Número de Acertos em Placares Parciais;
                                        				</li>
                                        				<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					3) Maior Número de Acertos de Resultados;
                                        				</li>
                                        				<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                        					4) Maior Pontuação em um Único Jogo;
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
                                        					§Em caso de necessidade de sorteio, esse será realizado pela CGBCB em até 24 horas após o encerramento da última partida da Copa. O Sorteio deverá ser auditado e acompanhado por pelo menos 2 participantes do bolão.
                                        				</li>
                                        			</ul>
												</li>
												<li>
													7.2 O Ranking das Fases será computado pelos pontos ganhos pelo participante somente nas partidas daquela fase específica.
													<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				a. No Caso de Empate entre dois competidores no Ranking das Fases serão adotados os seguintes critérios de desempate:
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				1) Pontuação no Ranking Geral no Momento de Conclusão da Fase;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				2) Maior Número de Acertos em Placares Cheios;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				3) Maior Número de Acertos em Placares Parciais;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				4) Maior Número de Acertos de Resultados;
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				5) Maior Pontuação em um Único Jogo;
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
                                            				§Em caso de necessidade de sorteio, esse será realizado pela CGBCB em até 24 horas após o encerramento da última partida da fase em questão. O Sorteio deverá ser auditado e acompanhado por pelo menos 2 participantes do bolão.
                                            			</li>
                                            		</ul>
												</li>
											</ul>
											<h2>8. PREMIAÇÃO</h2>
											<ul>
												<li>
                                            	8.1 A Premiação do bolão será feita com o rateio integral do montante arrecado das "Joias Ingresso"" de cada participante.
                                            	</li>
                                            	<li>
                                            	8.2 A regra de rateio dos prêmios será feita da seguinte maneira:
                                            	<ul class="list-unstyled">
    												<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			a. Ranking Geral	40% do Montante Geral<br/>
                                            			* dentro desse montante o valor será rateado da seguinte maneira:
                                            			<ul class="list-unstyled">
        													<li>
        														<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
                                                				1) Primeiro Lugar 50% do Prêmio (20% do Montante Geral)
                                                			</li>
                                                			<li>
                                                				<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
                                            					2) Segunda Lugar  30% do Prêmio (12% do Montante Geral)
                                            				</li>
                                            				<li>
                                            					<i class="ace-icon fa fa-caret-right blue"></i>
        														<i class="ace-icon fa fa-caret-right blue"></i>
                                            					3) Terceiro Lugar 20% do Prêmio (8% do Montante Geral)
                                            				</li>
                                            			</ul>
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			b. Primeira Rodada da Primeira Fase 13% do Montante Geral<br/>
                                            			Esse prêmio não será rateado, será entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			c. Segunda Rodada da Primeira Fase 13% do Montante Geral<br/>
                                            			Esse prêmio não será rateado, será entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			d. Terceira Rodada da Primeira Fase 13% do Montante Geral<br/>
                                            			Esse prêmio não será rateado, será entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
    													<i class="ace-icon fa fa-caret-right blue"></i>
                                            			e. Oitavas-de-Final 9% do Montante Geral<br/>
                                            			Esse prêmio não será rateado, será entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
                                            			<i class="ace-icon fa fa-caret-right blue"></i>
                                            			f. Quartas-de-Final 6% do Montante Geral<br/>
                                            			Esse prêmio não será rateado, será entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            		<li>
                                            			<i class="ace-icon fa fa-caret-right blue"></i>
                                            			g. Semifinal, Disputa de 3o. Lugar e Final 6% do Montante Geral<br/>
                                            			Esse prêmio não será rateado, será entregue integralmente ao primeiro lugar da fase.
                                            		</li>
                                            	</li>
                                            </ul>
                                            <h2>9. ÍNDICE TÉCNICO DAS SELEÇÕES</h2>
                                            <ul>
												<li>
                                            	9.1 Para cálculo das probabilidades de vitória, empate e derrota as 32 seleções participantes da FIFA Copa do Mundo 2022 foram divididas em 10 Grupos de Acorod com suas probabilidades de vitórina na competição.
                                            	</li>
                                            	<li>
                                            	9.2 Para fins de 'rankeamento' foi utilizado o ranking publicado no site oddschecker para a 'bolsa' de cada seleção.
                                            	</li>
                                            	<li>
                                            	9.3 Os grupos e suas seleções foram estabelecidos da seguinte maneira:
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 1 : Brasil e França
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
                                            				Grupo 4 : Portugal e Bélgica
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 5 : Dinamarca, Croácia e Uruguai
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 6 : Senegal, Suiça, Sérvia e México
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 7 : País de Gales, EUA e Polonia
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 8 : Equador, Camarões, Gana e Marrocos
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 9 : Japão, Coréia do Sul, Canadá e Austrália
                                            			</li>
                                            			<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				Grupo 10 : Qatar, Tunísia, Arábia Saudita, Irã e Costa Rica
                                            			</li>
                                            		</ul>
                                            	</li>
                                            	<li>
                                            	9.4 Após a finalização da primeira fase será realizado um Congresso Técnico do CTBCB (Cômite Técnico Bolão Copa Brothers) para revisão dos índices técnicos das seleções classificadas.
                                            		a. Após a revisão os novos grupos e índices técnicos serão divulgados a todos os participantes.
                                            	</li>
                                            </ul>
                                            <h2>10. CÁLCULO DE PONTUAÇÃO DOS PLACARES</h2>
                                            <ul>
												<li>
                                            	10.1 O cálculo de pontuação de cada placar foi definido pelas estatísticas de cada placar ocorrer em uma Copa do Mundo baseado no histórico das copas realizadas de 1930 a 2010.
                                            	</li>
                                            	<li>
                                            	10.2 Quanto maior a probabilidade de um placar ocorrer, menor a pontuação que esse reverterá.
                                            	</li>
                                            	<li>
                                            	10.3 Para cálculo da pontuação dos placares também é utilizado o índice técnico das seleções podendo ser aplicado uma redução ou acréscimo percentual que pode variar até 40%.
                                            	</li>
                                            	<li>
                                            	10.4 A pontuação máxima que um acerto em placar cheio poderá chegar é de 15 (quinze) pontos.
                                            	</li>
                                            	<li>
                                            	10.5 A pontuação do placar do vencedor ou perdedor será a metade da menor pontuação dada para o placar em que o número de gols ocorre.
                                            	</li>
                                            </ul>
                                            <h2>11. DEMAIS DISPOSIÇÕES</h2>
                                            <ul>
												<li>
                                            	11.1 Eventuais disposições não cobertas por esse regulamento deverão ser deliberadas pela CABCB e divulgadas a todos os participantes.
                                            	</li>
                                            	<li>
                                            	11.2 Eventuais aditivos poderão ser incluídos nesse regulamento em virtude de situações que venham a ocorrer e o CTBCB considere oportuno sua inclusão. Os aditivos deverão ser divulgados a todos os participantes.
                                            	</li>
                                            </ul>
                                            <h2>12. BROTHETAS</h2>
                                            <ul>
												<li>
                                            	12.1 As Brothetas é a moeda virtual do Bolão Copa Brothers 2022 utilizada para a compra de figurinhas Bolão Copa Brothers 2022.
                                            	</li>
                                            	<li>
                                            	12.2 As Brothetas não são comercializadas pois o intuito de sua existência é apenas para o uso recreativo de seus participantes.
                                            	</li>
                                            	<li>
                                            	12.3 As Brothetas serão creditadas automaticamente na conta de cada participante seguindo os critérios pré-estabelecidos abaixo:
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 a) No pagamento da Joia Ingresso - Crédito Imediato de 100 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 b) No dia que o participante logar no site - Crédito no Dia Seguinte de 10 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 c) No dia que o participante comprar novas figurinhas - Crédito no Dia Seguinte de 5 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 d) No dia que o participante criar uma nova proposta, receber uma oferta e aceitar - Crédito no Dia Seguinte de 5 Brothetas
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 e) No dia que o participante fizer uma oferta por proposta aberta e o proponente aceitar - Crédito no Dia Seguinte de 5 Brothetas
                                            			</li>
    											</ul>
    											</li>
    											<li>
                                            	12.4 Fica a critério do CGBCB (Comitê Gestor Bolão Copa Brothers) o lançamento de promoções para o crédito de Brothetas extras. Nessas situações a promoção será divulgada a todos os participantes através de notificação ou aviso no site.
                                            	</li>
                                            </ul>
                                            <h2>13. FIGURINHAS</h2>
                                            <ul>
												<li>
                                            	13.1 Os participantes com Brothetas em sua conta poderão adquirir figurinhas Bolão Copa Brothers através do site na Opção Figurinhas > Comprar Figurinhas.
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 a) A compra é limitada a 10 figurinhas de cada vez para não sobrecarregar a página que exibe as figurinhas adquiridas.
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 b) Não há limite de compras diárias, respeitando-se o saldo de Brothetas e o limite de até 10 por cada compra.
                                            			</li>
                                            	</ul>
                                            	</li>
                                            	<li>
                                            	13.2 As figurinhas adquiridas serão aleatórias e o sistema utiliza um algoritmo onde quanto maior o valor de mercado do jogador, menor a probabilidade que a figurinha sai no momento da aquisição.
                                            	</li>
                                            	<li>
                                            	13.3 As figurinhas repetidas poderão ser trocadas de duas maneiras:
                                            	<ul class="list-unstyled">
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 a) Através da Opção Figurinhas > Propostas > Oferecer Figurinha: Nesse caso o proponente deverá aguardar ofertas por sua figurinha. Se uma oferta for postada será exibido o ícone de notificação na barra superior.
                                            			</li>
    													<li>
    														<i class="ace-icon fa fa-caret-right blue"></i>
                                            				 b) Através da Opçao Figurinhas > Ofertas > Procurar Propostas : Nesse caso o ofertante deverá procurar uma proposta que o agrade. Em encontrando, clicará em Criar Oferta e poderá oferecer figurinha(s) pela troca, ou Brothetas por aquela figurinha. Será exibida notificação na barra superior com o resultado de sua oferta quando o proponente aceitar/declinar sua oferta.
                                            			</li>
                                            	</ul>
                                            	</li>
                                            	<li>
                                            	13.4 As propostas criadas poderão a qualquer momento serem fechadas pelo proponente através da opção Figurinhas > Propostas > Encerrar Proposta.
                                            	</li>
                                            	<li>
                                            	13.5 As ofertas criadas poderão a qualquer momento serem canceladas pelo ofertante através da opção Figurinhas > Ofertas > Cancelar Oferta.
                                            	</li>
                                            	<li>
                                            	13.6 O participante poderá ver seu álbum com todas as figurinhas que já possui através da opção Album que fica no canto superior direito embaixo do seu avatar/nome próximo ao botõa de logout.
                                            	</li>
                                            	<li>
                                            	13.7 Será disponibilizada opção para geração do álbum em formato PDF para os participantes que desejarem imprimir o álbum.
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