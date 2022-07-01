{include "header.tpl"}
    <section class="ftco-section ftco-car-details">
      <div class="container">
		  <div class="row justify-content-center">
			  <div class="col-md-12">
				  <div class="car-details">
					  <div class="text text-center">
						  <span class="subheading">{$parcheggio->_Locazione->citta}</span>
						  <h2>{$parcheggio->nome_parcheggio}</h2>
					  </div>
					  <div class="row">
						  <div class="col-md-12">
							  <div class="carousel-car owl-carousel">
								  {foreach $parcheggio->_Immagini as $immagine}
									  <div class="item">
										  <div class="car-wrap rounded ftco-animate">
											 <img class="img rounded d-flex align-items-end" alt="Immagine parcheggio"  src="data:{$immagine->estensione};base64,{$immagine->image}">
										  </div>
									  </div>
								  {/foreach}
							  </div>
						  </div>
					  </div>
				  </div>
			  </div>
		  </div>
		  <div class="row">
			  <div class="col-md d-flex align-self-stretch ftco-animate">
				  <div class="media block-6 services">
					  <div class="media-body py-md-4">
						  <div class="d-flex mb-3 align-items-center">
							  <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-pistons"></span></div>
							  <div class="text">
								  <h3 class="heading mb-0 pl-3">
									  Nome Gestore
									  <span>{$parcheggio->_Proprietario->nome} {$parcheggio->_Proprietario->cognome}</span>
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
								  <h3 class="heading mb-0 pl-3">
									  Orario chiusura
									  <span>{$parcheggio->orario_chiusura}</span>
								  </h3>
							  </div>
						  </div>
					  </div>
				  </div>
			  </div>
		  </div>
		  <div class="row">
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
						    </div>

						    <div class="tab-pane fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
								{$parcheggio->descrizione}
						    </div>

						    <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
								<div class="row">
							   		<div class="col-md-12">
										{if $recensioni!=false}
							   			<h3 class="head">{count($recensioni)} recensione/i:</h3>
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

													</p>
													<p>{$recensione->descrizione}</p>
												</div>
											</div>
										{/foreach}
											{else} <span class="text-info">Il parcheggio non è stato recensito finora.</span>
										{/if}
									</div>
							   	</div>
						    </div>
						  </div>
						</div>
			</div>
		  </div>
		  <div class="row">
			  <div class="col-12 d-flex justify-content-center py-3">
				  <div class="pr-4">
					  <form action="/Ricerca/cercaParcheggio" method="post">
						  <input type="submit" class="btn btn-primary" value="Torna alla pagina di ricerca">
					  </form>
				  </div>
				  <div class="pl-4">
					  <input type="button" data-toggle="modal" data-target="#modalPrenotazione" value="Prenota posto" class="btn btn-secondary">
				  </div>
				  <div class="modal fade" id="modalPrenotazione" tabindex="-1" role="dialog" aria-labelledby="modalPrenotazioneTitle" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-scrollable" role="document">
						  <div class="modal-content">
							  <div class="modal-header">
								  <h5 class="modal-title" id="modalPrenotazioneTitle">Dettagli prenotazione</h5>
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
								  </button>
							  </div>
							  <div class="modal-body">
								  <div class="card" >
									  <table class="table-active bg-white table-info" style="grid-auto-columns: auto;align-self: center;text-align: center;size:auto" >
										  <thead class="font-weight-bold">
										  <tr>
											  <td>Taglia</td><td>Arrivo</td><td>Partenza</td>
										  </tr>
										  </thead>
										  <tr>
											  <td>{$parametri_ricerca['taglia']}</td><td>{$parametri_ricerca['dataoraarrivo']|substr:0:16}</td><td>{$parametri_ricerca['dataorapartenza']|substr:0:16}</td>
										  </tr>
									  </table>
								  </div>
								  <div class="pt-3">
									  <form method="post" id="form_opzionali" action="/Ricerca/riepilogoPrenotazione">
									  <span>Scegli i servizi opzionali: </span>
										  <table class="align-content-start" style="grid-auto-columns: auto;text-align: center">
											  {foreach $parcheggio->_Servizi as $servizio}
												  {if is_a($servizio,EServizioOpzionale)}
													  <tr>
														  <td><input type="checkbox" id="servizio" name="{$servizio->id_servizio}"></td><td><label for="servizio">{$servizio->nome_servizio}</label></td><td>+{$servizio->_costo->tariffa}€</td>
													  </tr>
												  {/if}
											  {/foreach}
										  </table>
								  </div>
							  </div>
							  <div class="modal-footer" >
								  <input type="submit" data-target="#form_opzionali" class="btn btn-primary btn-block" value="Vai al riepilogo">
							  </div>
							  </form>
						  </div>
					  </div>
				  </div>
			  </div>
		  </div>
	  </div>

    </section>


{include "footer.tpl"}