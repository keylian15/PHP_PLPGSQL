<div class="dtitle w3-container w3-teal">
    Fiche enseignant
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <h2>Carte de l'enseignant</h2>
            <div class="w3-card-4 w3-light-grey">
                <div class="w3-container w3-teal">
                    <h3>Informations de l'enseignant</h3>
                </div>

                <div class="w3-container">
                    <p><strong>Numéro Enseignant:</strong> <?= htmlspecialchars($enseignant->numens ?? "Non spécifié"); ?></p>
                    <p><strong>Nom:</strong> <?= htmlspecialchars($enseignant->nomens ?? "Non spécifié"); ?></p>
                    <p><strong>Prénom:</strong> <?= htmlspecialchars($enseignant->preens ?? "Non spécifié"); ?></p>
                    <p><strong>Adresse:</strong> <?= htmlspecialchars($enseignant->adrens ?? "Non spécifié"); ?></p>
                    <p><strong>Ville:</strong> <?= htmlspecialchars($enseignant->vilens ?? "Non spécifié"); ?></p>
                    <p><strong>Code Postal:</strong> <?= htmlspecialchars($enseignant->cpens ?? "Non spécifié"); ?></p>
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($enseignant->telens ?? "Non spécifié"); ?></p>
                    <p><strong>Date d'embauche:</strong> <?= htmlspecialchars($enseignant->datembens ?? "Non spécifié"); ?></p>
                    <p><strong>Date de naissance:</strong> <?= htmlspecialchars($enseignant->datnaiens ?? "Non spécifié"); ?></p>
                    <p><strong>Fonction:</strong> <?= htmlspecialchars($enseignant->foncens ?? "Non spécifié"); ?></p>
                </div>

                <div class="w3-container w3-center">
                    <a href="index.php?element=enseignants&action=edit&numens=<?= $enseignant->numens; ?>" class="w3-btn w3-green">Modifier</a>
                    <a href="index.php?element=enseignants&action=delete&numens=<?= $enseignant->numens; ?>" class="w3-btn w3-red">Supprimer</a>
                </div>
                <div class="w3-container w3-center">
                    <a href="index.php?" class="w3-btn w3-gray">Annuler</a>

                </div>
            </div>
        </div>
    </div>
</div>