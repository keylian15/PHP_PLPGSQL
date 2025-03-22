<div class="dtitle w3-container w3-teal">
    Accueil etudiants
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <?php foreach ($listeAnnee as $key => $data) {
            ?>
                <div class="dtitle w3-container w3-teal">

                    Classement pour l'année <?= htmlspecialchars($key); ?>

                </div>
                <!-- Classement matiere general -->
                <div class="container">
                    <table class="w3-table-all">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Position</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Moyenne</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($data["classement"])) : ?>
                                <tr>
                                    <td colspan="3">Aucun classement disponible dû à un manque de note.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($data["classement"] as $resultat) : ?>
                                    <tr>
                                        <td>
                                            <a href="index.php?element=etudiants&action=card&numetu=<?= $resultat['numetu']; ?>">
                                                <?= htmlspecialchars($resultat['numetu']); ?>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($resultat['position']); ?></td>
                                        <td><?= htmlspecialchars($resultat['nometu']); ?></td>
                                        <td><?= htmlspecialchars($resultat['prenometu']); ?></td>
                                        <td><?= htmlspecialchars($resultat['moyenne']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


            <?php
            }
            ?>
        </div>
        <br>
    </div>
</div>
</div>