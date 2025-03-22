<?php

// Initialisation des variables : 


require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');

$enseignant = new Enseignant($db);

$numens = GETPOST('numens') ?? "-1";

// Si numens est dans l'adresse :
if ($numens != "-1") {

    $enseignant->fetch($numens);

    // Verification des données 
    if (isset($_POST['edit'])) {

        // On met a jour les variables de enseignants via la methode hydrate.
        $_POST["numens"] = $numens;
        $enseignant->hydrate($_POST);

        if (empty($_SESSION['mesgs']['errors'])) {
            $enseignant->update();
            if (empty($_SESSION['mesgs']['errors'])) {

                header('Location: index.php?element=enseignants&action=list&modif=true');
            }
        }
    }
    if (isset($_POST["cancel"])) {
        header('Location: index.php?element=enseignants&action=list');
    }
}
