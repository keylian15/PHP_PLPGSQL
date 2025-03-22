<div class="dtitle w3-container w3-teal">
    Modification de la matiere
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de modification</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id="nommat" name="nommat" placeholder="Entrer un Nom" value="<?= htmlspecialchars($matiere->nommat ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Coefficient</b></label>
                            <input type="text" id="coefmat" name="coefmat" placeholder="Entrer un coefficient" value="<?= htmlspecialchars($matiere->coefmat ?? "") ?>">
                        </div>

                        <div class="w3-third">

                            <label class="w3-text-blue" for="title"><b>Module</b></label>

                            <select id="nummod" name="nummod" class="w3-select" style="width: 100%; margin-top: 15px;">
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
                    <input class="w3-btn w3-green" type="submit" name="edit" value="Modifier" />
                    <input class="w3-btn w3-red" type="submit" name="cancel" value="Annuler" />
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