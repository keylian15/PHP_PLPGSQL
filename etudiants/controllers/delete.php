<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/etudiant.class.php');

$etudiant = new Etudiant($db);

$numetu = GETPOST('numetu') ?? "-1";

// Si numetu est dans l'adresse :
if ($numetu != "-1") {

    $etudiant->fetch($numetu);

    if (isset($_POST["delete"])) {
        
        $etudiant->delete();
        header('Location: index.php?element=etudiants&action=list&delete=true');
    }
    
}
