<div class="dtitle w3-container w3-teal">
    Modification du module
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de modification</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id="nommod" name="nommod" placeholder="Entrer un Nom" value="<?= htmlspecialchars($module->nommod ?? "") ?>">
                        </div>

                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>coefmod</b></label>
                            <input type="text" id="coefmod" name="coefmod" placeholder="Entrer un Coefficient" value="<?= htmlspecialchars($module->coefmod ?? "") ?>">
                        </div>
                    </div>
                </div>
                <div class="w3-row-padding">
                    <input class="w3-btn w3-green" type="submit" name="edit" value="Modifier" />
                    <input class="w3-btn w3-red" type="submit" name="cancel" value="Annuler" />
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