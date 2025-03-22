<div class="dtitle w3-container w3-teal">
    Liste des epreuves
</div>

<div class="container">
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">

        <table class="w3-table-all">
            <thead>
                <tr>
                    <th>Numero Epreuve</th>
                    <th>Nom</th>
                    <th>Enseignant</th>
                    <th>Matiere</th>
                    <th>Coefficient</th>
                </tr>

                <!-- Recherche  -->

                <tr>
                    <th><input class="w3-input w3-border" type="text" name="numepr" placeholder="Numéro" value="<?= htmlspecialchars($_POST["numepr"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="libepr" placeholder="Nom" value="<?= htmlspecialchars($_POST["libepr"] ?? ""); ?>"></th>
                    <th>
                        <select id="ensepr" name="ensepr" class="w3-select" style="width: 100%; margin-top: 15px;">
                            <option value="">Sélectionnez un enseignant</option>
                            <?php

                            foreach ($enseignants as $enseignant) {
                                $selected = ($_POST['ensepr'] == $enseignant['numens']) ? 'selected' : '';
                                echo "<option value='{$enseignant['numens']}' $selected>{$enseignant['preens']} {$enseignant['nomens']}</option>";
                            }
                            ?>
                        </select>
                    </th>
                    <th>
                        <select id="matepr" name="matepr" class="w3-select" style="width: 100%; margin-top: 15px;">
                            <option value="">Sélectionnez une matière</option>
                            <?php
                            foreach ($matieres as $matiere) {
                                $selected = ($_POST["matepr"] == $matiere['nummat']) ? 'selected' : '';
                                echo "<option value='{$matiere['nummat']}' $selected>{$matiere['nommat']}</option>";
                            }
                            ?>
                        </select>
                    </th>
                    <th><input class="w3-input w3-border" type="text" name="coefepr" placeholder="Coefficient" value="<?= htmlspecialchars($_POST["coefepr"] ?? ""); ?>"> </th>
                </tr>
                <!-- Fin Recherche  -->

            </thead>
            <tbody>
                <?php
                if (!empty($listeEpreuves)) : ?>
                    <?php foreach ($listeEpreuves as $epreuve) : ?>
                        <tr>
                            <td><a href="index.php?element=epreuves&action=card&numepr=<?= $epreuve['numepr']; ?>">
                                    <?= htmlspecialchars($epreuve['numepr']); ?>
                                </a></td>
                            <td><?= htmlspecialchars($epreuve['libepr']); ?></td>
                            <td>
                                <?php
                                echo htmlspecialchars($enseignantManager->find(["numens" => $epreuve["ensepr"]])[0]["nomens"]);
                                ?>
                            </td>
                            <td>
                                <?php
                                echo htmlspecialchars($matiereManager->find(["nummat" => $epreuve["matepr"]])[0]["nommat"]);
                                ?>
                            </td>
                            <td><?= htmlspecialchars($epreuve['coefepr']); ?></td>
                            

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Aucune epreuve trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <div class="w3-row-padding">
            <input class="w3-btn w3-green" type="submit" name="confirm_envoyer" value="Envoyer" />
            <input class="w3-btn w3-red" type="submit" name="clear" value="Effacer" />
        </div>
        <div class="w3-row-padding">
            <input class="w3-btn w3-gray" type="submit" name="cancel" value="Annuler" />
        </div>
    </form>
</div>