{include 'header.tpl'}
<section class="ftco-section ftco-car-details">
	<div class="container">
		<div class="py-4">
			<h2 style="text-info text-align: center">Riepilogo prenotazione</h2>
			<div class="mx-auto">
				<ul class="list-group list-group-flush">
					<li class="list-group-item"><span>Nome parcheggio:</span> {$parcheggio->nome_parcheggio}</li>
					<li class="list-group-item"><span>Indirizzo:</span> Via {$parcheggio->_Locazione->via} {$parcheggio->_Locazione->num_civico}, {$parcheggio->_Locazione->cap}, {$parcheggio->_Locazione->citta}({$parcheggio->_Locazione->provincia}) </li>
					<li class="list-group-item"><span>Arrivo: </span>{$info_prenotazione['dataarrivo']} {$info_prenotazione['oraarrivo']}</li>
					<li class="list-group-item"><span>Partenza: </span>{$info_prenotazione['datapartenza']} {$info_prenotazione['orapartenza']}</li>
					<li class="list-group-item"><span>Tipologia veicolo: </span>{$info_prenotazione['taglia']} </li>
					<li class="list-group-item"><span>Tariffa oraria: </span>{$posto->_TariffaBase->tariffa} €</li>
					<li class="list-group-item"><span>Servizi inclusi: </span></li>
					{foreach $parcheggio->_Servizi as $servizio}
						{if !is_a($servizio,EServizioOpzionale)}
						<ul class="list-group list-group-flush">
							<li class="list-group-item">{$servizio->nome_servizio}</li></ul>
						{/if}
					{/foreach}
					{if $servizi_opz != false}
					<li class="list-group-item "><span>Servizi opzionali: </span></li>
					{foreach $servizi_opz as $servizio}
							<ul class="list-group list-group-flush">
								<li class="list-group-item">{$servizio->nome_servizio}  {$servizio->_costo->tariffa}€</li></ul>
					{/foreach}
					{/if}

					<li class="list-group-item font-weight-bold alert-danger ">Totale {$costo_totale} € </li>
				</ul>
			</div>
		</div>
		<div class="row row-cols-2 py-3">
			<div class="col-6 d-flex justify-content-end">
				<form action="/Ricerca/cercaParcheggio" method="POST">
					<input type="submit" class="btn btn-primary" value="Torna alla pagina di ricerca">
				</form>
			</div>
			<div class="col-6 d-flex justify-content-start text-info">
				{if $id_utente != false}
					{if $tipo_utente == "ECliente"}
					<form  action="/Ricerca/confermaPrenotazione" method="POST">
						<input type="submit" class="btn btn-secondary" value="Prenota posto" >
					</form>
					{else}
						<div class="text-info">Per effettuare la prenotazione esegui il login come cliente</div>
					{/if}
				{else}
					<input type="button"  data-toggle="modal" class="btn btn-secondary"  data-target="#modalRedirectLogin" value="Prenota posto" >
				{/if}
			</div>
		</div>
		<div class="modal fade" id="modalRedirectLogin" tabindex="-1" role="dialog" aria-labelledby="modalRedirectLoginTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalRedirectLoginTitle">Reindirizzamento al login</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<h4 class="text-info">Effettua il login per proseguire con la prenotazione.</h4>
					</div>
					<div class="modal-footer" >
						<div class="col-12 d-flex justify-content-center">
								<form action="/Accesso/mostraLogin" method="POST">
									<input type="submit" data-target="#form_opzionali" class="btn btn-primary btn-block" value="Vai al login">
								</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
{include 'footer.tpl'}