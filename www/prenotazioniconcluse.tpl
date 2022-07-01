{include "header.tpl"}

  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/www/images/bg_3.jpg');" data-stellar-background-ratio="0.5">
	  <div class="overlay"></div>
	  <div class="container">
		  <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
			  <div class="col-md-9 ftco-animate pb-5">
				  <h1 class="mb-3 bread">Le tue prenotazioni concluse</h1>
			  </div>
		  </div>
	  </div>
  </section>
	<section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
				{foreach $prenotazioni as $nomeparcheggio=>$arrayPrenotazione}
					{foreach $arrayPrenotazione as $prenotazione}
    			<div class="col-md-4">
    				<div class="car-wrap rounded ftco-animate">
    					<div class="text">
    						<h2 class="mb-0">{$nomeparcheggio}</h2>
    						<div class="d-flex mb-3">
	    						<span class="cat">Posto numero {$prenotazione->_PostoAuto->id_posto}</span>
							</div>
							<div class="d-flex mb-3">
								Taglia: {$prenotazione->_PostoAuto->_Taglia->id_taglia}
								<p class="price ml-auto">{$prenotazione->data_inizio|substr:0:10}</p>
							</div>
    						<p class="d-flex mb-0 d-block"><a href="#" class="btn btn-primary py-2 mr-1" data-toggle="modal" data-target="#modalInserisciRecensione{$prenotazione->id_prenotazione}">Recensisci</a> <a type="button" href="car-single.html" class="btn btn-secondary py-2 ml-1" data-toggle="modal" data-target="#modalDettaglioPrenotazione{$prenotazione->id_prenotazione}">Dettagli</a></p>
						</div>
    				</div>
    			</div>
				<div class="modal fade" id="modalDettaglioPrenotazione{$prenotazione->id_prenotazione}" tabindex="-1" role="dialog" aria-labelledby="modalDettaglioPrenotazioneTitle{$prenotazione->id_prenotazione}" aria-hidden="true">
					<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalDettaglioPrenotazioneTitle">Dettaglio prenotazione</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<ul class="list-group list-group-flush">
									<li class="list-group-item">{$nomeparcheggio}</li>
									<li class="list-group-item">dal {$prenotazione->data_inizio|substr:0:16}</li>
									<li class="list-group-item">al {$prenotazione->data_fine|substr:0:16}</li>
									<li class="list-group-item">{$prenotazione->_PostoAuto->_Taglia->id_taglia}</li>
									<li class="list-group-item">Servizi:
										<ul class="list-group list-group-flush">
											{foreach $prenotazione->_ServiziOpzionali as $servizio}
												<li class="list-group-item">{$servizio->nome_servizio}  {$servizio->_costo->tariffa}€</li>
											{/foreach}
										</ul>
									<li class="list-group-item">Totale: {$prenotazione->totale}€<b></b></li>
								</ul>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Chiudi</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="modalInserisciRecensione{$prenotazione->id_prenotazione}" tabindex="-1" role="dialog" aria-labelledby="modalInserisciRecensioneTitle{$prenotazione->id_prenotazione}" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modalInserisciRecensioneTitle">Inserisci recensione</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form action="/GestioneRecensione/inserimentoRecensione" method="POST" class="request-form ftco-animate">
										<div class="row">
											<label for="" class="label" style="color: black">Valutazione</label>
											<select name="valutazione" size="1" class="custom-select">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5" selected="selected">5</option>
											</select>
										</div>
										<div class="row py-2">
											<label for="" class="label" style="color: black">Descrizione</label>
											<br>
											<textarea rows="5" class="custom" cols="28" name="descrizione"></textarea>
											<input name="idprenotazione" value="{$prenotazione->id_prenotazione}" type="text" hidden>
										</div>
										<div class="modal-footer">
											<input type="submit" value="Invia" class="btn btn-primary btn-block">
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
						{/foreach}
				{/foreach}
    		</div>
		</div>
    </section>

{include "footer.tpl"}