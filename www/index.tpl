{include "header.tpl"}

    <div class="hero-wrap ftco-degree-bg" style="background-image: url('/www/images/bg_1.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-8 ftco-animate">
          	<div class="text w-100 text-center mb-md-5 pb-md-5">
	            <h1 class="mb-4">Il miglior modo per trovare posto in citt&agrave;!</h1>
	            <p style="font-size: 18px;">Piattaforma semplice ed intuitiva per trovare il posto che fa per te</p>
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- INIZIO box ricerca -->
     <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-12	featured-top">
    				<div class="row no-gutters">
	  					<div class="col-md-4 d-flex align-items-center">
	  						<form action="/Ricerca/cercaParcheggio" class="request-form ftco-animate bg-primary" onsubmit="return validateFormRicerca()" id="formRicerca" method="POST">
		          		<h2>Cerca un posto libero</h2>
								<br/>
								<div class="form-group">
									<label for="" class="label">Citt&agrave;</label>
									<input name="citta" type="text" class="form-control" id="citta" placeholder="Città">
								</div>

								<div class="d-flex">
			    					<div class="form-group mr-2">
			                			<label for="" class="label">Data di arrivo</label>
			                			<input name="dataarrivo" type="text" class="form-control" id="book_pick_date" placeholder="Date">
			              			</div>
			              			<div class="form-group ml-2">
										<label for="" class="label">Orario di arrivo</label>
										<input name="oraarrivo" type="text" class="form-control" id="time_pick_hour" placeholder="Time">
			              			</div>
		              			</div>
								<div class="d-flex">
									<div class="form-group mr-2">
										<label for="" class="label">Data di partenza</label>
										<input name="datapartenza" type="text" class="form-control" id="book_off_date" placeholder="Date">
									</div>
									<div class="form-group ml-2">
										<label for="" class="label">Orario di partenza</label>
										<input name="orapartenza" type="text" class="form-control" id="time_off_hour" placeholder="Time">
									</div>
								</div>
								<label for="" class="label">Taglia</label>
								<div class="checkbox">
									{foreach $taglie as $taglia}
									<label style="color: white"><input type="radio" class="icheck" name="taglia" value="{$taglia}"> {$taglia}</label>
									{/foreach}
								</div>
			            <div class="form-group">
			              <input type="submit" value="CERCA" class="btn btn-secondary py-3 px-4">
			            </div>
			    			</form>
	  					</div>
	  					<div class="col-md-8 d-flex align-items-center">
	  						<div class="services-wrap rounded-right w-100">
	  							<h3 class="heading-section mb-4">Il miglior modo per trovare un posto per il tuo veicolo</h3>
	  							<div class="row d-flex mb-4">
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Scegli la città</h3>
				                </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-handshake"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Seleziona il parcheggio migliore</h3>
					              </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				              	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-rent"></span></div>
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Riserva il tuo posto</h3>
					              </div>
					            </div>      
					          </div>
					        </div>
	  						</div>
	  					</div>
	  				</div>
				</div>
  		</div>
    </section>

    <section class="ftco-section ftco-about">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(/www/images/car-8.jpg);">
					</div>
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section heading-section-white pl-md-5">
	          	<span class="subheading">About us</span>
	            <h2 class="mb-4">Benvenuto in ParKing</h2>

	            <p>Una piattaforma facile ed intuitiva per trovare il posto che fa per te!.</p>
	            <p>Progetto d'esame sviluppato da Buscaino Francesco, Capricci Matteo e Colazilli Matteo, che si pone l'obiettivo di fornire una piattaforma tramite la quale si possono mettere a disposizione di chiunque lo richieda i posteggi che si hanno. Tramite il meccanismo delle recensioni si può creare una comunity che garantisce la validità di un parcheggio in base alle esperienze passate. </p>
	            <p><a href="#" class="btn btn-primary py-3 px-4">Cerca un posto</a></p>
	          </div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section ftco-intro" style="background-image: url(/www/images/bg_3.jpg);">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-end">
					<div class="col-md-6 heading-section heading-section-white ftco-animate">
            <h2 class="mb-3">Vuoi guadagnare con il tuo parcheggio?</h2>
            <a href="/Accesso/mostraRegistrazioneGestore" class="btn btn-primary btn-lg">Diventa un Gestore</a>
          </div>
				</div>
			</div>
		</section>

    <section class="ftco-counter ftco-section img bg-light" id="section-counter">
			<div class="overlay"></div>
    	<div class="container">
    		<div class="row">
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="{$pre}">0</strong>
                <span>Prenotazioni <br>Totali</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="{$park}">0</strong>
                <span>Parcheggi <br>Totali</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="{$posti}">0</strong>
                <span>Posti <br>Totali</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text d-flex align-items-center">
                <strong class="number" data-number="{$clienti}">0</strong>
                <span>Clienti <br>Totali</span>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>
{include "footer.tpl"}