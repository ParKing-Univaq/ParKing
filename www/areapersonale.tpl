{include "header.tpl"}

<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><span class="font-weight-bold">{$user}</span><img class="rounded-circle mt-5" width="150px" src="data:{$type};base64,{$pic64}" alt="immagine profilo" /><span class="font-weight-bold">{$nome}</span><span class="font-weight-bold">{$cognome}</span><span class="text-black-50">{$email}</span><span> </span>
                <form action="/Areapersonale/logout" method="POST">
                    <div class="row d-inline-flex">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h4 class="text-right">Gestione attività</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <form action="/GestioneRecensione/prenotazioniConcluse" method="POST">
                        <button type="submit" class="btn btn-primary">Prenotazioni concluse</button>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <form action="/GestionePrenotazione/mostraPrenotazioniFuture" method="POST">
                        <button type="submit" class="btn btn-primary">Prenotazioni future</button>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="/GestioneRecensione/mostraRecensioni" method="POST">
                        <button type="submit" class="btn btn-primary">Recensioni</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h4 class="text-right">Impostazioni del profilo</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <form action="/Areapersonale/modificaEmail" method="POST">
                        <div class="row d-inline-flex">
                            <input name="email" type="text" class="form-control mb-2" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{literal}{2,4}{/literal}$">
                            <button type="submit" class="btn btn-primary">Modifica Email</button>
                        </div>
                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <form action="/Areapersonale/modificaPassword" method="POST">
                        <div class="row d-inline-flex">
                            <input name="oldpassword" type="password" class="form-control mb-2" placeholder="{$errore}" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{literal}{8,}{/literal}">
                            <input name="newpassword"type="password" class="form-control mb-2" placeholder="Nuova password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{literal}{8,}{/literal}">
                            <button type="submit" class="btn btn-primary">Modifica Password</button>
                        </div>

                    </form>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <form action="/Areapersonale/modificaImmagineProfilo" enctype="multipart/form-data" method="POST" id="formImg" onsubmit="return validateImg()">
                        <div class="row d-inline-flex">
                            <input name="img" class="form-control mb-2" type="file" id="formFile">
                            <button type="submit" class="btn btn-primary">Modifica Immagine</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{include "footer.tpl"}