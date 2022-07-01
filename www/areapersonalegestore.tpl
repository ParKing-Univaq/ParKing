{include "header.tpl"}

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 align-content-center border-right mx-auto">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <span class="font-weight-bold">{$user}</span>
                <img class="rounded-circle mt-5" width="150px" src="data:{$type};base64,{$pic64}" alt="immagine profilo" />
                <span class="font-weight-bold">{$nome}</span>
                <span class="font-weight-bold">{$cognome}</span>
                <span class="text-black-50">{$email}</span>
                <span> </span>
                <form action="/Areapersonale/logout" method="POST">
                    <div class="row d-inline-flex py-3">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9 mx-auto">
            <div class="p-3 py-5 align-items-center">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h4 class="text-right">Gestione parcheggi</h4>
                </div>
                <div class="container">
                    {if $parcheggi == 'Non ci sono parcheggi disponibili, contattare i responsabili per inserire di un parcheggio'}
                    <div class="row">
                        <div class="col-md-20">
                            <div class="car-wrap rounded ftco-animate fadeInUp ftco-animated">
                                <div class="text">{$parcheggi}</div>
                            </div>
                        </div>
                    </div>{else}
                    <div class="row">
                    {foreach $parcheggi as $parcheggio}
                        <div class="pr-3">
                            <div class="car-wrap rounded ftco-animate fadeInUp ftco-animated">
                                <img class="img rounded d-flex align-items-end" src="data:{$parcheggio->_Immagini[0]->estensione};base64,{$parcheggio->_Immagini[0]->image}" alt="Immagine Parcheggio" />
                                <div class="text">
                                    <h2 class="mb-0"><a href="car-single.html">{$parcheggio->nome_parcheggio}</a></h2>
                                    <div class="d-flex mb-3">
                                        <span class="mb-1">Indirizzo: {$parcheggio->_Locazione->citta}, via {$parcheggio->_Locazione->via}, civico {$parcheggio->_Locazione->num_civico} </span>
                                    </div>
                                    <div class="d-flex align-content-center"><p class="ion-md-time">Apertura: {$parcheggio->orario_apertura} <span></span></p></div>
                                    <div class="d-flex align-content-center"><p class="ion-ios-time">Chiusura: {$parcheggio->orario_chiusura} <span></span></p></div>
                                    <form action="/GestioneParcheggi/dettagliParcheggio" method="POST">
                                        <input name="idparcheggio" value="{$parcheggio->id_parcheggio}" type="text" hidden>
                                        <input type="submit" class="btn btn-primary btn-block" value="Dettagli parcheggio">
                                    </form>
                                </div>
                            </div>
                        </div>
                    {/foreach}{/if}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{include "footer.tpl"}