<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');

$matiere = new Matiere($db);

$nummat = GETPOST('nummat') ?? "-1";

// Si nummat est dans l'adresse :
if ($nummat != "-1") {

    $matiere->fetch($nummat);

    if (isset($_POST["delete"])) {
        
        $matiere->delete();
        header('Location: index.php?element=matieres&action=list&delete=true');
    }
    
}
