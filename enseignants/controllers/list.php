<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');

$enseignant = new Enseignant($db);
$listeEnseignants = $enseignant->fetchAll();

// === Gestion Message : 
if (GETPOST('modif') == true) {
    $_SESSION['mesgs']['confirm'][] = "Enseignant modifié.";
}
if (GETPOST('delete') == true) {
    $_SESSION['mesgs']['confirm'][] = "Enseignant supprimé.";
}
// === Fin Gestion Message 

// === Traitement Formulaire :
if (isset($_POST["confirm_envoyer"])) {
    $_SESSION['mesgs']['confirm'] = [];

    // on supprime confirm_envoyer et on recupere uniquement les champs non vide.
    $_POST["confirm_envoyer"] = "";
    $valeur = array_filter($_POST);
    if (!empty($valeur)) {
        $listeEnseignants = $enseignant->find($valeur);
    }
}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    exit;
}
if (isset($_POST['clear'])) {
    header('Location: index.php?element=enseignants&action=list');
}

