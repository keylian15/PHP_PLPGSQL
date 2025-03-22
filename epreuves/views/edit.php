<div class="dtitle w3-container w3-teal">
    Modification d'un epreuves
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
                            <input type="text" id="libepr" name="libepr" placeholder="Entrer un Nom" value="<?= htmlspecialchars($epreuve->libepr ?? "") ?>">
                        </div>

                        <div class="w3-half">
                            <label class="w3-text-blue" for="date"><b>Date</b></label>
                            <input type="date" id="date" name="datepr" value="<?= htmlspecialchars($epreuve->datepr ?? '') ?>" style="width: 100%; margin-top: 20px;">
                        </div>
                    </div>

                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Enseignant</b></label>

                            <select id="ensepr" name="ensepr" class="w3-select" style="width: 100%; margin-top: 15px;">
                                <?php

                                foreach ($enseignants as $enseignant) {
                                    $selected = ($epreuve->ensepr == $enseignant['numens']) ? 'selected' : '';
                                    echo "<option value='{$enseignant['numens']}' $selected>{$enseignant['nomens']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Matiere</b></label>

                            <select id="matepr" name="matepr" class="w3-select" style="width: 100%; margin-top: 15px;">
                                <?php
                                foreach ($matieres as $matiere) {
                                    $selected = ($epreuve->matepr == $matiere['nummat']) ? 'selected' : '';
                                    echo "<option value='{$matiere['nummat']}' $selected>{$matiere['nommat']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="w3-row-padding">
                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Coefficient</b></label>
                            <input type="text" id="coefepr" name="coefepr" placeholder="Entrer un coeficient" value="<?= htmlspecialchars($epreuve->coefepr ?? "") ?>">
                        </div>

                        <div class="w3-half">
                            <label class="w3-text-blue" for="title"><b>Année</b></label>
                            <input type="text" id="annepr" name="annepr" placeholder="Entrer une année" value="<?= htmlspecialchars($epreuve->annepr ?? "") ?>">
                        </div>
                    </div>

                    <br>

                    <div class="w3-row-padding">
                        <input class="w3-btn w3-green" type="submit" name="edit" value="Modifier" />
                        <input class="w3-btn w3-red" type="submit" name="clear" value="Effacer" />
                    </div>
                    <div class="w3-row-padding">
                        <input class="w3-btn w3-gray" type="submit" name="cancel" value="Annuler" />
                    </div>
                </div>

            </form>

            <script type="text/javascript">
                window.onload = function() {
                    document.getElementById("libepr").focus();
                };
            </script>
        </div>
    </div>
</div>