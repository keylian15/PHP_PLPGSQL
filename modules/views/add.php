<div class="dtitle w3-container w3-teal">
    Création d'un nouveau module
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de création</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Numéro Module</b></label>
                            <input type="text" id="nummod" name="nummod" placeholder="Entrer un Numéro de Module" value="<?= htmlspecialchars($module->nummod ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id="nommod" name="nommod" placeholder="Entrer un Nom" value="<?= htmlspecialchars($module->nommod ?? "") ?>">
                        </div>
                        
                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Coefficient</b></label>
                            <input type="text" id="coefmod" name="coefmod" placeholder="Entrer un coefmod" value="<?= htmlspecialchars($module->coefmod > 0 ? $module->coefmod : "") ?>">
                        </div>
                    </div>
                </div>

                <div class="w3-row-padding">
                    <input class="w3-btn w3-green" type="submit" name="confirm_envoyer" value="Envoyer" />
                    <input class="w3-btn w3-red" type="submit" name="clear" value="Effacer" />
                </div>
                <div class="w3-row-padding">
                    <input class="w3-btn w3-gray" type="submit" name="cancel" value="Annuler" />
                </div>
            </form>

            <script type="text/javascript">
                window.onload = function() {
                    document.getElementById("nummod").focus();
                };
            </script>
        </div>
    </div>
</div>