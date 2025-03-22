<div class="dtitle w3-container w3-teal">
    Accueil modules
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <?php foreach ($listeNumeroModule as $key => $data) {
            ?>
                <div class="dtitle w3-container w3-dark-grey">
                    <a href="index.php?element=modules&action=card&nummod=<?= $key; ?>">
                        Classement du module <?= htmlspecialchars($data["nommod"]); ?>
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
                <?php foreach ($data["matiere"] as $key => $matiere) : ?>

                    <div class="container">
                        <table class="w3-table-all">
                            <div class="dtitle w3-container w3-teal"><a href="index.php?element=matieres&action=card&nummat=<?= $key; ?>">
                                    Matiere n° <?= htmlspecialchars($key); ?> : <?= htmlspecialchars($matiereManager->fetch($key)["nommat"]); ?>
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
                                if (empty($matiere)) : ?>
                                    <tr>
                                        <td colspan="3">Aucun classement disponible dû à un manque de note.</td>
                                    </tr>
                                <?php else : ?>

                                    <?php foreach ($matiere as $key2 => $resultat) : ?>
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