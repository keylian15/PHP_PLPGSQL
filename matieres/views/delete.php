<div class="dtitle w3-container w3-teal">
    Supprimer Matiere
</div>

<p style="font-size:24px; font-weight:bold;">Êtes-vous sûr de vouloir supprimer cette matiere ? (nummat : <?= $matiere->nummat?>)</p>
<form action="<?= $_SERVER["REQUEST_URI"] ?>" method="POST" style="display:inline;">
    <button type="submit" class="w3-btn w3-red" name="delete">Oui</button>
</form>
<a href="index.php?element=matieres&action=list" class="w3-btn w3-green">Non</a>