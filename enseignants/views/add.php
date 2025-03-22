<div class="dtitle w3-container w3-teal">
    Création d'un nouvel enseignant
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <h2>Formulaire de création</h2>
            <form class="w3-container" method="POST" action="<?= $_SERVER["REQUEST_URI"] ?>">
                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Numéro Enseignant</b></label>
                            <input type="text" id="numens" name="numens" placeholder="Entrer un Numéro Enseignant" value="<?= htmlspecialchars($enseignant->numens ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Nom</b></label>
                            <input type="text" id="nomens" name="nomens" placeholder="Entrer un Nom" value="<?= htmlspecialchars($enseignant->nomens ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Prénom</b></label>
                            <input type="text" id="preens" name="preens" placeholder="Entrer un Prénom" value="<?= htmlspecialchars($enseignant->preens ?? "") ?>">
                        </div>
                    </div>
                </div>

                <div class="dcontent">
                    <div class="w3-row-padding">
                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Adresse</b></label>
                            <input type="text" id="adrens" name="adrens" placeholder="Entrer une adresse" value="<?= htmlspecialchars($enseignant->adrens ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="title"><b>Code Postal</b></label>
                            <input type="text" id="cpens" name="cpens" placeholder="Entrer le Code Postal" value="<?= htmlspecialchars($enseignant->cpens ?? "") ?>">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Ville</b></label>
                            <input type="text" id="vilens" name="vilens" placeholder="Entrer la Ville" value="<?= htmlspecialchars($enseignant->vilens ?? "") ?>">
                        </div>
                    </div>
                </div>

                <div class="dcontent">
                    <div class="w3-row-padding">

                        <div class="w3-third">
                            <label class="w3-text-blue" for="datnaiens"><b>Naissance</b></label>
                            <input type="date" id="datnaiens" name="datnaiens" value="<?= htmlspecialchars($enseignant->datnaiens ?? '') ?>" style="width: 100%; margin-top: 20px;">
                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="tittle"><b>Fonction</b></label>
                            <select id="foncens" class="w3-select" name="foncens" style="width: 100%; margin-top: 15px;">
                                <option value="">Sélectionnez une fonction</option>
                                <?php

                                $selected_function = $enseignant->foncens ?? '';

                                foreach ($enseignant->t_function as $value) {
                                    $selected = ($value == $selected_function) ? 'selected' : '';
                                    echo "<option value=\"$value\" $selected>$value</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <div class="w3-third">
                            <label class="w3-text-blue" for="datembens"><b>Embauche</b></label>
                            <input type="date" id="datembens" name="datembens" value="<?= htmlspecialchars($enseignant->datembens ?? '') ?>" style="width: 100%; margin-top: 20px;">
                        </div>
                    </div>
                </div>
                
                <div class=dcontent>
                    <div class="w3">
                        <label class="w3-text-blue" for="tittle"><b>Numéro de téléphone</b></label>
                        <input type="text" id="telens" name="telens" placeholder="XX XX XX XX XX" value="<?= htmlspecialchars($enseignant->telens ?? "") ?>">
                    </div>
                </div>

                </br>

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
                    document.getElementById("numens").focus();
                };
            </script>
        </div>
    </div>
</div>