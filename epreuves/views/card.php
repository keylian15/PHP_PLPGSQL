<div class="dtitle w3-container w3-teal">
    Fiche epreuves
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2>Carte de l'epreuve</h2>
            <div class="w3-card-4 w3-light-grey">
                <div class="w3-container w3-teal">
                    <h3>Informations de l'epreuve</h3>
                </div>

                <div class="w3-container">
                    <p><strong>Numéro Epreuve:</strong> <?= htmlspecialchars($epreuve->numepr ?? "Non spécifié"); ?></p>
                    <p><strong>Nom:</strong> <?= htmlspecialchars($epreuve->libepr ?? "Non spécifié"); ?></p>
                    <p><strong>Enseignant:</strong> <?= htmlspecialchars($enseignantName ?? "Non spécifié"); ?></p>
                    <p><strong>Matière:</strong> <?= htmlspecialchars($matiereName ?? "Non spécifié"); ?></p>
                    <p><strong>Date Epreuves:</strong> <?= htmlspecialchars($epreuve->datepr ?? "Non spécifié"); ?></p>
                    <p><strong>Coefficient:</strong> <?= htmlspecialchars($epreuve->coefepr ?? "Non spécifié"); ?></p>
                    <p><strong>Année:</strong> <?= htmlspecialchars($epreuve->annepr ?? "Non spécifié"); ?></p>

                    <!-- Classement -->
                    <div class="w3-container w3-teal">
                        <h3>Classement</h3>
                    </div>

                    <div class="container">
                        <table class="w3-table-all">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Position</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($listeResultat)) : ?>
                                    <tr>
                                        <td colspan="3">Aucun classement disponible dû à un manque de note.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($listeResultat as $resultat) : ?>
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
                            </tbody>
                        </table>
                    </div>
                    <!-- Fin Classement -->

                </div>

                <div class="w3-container w3-center">
                    <a href="index.php?element=epreuves&action=edit&numepr=<?= $epreuve->numepr; ?>" class="w3-btn w3-green">Modifier</a>
                    <a href="index.php?element=epreuves&action=delete&numepr=<?= $epreuve->numepr; ?>" class="w3-btn w3-red">Supprimer</a>
                </div>
                <div class="w3-container w3-center">
                    <a href="index.php?" class="w3-btn w3-gray">Annuler</a>

                </div>
            </div>
        </div>
    </div>
</div>