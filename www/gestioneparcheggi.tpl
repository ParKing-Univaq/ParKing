{include "header.tpl"}

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 align-content-center border-right mx-auto">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" alt=" Errore caricamento immagine" src="data:{$gestore->_img->estensione};base64,{$gestore->_img->image}">
                <span class="font-weight-bold">{$gestore->nome} {$gestore->cognome}</span>
                <span class="text-black-50">{$gestore->email}</span>
                <span> </span></div>
        </div>
        <div class="mx-auto">
            <div class="p-3 py-5 align-items-center">
                <div class="d-flex align-items-center mb-5">
                    <h4 class="text mx-auto">Gestione parcheggi</h4>
                </div>
                {foreach $parcheggi as $parcheggio}
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 car-wrap rounded">
                            <img class="rounded-circle mt-5" size="fit-content" alt=" Errore caricamento immagine" src="data:{$parcheggio->_Immagini[0]->estensione};base64,{$parcheggio->_Immagini[0]->image}">
                            <div class="text">
                                <h2 class="mb-0"><a href="dettagliparcheggiogestore.tpl">{$parcheggio->nome_parcheggio}</a></h2>
                                <div class="d-flex mb-3">
                                    <span class="cat">Via {$parcheggio->_Locazione->via} {$parcheggio->_Locazione->num_civico}, {$parcheggio->_Locazione->cap}, {$parcheggio->_Locazione->citta}({$parcheggio->_Locazione->provincia})</span>
                                </div>
                                <div class="d-flex align-content-center"><p class="ion-md-time">Apertura <span>hh:ii</span></p></div>
                                <div class="d-flex align-content-center"><p class="ion-ios-time">Chiusura <span>hh:ii</span></p></div>
                                <a href="dettagliparcheggiogestore.tpl" class="btn btn-primary btn-block">Dettagli parcheggio</a>
                            </div>
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>

    </div>
</div>

{include "footer.tpl"}