{include "header.tpl"}
  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/www/images/bg_3.jpg');" data-stellar-background-ratio="0.5">
	  <div class="overlay"></div>
	  <div class="container">
		  <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
			  <div class="col-md-9 ftco-animate pb-5">
				  <h1 class="mb-3 bread">Le tue prenotazioni future</h1>
			  </div>
		  </div>
	  </div>
  </section>
	<section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
				{foreach $prenotazioni as $nomeparcheggio=>$arrayPrenotazioni}
					{foreach $arrayPrenotazioni as $prenotazione}
    			<div class="col-md-4">
    				<div class="car-wrap rounded ftco-animate">

    					<div class="text">
    						<h2 class="mb-0">{$nomeparcheggio}</h2>
							<div class="d-flex mb-3">
								Taglia: {$prenotazione->_PostoAuto->_Taglia->id_taglia}
								<p class="price ml-auto">{$prenotazione->data_inizio|substr:0:10}</p>
							</div>
    						<p class="d-flex mb-0 d-block"><a data-toggle="modal" data-target="#modalDettaglioPrenotazione{$prenotazione->id_prenotazione}" class="btn btn-primary py-2 mr-1">Dettagli</a> <a class="btn btn-danger py-2 mr-1 active" data-toggle="modal" data-target="#modalAnnullaPrenotazione{$prenotazione->id_prenotazione}">Elimina</a></p>
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
									<li class="list-group-item">Taglia: {$prenotazione->_PostoAuto->_Taglia->id_taglia}</li>
									<li class="list-group-item">Servizi:
										<ul class="list-group list-group-flush">
											{foreach $prenotazione->_ServiziOpzionali as $servizio}
												<li class="list-group-item">{$servizio->nome_servizio} {$servizio->_costo->tariffa}</li>
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
				<div class="modal fade" id="modalAnnullaPrenotazione{$prenotazione->id_prenotazione}" tabindex="-1" role="dialog" aria-labelledby="modalAnnullaPrenotazioneTitle{$prenotazione->id_prenotazione}" aria-hidden="true">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modalAnnullaPrenotazioneTitle">Annullamento prenotazione</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Sei sicuro di voler annullare questa prenotazione?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Annulla</button>
									<form action="/GestionePrenotazione/eliminaPrenotazione" method="POST">
										<input name="idprenotazione" value="{$prenotazione->id_prenotazione}" type="text" hidden>
										<input type="submit" class="btn btn-secondary" value="Prosegui">
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