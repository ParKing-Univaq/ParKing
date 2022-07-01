{include "header.tpl"}

  <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/www/images/bg_2.jpg');" data-stellar-background-ratio="0.5">
	  <div class="overlay"></div>
	  <div class="container">
		  <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
			  <div class="col-md-9 ftco-animate pb-5">
				  <h1 class="mb-3 bread">Le tue recensioni</h1>
			  </div>
		  </div>
	  </div>
  </section>
		<section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
				{foreach $recensioni as $nomeparcheggio=>$recensione}
    			<div class="col-md-4">
    				<div class="car-wrap rounded ftco-animate">

    					<div class="text">
    						<h2 class="mb-0">Parcheggio: {$nomeparcheggio}</h2>
							<div class="d-flex mb-3">
								Valutazione: {$recensione->valutazione}
							</div>
							<div class="d-flex mb-3">
								<p class="price ml-auto">Data: {$recensione->data_scrittura|substr:0:16}</p>
							</div>
    						<a href="car-single.html" class="btn btn-secondary py-2 ml-1 btn-block" data-toggle="modal" data-target="#modalDettaglioRecensione{$recensione->id_recensione}">Dettaglio recensione</a>
    					</div>
    				</div>
    			</div>
				<div class="modal fade" id="modalDettaglioRecensione{$recensione->id_recensione}" tabindex="-1" role="dialog" aria-labelledby="modalDettaglioRecensioneTitle{$recensione->id_recensione}" aria-hidden="true">
					<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalDettaglioRecensioneTitle">Dettaglio recensione</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<ul class="list-group list-group-flush">
									<li class="list-group-item">Parcheggio: {$nomeparcheggio}</li>
									<li class="list-group-item">Valutazione: {$recensione->valutazione}</li>
									<li class="list-group-item">Descrizione: {$recensione->descrizione}</li>
								</ul>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#modalEliminaRecensione{$recensione->id_recensione}">Elimina recensione</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="modalEliminaRecensione{$recensione->id_recensione}" tabindex="-1" role="dialog" aria-labelledby="modalEliminaRecensioneTitle{$recensione->id_recensione}" aria-hidden="true">
					<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="modalEliminaRecensioneTitle">Eliminazione recensione</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Sei sicuro di voler eliminare questa recensione?
							</div>
							<div class="modal-footer">

								<input type="button" class="btn btn-primary" data-dismiss="modal" value="Annulla">
								<form action="/GestioneRecensione/eliminaRecensione" method="POST">
									<input name="idrecensione" value="{$recensione->id_recensione}" type="text" hidden>
									<input type="submit" class="btn btn-secondary" value="Prosegui">
								</form>
							</div>
						</div>
					</div>

				</div>
				{/foreach}
    		</div>
		</div>
    </section>

{include "footer.tpl"}