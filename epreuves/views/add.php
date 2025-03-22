<div class="dtitle w3-container w3-teal">
    Création d'une nouvelle epreuve

</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de création</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Numéro Epreuve</b></label>
                            <input type="text" id="numepr" name="numepr" placeholder="Entrer un Numéro Epreuve" value="<?= htmlspecialchars($epreuve->numepr > 0 ? $epreuve->numepr : "") ?>">
                        </div>

                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id=libepr name=libepr placeholder="Entrer un Nom" value="<?= htmlspecialchars($epreuve->libepr ?? "") ?>">
                        </div>
                    </div>
                </div>

                <div class="w3-row-padding">
                    <div class="w3-third">
                        <label class="w3-text-blue" for="datepr"><b>Date Epreuve</b></label>
                        <input type="date" id="datepr" name="datepr" value="<?= htmlspecialchars($epreuve->datepr ?? '') ?>" style="width: 100%; margin-top: 20px;">
                    </div>

                    <div class="w3-third">
                        <label class="w3-text-blue" for="title"><b>Coefficient</b></label>
                        <input type="text" id="coefepr" name="coefepr" placeholder="Entrer un coefficient" value="<?= htmlspecialchars($epreuve->coefepr > 0 ? $epreuve->coefepr : "") ?>">
                    </div>

                    <div class="w3-third">
                        <label class="w3-text-blue" for="title"><b>Annéee</b></label>
                        <input type="text" id="annepr" name="annepr" placeholder="Entrer une annnée" value="<?= htmlspecialchars($epreuve->annepr > 0 ? $epreuve->annepr : "") ?>">
                    </div>
                </div>

                <div class="w3-row-padding">
                    <div class="w3-half">
                        <label class="w3-text-blue" for="title"><b>Enseignant</b></label>

                        <select id="ensepr" name="ensepr" class="w3-select" style="width: 100%; margin-top: 15px;">
                            <option value="">Sélectionnez un enseignant</option>
                            <?php

                            foreach ($enseignants as $enseignant) {
                                $selected = ($_POST["ensepr"] == $enseignant['numens']) ? 'selected' : '';
                                echo "<option value='{$enseignant['numens']}' $selected>{$enseignant['nomens']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="w3-half">
                        <label class="w3-text-blue" for="title"><b>Matiere</b></label>

                        <select id="matepr" name="matepr" class="w3-select" style="width: 100%; margin-top: 15px;">
                            <option value="">Sélectionnez une matière</option>
                            <?php
                            foreach ($matieres as $matiere) {
                                $selected = ($_POST["matepr"] == $matiere['nummat']) ? 'selected' : '';
                                echo "<option value='{$matiere['nummat']}' $selected>{$matiere['nommat']}</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>

                <br>
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
                    document.getElementById("numepr").focus();
                };
            </script>
        </div>
    </div>
</div>