<div class="dtitle w3-container w3-teal">
    Fiche module
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2>Carte du module</h2>
            <div class="w3-card-4 w3-light-grey">
                <div class="w3-container w3-teal">
                    <h3>Informations du module</h3>
                </div>

                <div class="w3-container">
                    <p><strong>Numéro Module:</strong> <?= htmlspecialchars($module->nummod ?? "Non spécifié"); ?></p>
                    <p><strong>Nom:</strong> <?= htmlspecialchars($module->nommod ?? "Non spécifié"); ?></p>
                    <p><strong>Coefficient:</strong> <?= htmlspecialchars($module->coefmod ?? "Non spécifié"); ?></p>

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
                                    <th>Moyenne</th>
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
                                            <td><?= htmlspecialchars($resultat['moyenne']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Fin Classement -->
                </div>

                <div class="w3-container w3-center">
                    <a href="index.php?element=modules&action=edit&nummod=<?= $module->nummod; ?>" class="w3-btn w3-green">Modifier</a>
                    <a href="index.php?element=modules&action=delete&nummod=<?= $module->nummod; ?>" class="w3-btn w3-red">Supprimer</a>
                </div>
                <div class="w3-container w3-center">
                    <a href="index.php?" class="w3-btn w3-gray">Annuler</a>

                </div>
            </div>
        </div>
    </div>
</div>