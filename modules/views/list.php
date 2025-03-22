<div class="dtitle w3-container w3-teal">
    Liste des modules
</div>

<div class="container">
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">

        <table class="w3-table-all">
            <thead>
                <tr>
                    <th>Nummod</th>
                    <th>Nom</th>
                    <th>Coefficient</th>
                </tr>
                <tr>
                    <th><input class="w3-input w3-border" type="text" name="nummod" placeholder="Nummod" value="<?= htmlspecialchars($_POST["nummod"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="nommod" placeholder="Nom" value="<?= htmlspecialchars($_POST["nommod"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="coefmod" placeholder="Coefficient" value="<?= htmlspecialchars($_POST["coefmod"] ?? ""); ?>"></th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 0;
                if (!empty($listeModules)) : ?>
                    <?php foreach ($listeModules as $module) : ?>
                        <tr>
                            <td>
                                <a href="index.php?element=modules&action=card&nummod=<?= $module['nummod']; ?>">
                                    <?= htmlspecialchars($module['nummod']); ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($module['nommod']); ?></td>
                            <td><?= htmlspecialchars($module['coefmod']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Aucun module trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        </br>
        <div class="w3-row-padding">
            <input class="w3-btn w3-green" type="submit" name="confirm_envoyer" value="Envoyer" />
            <input class="w3-btn w3-red" type="submit" name="clear" value="Effacer" />
        </div>
        <div class="w3-row-padding">
            <input class="w3-btn w3-gray" type="submit" name="cancel" value="Annuler" />
        </div>
    </form>
</div>