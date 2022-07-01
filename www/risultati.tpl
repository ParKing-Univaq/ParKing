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
                                            <form action="/Ricerca/cercaParcheggio" class="request-form ftco-animate bg-primary" onsubmit="return validateFormRicerca()" id="formRicerca" method="POST">
                                                <h2>Ricerca</h2>
                                                <br/>
                                                <div class="form-group">
                                                    <label for="" class="label">Citt&agrave;</label>
                                                    <input type="text" name="citta" class="form-control" id="citta" value="{$parametri_ricerca['citta']}">
                                                </div>

                                                <div class="d-flex">
                                                    <div class="form-group mr-2">
                                                        <label for="" class="label">Data di arrivo</label>
                                                        <input type="text" name="dataarrivo" class="form-control" id="book_pick_date" value="{$parametri_ricerca['dataarrivo']}">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="" class="label">Orario di arrivo</label>
                                                        <input type="text" name="oraarrivo" class="form-control" id="time_pick_hour" value="{$parametri_ricerca['oraarrivo']}">
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="form-group mr-2">
                                                        <label for="" class="label">Data di partenza</label>
                                                        <input type="text" name="datapartenza" class="form-control" id="book_off_date" value="{$parametri_ricerca['datapartenza']}">
                                                    </div>
                                                    <div class="form-group ml-2">
                                                        <label for="" class="label">Orario di partenza</label>
                                                        <input type="text" name="orapartenza" class="form-control" id="time_off_hour" value="{$parametri_ricerca['orapartenza']}">
                                                    </div>
                                                </div>
                                                <label for="" class="label">Taglia</label>

                                                        <div class="checkbox">

                                                            {foreach $taglie as $taglia}
                                                            <label style="color: white"><input name="taglia" type="radio" class="icheck" value="{$taglia}" {if $taglia==$parametri_ricerca['taglia']}checked="checked"{/if} > {$taglia}</label>
                                                            {/foreach}
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
                                {if $risultati != false}
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        {foreach $risultati as $idPosto=>$costoPostoParcheggio}
                                            <tbody>
                                                <tr>
                                                    <td class="image"><img class="img rounded " width="100px" height="100px" src='data:{$costoPostoParcheggio[2]->_Immagini[0]->estensione};base64,{$costoPostoParcheggio[2]->_Immagini[0]->image}'  alt="Red dot"></td>
                                                    <td class="product"><strong>{$costoPostoParcheggio[2]->nome_parcheggio}</strong>
                                                        <br>{$costoPostoParcheggio[2]->descrizione}. Tariffa oraria: {$costoPostoParcheggio[1]->_TariffaBase->tariffa} € </td>
                                                    <form action="/Ricerca/selezionaParcheggio" id="formTariffa" method="POST">
                                                        <td class="price" style="width: 100px" onclick="getElementById('submitButton').click()">
                                                            <input name="id_parcheggio" value="{$costoPostoParcheggio[2]->id_parcheggio}" type="text" hidden>
                                                            <input name="id_posto" value="{$costoPostoParcheggio[1]->id_posto}" type="text" hidden>
                                                            <input name="costo_totale" value="{$costoPostoParcheggio[0]}" type="text" hidden>
                                                            {$costoPostoParcheggio[0]} €
                                                            <button type="submit" id="submitButton" hidden>
                                                        </td>
                                                    </form>
                                                </tr>
                                            </tbody>
                                        {/foreach}
                                    </table>

                                </div>
                                    {else}
                                    <h3 class="text-info">La ricerca non ha prodotto alcun risultato. Riprova.</h3>
                                {/if}
                                <!-- END TABLE RESULT -->

                            </div>
                            <!-- END RESULT -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SEARCH RESULT -->
        </div>
    </div>

{include "footer.tpl"}