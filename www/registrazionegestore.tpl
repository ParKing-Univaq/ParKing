{include "header.tpl"}

<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <div class="card my-5">
                <h2 class="text-center text-dark mt-5">Registrati come gestore</h2>
                <form action="/Accesso/registrazioneGestore" method="POST" " enctype="multipart/form-data"class="card-body cardbody-color p-lg-5" onsubmit="return validateForm()" id="formregistrazione">
                    <div class="mb-3">
                        <input name="nome" type="text" class="form-control" placeholder="Nome" id="nome">
                    </div>
                    <div class="mb-3">
                        <input name="cognome" type="text" class="form-control" placeholder="Cognome" id="cognome">
                    </div>
                    <div class="mb-3">
                        <input name="username" type="text" class="form-control" placeholder="Username" id="username">
                    </div>
                    <div class="mb-3">
                        <input name="email"type="text" class="form-control" placeholder="Email" {literal}pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"{/literal} id="mail">
                    </div>
                    <div class="mb-3">
                        <input name="password" id="password1" type="password" class="form-control" placeholder="Password" {literal}pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"{/literal}>
                    </div>
                    <div class="mb-3">
                        <input id="password2" type="password" class="form-control" placeholder="Ripeti password" {literal}pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"{/literal}>
                    </div>
                    <div class="mb-3">
                        <label>Inserisci immagine</label>
                        <input name="img" class="form-control mb-2" type="file" id="immagine">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5 mb-5 w-100">Registrati come gestore</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{include "footer.tpl"}