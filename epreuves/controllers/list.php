<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');
require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');

$epreuve = new Epreuve($db);
$listeEpreuves = $epreuve->fetchAll();

$enseignantManager = new Enseignant($db);
$enseignants = $enseignantManager->fetchAll();

$matiereManager = new Matiere($db);
$matieres = $matiereManager->fetchAll();

// === Gestion Message : 
if (GETPOST('modif') == true) {
    $_SESSION['mesgs']['confirm'][] = "Epreuve modifié.";
}
if (GETPOST('delete') == true) {
    $_SESSION['mesgs']['confirm'][] = "Epreuve supprimé.";
}
// === Fin Gestion Message 

// === Traitement Formulaire :
if (isset($_POST["confirm_envoyer"])) {
    $_SESSION['mesgs']['confirm'] = [];

    // on supprime confirm_envoyer et on recupere uniquement les champs non vide.
    $_POST["confirm_envoyer"] = "";
    $valeur = array_filter($_POST);

    if (!empty($valeur)) {
        $listeEpreuves = $epreuve->find($valeur);
    }
}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    exit;
}
if (isset($_POST['clear'])) {
    header('Location: index.php?element=epreuves&action=list');
}

