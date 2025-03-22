<div class="dtitle w3-container w3-teal">
    Création d'une nouvelle matiere
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de création</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Numéro Matiere</b></label>
                            <input type="text" id="nummat" name="nummat" placeholder="Entrer un Numéro Matiere" value="<?= htmlspecialchars($matiere->nummat ?? "") ?>">
                        </div>

                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id="nommat" name="nommat" placeholder="Entrer un Nom" value="<?= htmlspecialchars($matiere->nommat ?? "") ?>">
                        </div>
                    </div>
                    <div class="w3-row-padding">

                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Coefficient</b></label>
                            <input type="text" id="coefmat" name="coefmat" placeholder="Entrer un coefficient" value="<?= htmlspecialchars($matiere->coefmat > 0 ? $matiere->coefmat : "") ?>">
                        </div>


                        <div class="w3-half">
                            <label class="w3-text-blue" for="nummod"><b>Module</b></label>
                            <select id="nummod" name="nummod" class="w3-select" style="width: 100%; margin-top: 15px;">
                                <option value="">Sélectionnez un module</option>
                                <?php
                                foreach ($modules as $module) {
                                    $selected = ($matiere->nummod == $module['nummod']) ? 'selected' : '';
                                    echo "<option value='{$module['nummod']}' $selected>{$module['nommod']}</option>";
                                }
                                ?>
                            </select>
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
                    document.getElementById("nummat").focus();
                };
            </script>
        </div>
    </div>
</div>