<div class="dtitle w3-container w3-teal">
    Accueil matieres
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <?php foreach ($listeNumeroMatiere as $key => $data) {
            ?>
                <div class="dtitle w3-container w3-dark-grey">
                    <a href="index.php?element=matieres&action=card&nummat=<?= $key; ?>">
                        Classement de la matiere <?= htmlspecialchars($data["nommat"]); ?>
                    </a>
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

                <!-- Classement par épreuves -->
                <?php foreach ($data["epreuve"] as $key => $epreuve) : ?>

                    <div class="container">
                        <table class="w3-table-all">
                            <div class="dtitle w3-container w3-teal"><a href="index.php?element=epreuves&action=card&numepr=<?= $key; ?>">
                                    Epreuve n° <?= htmlspecialchars($key); ?> : <?= htmlspecialchars($epreuveManager->fetch($key)["libepr"]); ?>
                                </a></div>
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
                                if (empty($epreuve)) : ?>
                                    <tr>
                                        <td colspan="3">Aucun classement disponible dû à un manque de note.</td>
                                    </tr>
                                <?php else : ?>

                                    <?php foreach ($epreuve as $key2 => $resultat) : ?>
                                        <tr>
                                            <td>
                                                <a href="index.php?element=etudiants&action=card&numetu=<?= $resultat['numetu']; ?>">
                                                    <?= htmlspecialchars($resultat['numetu']); ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($resultat['position']); ?></td>
                                            <td><?= htmlspecialchars($resultat['nometu']); ?></td>
                                            <td><?= htmlspecialchars($resultat['prenometu']); ?></td>
                                            <td><?= htmlspecialchars($resultat['note']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                <?php
            }
                ?>
        </div>
    </div>
</div>