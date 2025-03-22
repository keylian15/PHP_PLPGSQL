<div class="dtitle w3-container w3-teal">
    Supprimer Etudiant
</div>

<p style="font-size:24px; font-weight:bold;">Êtes-vous sûr de vouloir supprimer cet étudiant ? (numetu : <?= $etudiant->numetu?>)</p>
<form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST" style="display:inline;">
    <button type="submit" class="w3-btn w3-red" name="delete">Oui</button>
</form>
<a href="index.php?element=etudiants&action=list" class="w3-btn w3-green">Non</a>