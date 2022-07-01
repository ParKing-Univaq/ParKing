{include "header.tpl"}
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container ml-0 " style="max-width: max-content">

    <div class="row mt-5 ml-0 mr-0">
        <div class="card my-5 ">
            <!-- BEGIN SEARCH RESULT -->
            <div class="grid search">
                <div class="grid-body" >
                    <div class="row">
                        <!-- BEGIN FILTERS -->
                        <div class="col-md-3">
                            <div class="padding"></div>

                            <!-- BEGIN FILTER BY DATE -->
                            <div class="row no-gutters">
                                <form action="/ModerazioneRecensioni/mostraRecensionibyDate" class="request-form ftco-animate bg-primary" method="POST" onsubmit="return validateDate()" id="formDate">
                                    <h2>Cerca recensioni per data</h2>

                                    <div class="d-flex">
                                        <div class="form-group mr-2">
                                            <label for="" class="label">Da: </label>
                                            <input name="datainizio" type="text" class="form-control" id="book_pick_date" placeholder="Data">
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="form-group mr-2">
                                            <label for="" class="label">A:</label>
                                            <input name="datafine" type="text" class="form-control" id="book_off_date" placeholder="Date">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="CERCA" class="btn btn-secondary py-3 px-4">
                                    </div>
                                </form>
                            </div>
                            <!-- END FILTER BY DATE -->

                            <div class="padding"></div>
                        </div>
                        <!-- END FILTERS -->

                        <!-- BEGIN RESULT -->
                        <div class="col-md-9" >
                            <h2>Risultati</h2>
                            <hr>
                            <div class="padding"></div>

                            <div class="row">
                            </div>

                            <!-- BEGIN TABLE RESULT -->
                            <div class="table-responsive">

                                <table class="table table-hover">
                                    {if $recensioni != 'Nessun risultato' && $recensioni != 'Inserisci i dati per la ricerca'}
                                    {foreach $recensioni as $recensione}
                                    <tbody><tr>
                                        <td class="product"><strong>Id Recensione: {$recensione[1]->id_recensione}</strong><br><span>{$recensione[0]}</span><br>Scrittore: {$recensione[1]->_Scrittore->nome} {$recensione[1]->_Scrittore->cognome}</td>
                                        <td class="rate" style="max-width: fit-content"><span>{for $i=1 to $recensione[1]->valutazione}<i class="fa fa-star"></i>{/for}</span></td>
                                        <td data-toggle="modal" data-target="#modalDettaglioRecensione{$recensione[1]->id_recensione}" style="max-width: fit-content;text-align: center"><input type="button" class="btn btn-primary" value="Dettagli"></td>
                                    </tr>
                                    </tbody>
                                <div class="modal fade" id="modalDettaglioRecensione{$recensione[1]->id_recensione}" tabindex="-1" role="dialog" aria-labelledby="modalDettaglioRecensioneTitle{$recensione[1]->id_recensione}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDettaglioRecensioneTitle{$recensione[1]->id_recensione}">Dettaglio recensione</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">id recensione:  {$recensione[1]->id_recensione}</li>
                                                    <li class="list-group-item">Nome parcheggio: {$recensione[0]}</li>
                                                    <li class="list-group-item">Scrittore: {$recensione[1]->_Scrittore->nome} {$recensione[1]->_Scrittore->cognome}</li>
                                                    <li class="list-group-item"><span>{for $i=1 to $recensione[1]->valutazione}<i class="fa fa-star"></i>{/for}</span></li>
                                                    <li class="list-group-item">Descrizione: {$recensione[1]->descrizione} </li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"  class="btn btn-danger btn-block" data-dismiss="modal" data-toggle="modal" data-target="#modalEliminaRecensione{$recensione[1]->id_recensione}" >Elimina</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalEliminaRecensione{$recensione[1]->id_recensione}" tabindex="-1" role="dialog" aria-labelledby="modalEliminaRecensioneTitle{$recensione[1]->id_recensione}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEliminaRecensioneTitle{$recensione[1]->id_recensione}">Eliminazione recensione</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Sei sicuro di voler eliminare questa recensione?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="/ModerazioneRecensioni/eliminaRecensione" method="POST">
                                                    <input name ="id_recensione" type="text" hidden="hidden" value="{$recensione[1]->id_recensione}">
                                                    <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annulla">
                                                    <input type="submit" class="btn btn-secondary" value="Prosegui">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    {/foreach}
                                    {else}
                                        <tbody><tr>
                                            <td class="product"><strong>{$recensioni}</strong><br><span></span><br></td>
                                           </tr>
                                        </tbody>{/if}
                                </table>
                            </div>
                            <!-- END TABLE RESULT -->
                        </div>
                        <!-- END RESULT -->
                    </div>
                </div>
            </div>
        </div>
        <form class="mt-5 mb-5 ml-5"action="/Areapersonale/logout" method="POST">
            <div class="row d-inline-flex">
                <button type="submit" class="btn btn-danger">Logout</button>
            </div>
        </form>
        <!-- END SEARCH RESULT -->
    </div>
</div>
</div>

{include "footer.tpl"}