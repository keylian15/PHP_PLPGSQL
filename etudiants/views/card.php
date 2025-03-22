<div class="dtitle w3-container w3-teal">
    Fiche étudiant
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2>Carte de l'étudiant</h2>
            <div class="w3-card-4 w3-light-grey">
                <div class="w3-container w3-teal">
                    <h3>Informations de l'étudiant</h3>
                </div>

                <div class="w3-container">
                    <p><strong>Numéro Etudiant:</strong> <?= htmlspecialchars($etudiant->numetu ?? "Non spécifié"); ?></p>
                    <p><strong>Nom:</strong> <?= htmlspecialchars($etudiant->nometu ?? "Non spécifié"); ?></p>
                    <p><strong>Prénom:</strong> <?= htmlspecialchars($etudiant->prenometu ?? "Non spécifié"); ?></p>
                    <p><strong>Adresse:</strong> <?= htmlspecialchars($etudiant->adretu ?? "Non spécifié"); ?></p>
                    <p><strong>Ville:</strong> <?= htmlspecialchars($etudiant->viletu ?? "Non spécifié"); ?></p>
                    <p><strong>Code Postal:</strong> <?= htmlspecialchars($etudiant->cpetu ?? "Non spécifié"); ?></p>
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($etudiant->teletu ?? "Non spécifié"); ?></p>
                    <p><strong>Date Entrée:</strong> <?= htmlspecialchars($etudiant->datentetu ?? "Non spécifié"); ?></p>
                    <p><strong>Année d'étude:</strong> <?= htmlspecialchars($etudiant->annetu ?? "Non spécifié"); ?></p>
                    <p><strong>Remarque:</strong> <?= htmlspecialchars($etudiant->remetu != '' ? $etudiant->remetu : "Aucune remarque."); ?></p>
                    <p><strong>Sexe:</strong> <?= htmlspecialchars($etudiant->sexetu ?? "Non spécifié"); ?></p>
                    <p><strong>Date de naissance:</strong> <?= htmlspecialchars($etudiant->datnaietu ?? "Non spécifié"); ?></p>

                    <!-- Classement -->
                    <div class="w3-container w3-teal">
                        <h3>Classement</h3>
                    </div>

                    <div class="container">
                        <table class="w3-table-all">
                            <thead>
                                <tr>
                                    <th>Numero Module</th>
                                    <th>Position</th>
                                    <th>Nom Module</th>
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
                                                <a href="index.php?element=modules&action=card&nummod=<?= $resultat['nummod']; ?>">
                                                    <?= htmlspecialchars($resultat['nummod']); ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($resultat['position']); ?></td>
                                            <td><?= htmlspecialchars($resultat["nommod"]); ?></td>
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
                    <a href="index.php?element=etudiants&action=edit&numetu=<?= $etudiant->numetu; ?>" class="w3-btn w3-green">Modifier</a>
                    <a href="index.php?element=etudiants&action=delete&numetu=<?= $etudiant->numetu; ?>" class="w3-btn w3-red">Supprimer</a>
                </div>
                <div class="w3-container w3-center">
                    <a href="index.php?" class="w3-btn w3-gray">Annuler</a>

                </div>
            </div>
        </div>
    </div>
</div>