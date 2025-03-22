<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');

$epreuve = new Epreuve($db);

$numepr = GETPOST('numepr') ?? "-1";

// Si numepr est dans l'adresse :
if ($numepr != "-1") {

    $epreuve->fetch($numepr);

    if (isset($_POST["delete"])) {
        
        $epreuve->delete();
        header('Location: index.php?element=epreuves&action=list&delete=true');
    }
    
}
