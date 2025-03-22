<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');

$enseignant = new Enseignant($db);

$numens = GETPOST('numens') ?? "-1";

// Si numens est dans l'adresse :
if ($numens != "-1") {

    $enseignant->fetch($numens);
    if (GETPOST('creer') == true) {
        $_SESSION['mesgs']['confirm'][] = "Enseignant créer.";
    }
}