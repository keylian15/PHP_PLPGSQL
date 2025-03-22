<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/module.class.php');

$matiere = new Matiere($db);
$listeMatieres = $matiere->fetchAll();

$moduleManager = new Module($db);
$modules = $moduleManager->fetchAll();

// === Gestion Message : 
if (GETPOST('modif') == true) {
    $_SESSION['mesgs']['confirm'][] = "Matiere modifié.";
}
if (GETPOST('delete') == true) {
    $_SESSION['mesgs']['confirm'][] = "Matiere supprimé.";
}
// === Fin Gestion Message.

// === Traitement Formulaire :
if (isset($_POST["confirm_envoyer"])) {
    $_SESSION['mesgs']['confirm'] = [];

    // on supprime confirm_envoyer et on recupere uniquement les champs non vide.
    $_POST["confirm_envoyer"] = "";
    $valeur = array_filter($_POST);
    if (!empty($valeur)) {
        $listeMatieres = $matiere->find($valeur);
    }
}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    exit;
}
if (isset($_POST['clear'])) {
    header('Location: index.php?element=matieres&action=list');
    exit;
}
