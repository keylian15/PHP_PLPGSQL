<div class="dtitle w3-container w3-teal">
    Liste des enseignants
</div>

<div class="container">
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">

        <table class="w3-table-all">
            <thead>
                <tr>
                    <th>Numens</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                </tr>
                <tr>
                    <th><input class="w3-input w3-border" type="text" name="numens" placeholder="Numens" value="<?= htmlspecialchars($_POST["numens"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="nomens" placeholder="Nom" value="<?= htmlspecialchars($_POST["nomens"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="preens" placeholder="Prénom" value="<?= htmlspecialchars($_POST["preens"] ?? ""); ?>"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($listeEnseignants)) : ?>
                    <?php foreach ($listeEnseignants as $enseignant) : ?>
                        <tr>
                            <td>
                                <a href="index.php?element=enseignants&action=card&numens=<?= $enseignant['numens']; ?>">
                                    <?= htmlspecialchars($enseignant['numens']); ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($enseignant['nomens']); ?></td>
                            <td><?= htmlspecialchars($enseignant['preens']); ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Aucun enseignant trouvé.</td>
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