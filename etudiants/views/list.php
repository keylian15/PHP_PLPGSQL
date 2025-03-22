<div class="dtitle w3-container w3-teal">
    Liste des étudiants
</div>

<div class="container">
    <form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST">

        <table class="w3-table-all">
            <thead>
                <tr>
                    <th>Numetu</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                </tr>
                <tr>
                    <th><input class="w3-input w3-border" type="text" name="numetu" placeholder="Numetu" value="<?= htmlspecialchars($_POST["numetu"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="nometu" placeholder="Nom" value="<?= htmlspecialchars($_POST["nometu"] ?? ""); ?>"></th>
                    <th><input class="w3-input w3-border" type="text" name="prenometu" placeholder="Prénom" value="<?= htmlspecialchars($_POST["prenometu"] ?? ""); ?>"></th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 0;
                if (!empty($listeEtudiants)) : ?>
                    <?php foreach ($listeEtudiants as $etudiant) : ?>
                        <tr>
                            <td>
                                <a href="index.php?element=etudiants&action=card&numetu=<?= $etudiant['numetu']; ?>">
                                    <?= htmlspecialchars($etudiant['numetu']); ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($etudiant['nometu']); ?></td>
                            <td><?= htmlspecialchars($etudiant['prenometu']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Aucun étudiant trouvé.</td>
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