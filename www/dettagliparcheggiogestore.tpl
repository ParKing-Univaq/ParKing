{include "header.tpl"}
    
    <section class="ftco-section ftco-car-details">
      <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="car-details">
					<div class="text text-center">
						<span class="subheading">Citt&agrave;: {$parcheggio->_Locazione->citta}</span>
						<h2>{$parcheggio->nome_parcheggio}</h2>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="carousel-car owl-carousel">
							{foreach $parcheggio->_Immagini as $immagine}
								<div class="item">
									<div class="car-wrap rounded ftco-animate">
										<img class="img rounded d-flex align-items-end" src="data:{$immagine->estensione};base64,{$immagine->image}" alt="Immagine Parcheggio" />
									</div>
								</div>
							{/foreach}
							</div>
						</div>
					</div>
					<div class="row pt-4 justify-content-center">
						<div class="col-md-4 offset-md-2 col-sm-4 offset-sm-2 col-xs-4 offset-xs-2 py-2">
							<input type="button" data-toggle="modal" data-target="#modalAggiungiImmagine" value="Aggiungi immagine" class="btn btn-secondary ">
						</div>
						<div class="col-md-4 offset-md-1 col-sm-4 offset-sm-1 col-xs-4 offset-xs-1 py-2">
							<input type="button" data-toggle="modal" data-target="#modalRimuoviImmagine" value="Rimuovi immagine" class="btn btn-danger ">
						</div>
						<div name ="modalAggiungiImmagine" id="modalAggiungiImmagine" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAggiungiImmagineTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-scrollable" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalAggiungiImmagineTitle">Aggiungi immagini</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="aggiungiImmagine" action="/GestioneParcheggi/addImmagine" enctype="multipart/form-data" method="POST">
									<div class="modal-body">
											<input type="file" name="img" />
									</div>
									<div class="modal-footer" >
										<input class="btn btn-secondary btn-block" type="submit" value="Aggiungi">
									</div>
									</form>
								</div>
							</div>
						</div>
						<div class="modal fade" id="modalRimuoviImmagine" tabindex="-1" role="dialog" aria-labelledby="modalRimuoviImmagineTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-scrollable" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalRimuoviImmagineTitle">Rimuovi immagine</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="/GestioneParcheggi/rimuoviImmagine" method="POST">
									<div class="modal-body">
											<div class="table-responsive-sm">
												<table>
													<tr>
														<div class="checkbox">
															{foreach $parcheggio->_Immagini as $immagine}
																<label style="color: grey"><input type="radio" class="icheck" name="id_img" value="{$immagine->id_img}"> {$immagine->nome}</label>
															{/foreach}
														</div>
													</tr>
												</table>
											</div>
									</div>
									<div class="modal-footer" >
										<input class="btn btn-danger btn-block" type="submit" value="Rimuovi">
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="row">
				<div class="col-md d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services">
						<div class="media-body py-md-4">
							<div class="d-flex mb-3 align-items-center">
								<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-pistons"></span></div>
								<div class="text">
									<h3 class="heading mb-0 pl-3">Nome Gestore<span>{$parcheggio->_Proprietario->nome} {$parcheggio->_Proprietario->cognome}</span></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services">
					  <div class="media-body py-md-4">
						<div class="d-flex mb-3 align-items-center">
							<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
							<div class="text">
									<h3 class="heading mb-0 pl-3">
										Indirizzo
										<span>Via {$parcheggio->_Locazione->via} {$parcheggio->_Locazione->num_civico}, {$parcheggio->_Locazione->cap}, {$parcheggio->_Locazione->citta}({$parcheggio->_Locazione->provincia})</span>
									</h3>
							</div>
						</div>
					  </div>
					</div>
				</div>
				<div class="col-md d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services">
						<div class="media-body py-md-4">
							<div class="d-flex mb-3 align-items-center">
								<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car"></span></div>
								<div class="text">
								<h3 class="heading mb-0 pl-3">
								Id Parcheggio
								<span>{$parcheggio->id_parcheggio}</span>
							</h3>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services">
						<div class="media-body py-md-4">
							<div class="d-flex mb-3 align-items-center">
								<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-dashboard"></span></div>
								<div class="text">
								<h3 class="heading mb-0 pl-3">
								Orario apertura
								<span>{$parcheggio->orario_apertura}</span>
							</h3>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md d-flex align-self-stretch ftco-animate">
					<div class="media block-6 services">
						<div class="media-body py-md-4">
							<div class="d-flex mb-3 align-items-center">
								<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-dashboard"></span></div>
								<div class="text">
									<h3 class="heading mb-0 pl-3">Orario chiusura<span>{$parcheggio->orario_chiusura}</span></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<input type="button" data-toggle="modal" data-target="#modalModificaDati" value="Modifica tariffa" class="btn btn-primary ">
			<div class="modal fade" id="modalModificaDati" tabindex="-1" role="dialog" aria-labelledby="modalModificaDatiTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modalModificaDatiTitle">Modifica tariffa</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="/GestioneParcheggi/modificaTariffa" method="POST">
							<div class="modal-body">
								<table class="table-responsive-sm" style="text-align: center; column-width: max-content">
									<thead >
									<th>
										Taglia posto
									</th>
									<th>
										Tariffa base (€)
									</th>
									<th>
										# Posti
									</th>
									</thead>
									<tbody>
									{foreach $params as $taglia=>$param}
										<tr>
											<td>{$taglia}</td>
											<td><input type="number" maxlength="5" id="{$taglia}" name="{$taglia}" value="{$param[1]}" {if $param[1]!=0}min="0.1"{/if} max="100" step="0.1" {if $param[1]==0}readonly{/if} ></td>
											<td><p>{$param[0]}</p></td>
										</tr>
									{/foreach}
									</tbody>
								</table>
							</div>
							<div class="modal-footer" >
								<input class="btn btn-secondary btn-block" type="submit" value="Modifica">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-12 pills">
				<div class="bd-example bd-example-tabs">
					<div class="d-flex justify-content-center">
					  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Servizi</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill" href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer" aria-expanded="true">Descrizione</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Recensioni</a>
						  </li>
					  </ul>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
							<div class="row justify-content-center">
							  <div class="col-md-4">
								  <ul class="features">
									  <h5 class="text heading mb-0 pl-3">Inclusi</h5>
									  {foreach $parcheggio->_Servizi as $servizio}
										  {if !is_a($servizio,EServizioOpzionale)}
											  <li class="check"><span class="ion-ios-checkmark"></span>{$servizio->nome_servizio}</li>
										  {/if}
									  {/foreach}
								  </ul>
							  </div>
							  <div class="col-md-4">
								  <ul class="features">
									  <h5 class="text heading mb-0 pl-3">Opzionali</h5>
									  {foreach $parcheggio->_Servizi as $servizio}
										  {if is_a($servizio,EServizioOpzionale)}
											  <li class="check"><span class="ion-ios-checkmark"></span>{$servizio->nome_servizio} 	{$servizio->_costo->tariffa}€</li>
										  {/if}
									  {/foreach}
								  </ul>
							  </div>
						  	</div>
							<div class="row col-12 mx-auto py-4 justify-content-center" >
								<div class="col-md-4 offset-md-2 col-sm-4 offset-sm-2 col-xs-4 offset-xs-2 py-2">
									<input type="button" data-toggle="modal" data-target="#modalAggiungiServizio" value="Aggiungi servizio" class="btn btn-secondary ">
								</div>
								<div class="col-md-4 offset-md-1 col-sm-4 offset-sm-1 col-xs-4 offset-xs-1 py-2">
									<input type="button" data-toggle="modal" data-target="#modalRimuoviServizio" value="Rimuovi servizio" class="btn btn-danger ">
								</div>
							</div>
							<div class="modal fade" id="modalAggiungiServizio" tabindex="-1" role="dialog" aria-labelledby="modalAggiungiServizioTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-scrollable" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="modalAggiungiServizioTitle">Dettagli servizio</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form id="aggiungiServizio" action="/GestioneParcheggi/addServizio" method="POST">
										<div class="modal-body">
												<label for="nservizio">Nome:</label><br>
												<input type="text" id="nservizio" name="nome_servizio" ><br>
												<label for="isopzionale">Opzionale:</label>
												<input type="checkbox" id="isopzionale" name="is_opzionale" onclick="var input = document.getElementById('costo');
													if(this.checked){
														input.disabled = false;
														input.focus();
													}else{
													input.disabled=true;
													}"><br>
												<label for="costo">Costo aggiuntivo (€):</label>
												<input type="text" id="costo" name="costo" disabled="disabled" ><br><br>
										</div>
										<div class="modal-footer" >
											<input class="btn btn-secondary btn-block" type="submit" value="Aggiungi">
										</div>
										</form>
									</div>
								</div>
							</div>
							<div class="modal fade" id="modalRimuoviServizio" tabindex="-1" role="dialog" aria-labelledby="modalAggiungiServiziTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-scrollable" role="document">
								  <div class="modal-content">
									  <div class="modal-header">
										  <h5 class="modal-title" id="modalAggiungiServiziTitle">Rimuovi servizio</h5>
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
										  </button>
									  </div>
									  <form action="/GestioneParcheggi/rimuoviServizio" method="POST">
										  <div class="modal-body">
											  <select name="servizi_rimossi">
												  <optgroup label="Opzionali">
													  {foreach $parcheggio->_Servizi as $servizio}
														  {if is_a($servizio,EServizioOpzionale)}
															  <option value="{$servizio->id_servizio}"> {$servizio->nome_servizio} </option>
														  {/if}
													  {/foreach}
												  </optgroup>
												  <optgroup label="Inclusi">
													  {foreach $parcheggio->_Servizi as $servizio}
														  {if !is_a($servizio,EServizioOpzionale)}
															  <option value="{$servizio->id_servizio}"> {$servizio->nome_servizio} </option>
														  {/if}
													  {/foreach}
												  </optgroup>
											  </select>
										  </div>
										  <div class="modal-footer" >
											  <input class="btn btn-danger btn-block" type="submit" value="Rimuovi">
										  </div>
									  </form>
								  </div>
							  </div>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
							<div class="row justify-content-center">
								<div class="col-md-12"><p>{$parcheggio->descrizione}</p></div>
								<div class="form-group ">
									<input type="button" data-toggle="modal" data-target="#modalDescrizione" value="Modifica descrizione" class="btn btn-primary ">
								</div>
							</div>
							<div class="modal fade" id="modalDescrizione" tabindex="-1" role="dialog" aria-labelledby="modalADescrizioneTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-scrollable" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="modalADescrizioneTitle">Modifica descrizione</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="/GestioneParcheggi/modificaDescrizione" method="POST">
												<div class="modal-body">
													<textarea name="descrizione"
														  cols="31"
														  rows="7" id="descrizione">{$parcheggio->descrizione}
													</textarea>
												</div>
												<div class="modal-footer" >
													<input class="btn btn-secondary btn-block" type="submit" value="Modifica">
												</div>
											</form>
										</div>
									</div>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
							  <div class="row justify-content-center">
									<h3 class="head">Reviews</h3>
                                  {if $recensioni != false}
									{foreach $recensioni as $recensione}
										<div class="review d-flex">
											<div class="desc">
												<h4>
													<span class="text-left">{$recensione->_Scrittore->nome} {$recensione->_Scrittore->cognome}</span>
													<span class="text-right">{$recensione->data_scrittura}</span>
												</h4>
												<p class="star">
													<span>
														{for $i=1 to $recensione->valutazione}
															<i class="ion-ios-star"></i>
														{/for}
													</span>
													<span class="text-right">
														<input type="button" data-toggle="modal" data-target="#modalRisposta" value="Rispondi" class="btn btn-secondary ">
													</span>
												</p>
												<p>{$recensione->descrizione}</p>
												<div class="modal fade" id="modalRisposta" tabindex="-1" role="dialog" aria-labelledby="modalRispostaTitle" aria-hidden="true">
													<div class="modal-dialog modal-dialog-scrollable" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="modalRispostaTitle">Rispondi</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<form action="/GestioneParcheggi/rispondi" method="POST">
																<h5 class="ml-3 mt-3">Scrivi la tua risposta</h5>
																<div class="modal-body">
																	<textarea name="risposta"
																			  cols="31"
																			  rows="7" id="risposta"></textarea>
																	<input name ="id_recensione" type="text" hidden="hidden" value="{$recensione->id_recensione}">
																</div>
																<div class="modal-footer" >
																	<input class="btn btn-secondary btn-block" type="submit" value="Rispondi">
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									{/foreach}
                                  {else}
                                      <div class="review d-flex">
                                          <div class="desc">
                                              <h4>Nessuna recensione</h4>
                                          </div>
                                      </div>
                                  {/if}
							  </div>
						</div>
					</div>
				</div>
			</div>
	  	</div>
	  </div>
    </section>

{include "footer.tpl"}