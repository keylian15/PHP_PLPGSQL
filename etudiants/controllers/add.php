<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/etudiant.class.php');

$etudiant = new Etudiant($db);

// Verification des données 
if (isset($_POST['confirm_envoyer'])) {

    $etudiant = new Etudiant($db, $_POST);

    if (empty($_SESSION['mesgs']['errors'])) {
        $etudiant->create();

        // On attend la confirmation :
        if (!empty($_SESSION['mesgs']['confirm'])) {
            header('Location: index.php?element=etudiants&action=card&numetu=' . $etudiant->numetu . "&creer=true");
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
