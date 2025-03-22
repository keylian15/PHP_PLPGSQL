<div class="dtitle w3-container w3-teal">
    Liste des matières
</div>

<div class="container">
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">

        <table class="w3-table-all">
            <thead>
                <tr>
                    <th>Numero Matiere</th>
                    <th>Nom</th>
                    <th>Coefficient</th>
                    <th>Module</th>
                </tr>
                <!-- Recherche  -->

                <tr>
                    <th><input class="w3-input w3-border" type="text" name="nummat" placeholder="Nummat" value="<?= htmlspecialchars($_POST["nummat"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="nommat" placeholder="Nom" value="<?= htmlspecialchars($_POST["nommat"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="coefmat" placeholder="Coefficient" value="<?= htmlspecialchars($_POST["coefmat"] ?? ""); ?>"></th>
                    <th><select class="w3-select" id="nummod" name="nummod" style="width: 100%; margin-top: 15px;">
                            <option value="">Sélectionnez un module</option>
                            <?php

                            foreach ($modules as $module) {
                                $selected = ($_POST["nummod"] == $module['nummod']) ? 'selected' : '';
                                echo "<option value='{$module['nummod']}' $selected>{$module['nommod']}</option>";
                            }
                            ?>
                        </select>
                    </th>
                </tr>

                <!-- Fin Recherche -->
            </thead>
            <tbody>
                <?php
                if (!empty($listeMatieres)) : ?>
                    <?php foreach ($listeMatieres as $matiere) : ?>
                        <td>
                            <a href="index.php?element=matieres&action=card&nummat=<?= $matiere['nummat']; ?>">
                                <?= htmlspecialchars($matiere['nummat']); ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($matiere['nommat']); ?></td>
                        <td><?= htmlspecialchars($matiere['coefmat']); ?></td>
                        <td><?php
                            echo htmlspecialchars($moduleManager->find(["nummod" => $matiere["nummod"]])[0]["nommod"]);
                            ?>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Aucune matière trouvée.</td>
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