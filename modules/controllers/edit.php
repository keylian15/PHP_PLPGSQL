<?php

// Initialisation des variables : 


require_once(dirname(__FILE__) . '/../../class/module.class.php');

$module = new Module($db);

$nummod = GETPOST('nummod') ?? "-1";

// Si nummod est dans l'adresse :
if ($nummod != "-1") {

    $module->fetch($nummod);

    // Verification des données 
    if (isset($_POST['edit'])) {

        // On met a jour les variables de modules via la methode hydrate.
        // On ajoute le nummod dans _POST sinon il n'est jamais pris en compte.
        $_POST["nummod"] = $nummod;
        $module->hydrate($_POST);

        if (empty($_SESSION['mesgs']['errors'])) {

            $module->update();
            if (empty($_SESSION['mesgs']['errors'])) {

                header('Location: index.php?element=modules&action=list&modif=true');
            }
        }
    }
    if (isset($_POST["cancel"])) {
        header('Location: index.php?element=modules&action=list');
    }
}
