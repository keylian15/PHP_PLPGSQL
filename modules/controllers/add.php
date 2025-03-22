<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/module.class.php');

$module = new Module($db);

// Verification des données 
if (isset($_POST['confirm_envoyer'])) {
    $module = new Module($db, $_POST);

    if (empty($_SESSION['mesgs']['errors'])) {
        $module->create();

        // On attend la confirmation :
        if (!empty($_SESSION['mesgs']['confirm'])) {

            header('Location: index.php?element=modules&action=card&nummod=' . $module->nummod . "&creer=true");
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
