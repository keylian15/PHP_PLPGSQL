<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/module.class.php');

$matiere = new Matiere($db);
$moduleManager = new Module($db);
$modules = $moduleManager->fetchAll();

// Verification des données 
if (isset($_POST['confirm_envoyer'])) {

    $matiere = new Matiere($db, $_POST);

    if (empty($_SESSION['mesgs']['errors'])) {
        $matiere->create();

        // On attend la confirmation :
        if (!empty($_SESSION['mesgs']['confirm'])) {

            header('Location: index.php?element=matieres&action=card&nummat=' . $matiere->nummat . "&creer=true");
        }
    }
}
if (isset($_POST['cancel'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['clear'])) {
    unset($_POST);
}
