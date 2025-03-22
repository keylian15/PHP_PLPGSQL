<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');

$enseignant = new Enseignant($db);

// Verification des données 
if (isset($_POST['confirm_envoyer'])) {

    $enseignant = new Enseignant($db, $_POST);
    
    if (empty($_SESSION['mesgs']['errors'])) {
        $enseignant->create();
        
        // On attend la confirmation :
        if (!empty($_SESSION['mesgs']['confirm'])) {

            header('Location: index.php?element=enseignants&action=card&numens=' . $enseignant->numens . "&creer=true");
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
