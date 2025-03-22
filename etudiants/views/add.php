<div class="dtitle w3-container w3-teal">
    Création d'un nouvel étudiant
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de création</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Numéro Etudiant</b></label>
                            <input type="text" id="numetu" name="numetu" placeholder="Entrer un Numéro Etudiant" value="<?= htmlspecialchars($etudiant->numetu ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id="nometu" name="nometu" placeholder="Entrer un Nom" value="<?= htmlspecialchars($etudiant->nometu ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Prénom</b></label>
                            <input type="text" id="prenometu" name="prenometu" placeholder="Entrer un Prénom" value="<?= htmlspecialchars($etudiant->prenometu ?? "") ?>">
                        </div>
                    </div>
                </div>

                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Adresse</b></label>
                            <input type="text" id="adretu" name="adretu" placeholder="Entrer une adresse" value="<?= htmlspecialchars($etudiant->adretu ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Code Postal</b></label>
                            <input type="text" id="cpetu" name="cpetu" placeholder="Entrer le Code Postal" value="<?= htmlspecialchars($etudiant->cpetu ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Ville</b></label>
                            <input type="text" id="viletu" name="viletu" placeholder="Entrer la Ville" value="<?= htmlspecialchars($etudiant->viletu ?? "") ?>">
                        </div>
                    </div>
                </div>

                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="datnaietu"><b>Naissance</b></label>
                            <input type="date" id="datnaietu" name="datnaietu" value="<?= htmlspecialchars($etudiant->datnaietu ?? '') ?>" style="width: 100%; margin-top: 20px;">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Année</b></label>
                            <input type="text" id="annetu" name="annetu" placeholder="Entrer l'année d'étude" value="<?= htmlspecialchars($etudiant->annetu > 0 ? $etudiant->annetu : "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Numéro de téléphone</b></label>
                            <input type="text" id="teletu" name="teletu" placeholder="XX XX XX XX XX" value="<?= htmlspecialchars($etudiant->teletu ?? "") ?>" >
                        </div>
                    </div>
                </div>

                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="datnaietu"><b>Entrée</b></label>
                            <input type="date" id="datentetu" name="datentetu" value="<?= htmlspecialchars($etudiant->datentetu ?? '') ?>" style="width: 100%; margin-top: 20px;">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Remarque</b></label>
                            <input type="text" id="remetu" name="remetu" placeholder="Entrer la remarque" value="<?= htmlspecialchars($etudiant->remetu ??  "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Sexe</b></label>
                            <select id="sexetu" class="w3-select" name="sexetu" style="width: 100%; margin-top: 15px;">
                                <option value="">Sélectionnez un genre</option>
                                <?php
                                $options = ['M' => 'Homme', 'F' => 'Femme'];

                                $selected_genre = $etudiant->sexetu ?? '';

                                foreach ($options as $value => $label) {
                                    $selected = ($value == $selected_genre) ? 'selected' : '';
                                    echo "<option value=\"$value\" $selected>$label</option>";
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
                    document.getElementById("numetu").focus();
                };
            </script>
        </div>
    </div>
</div>