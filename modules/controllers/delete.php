<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/module.class.php');

$module = new Module($db);

$nummod = GETPOST('nummod') ?? "-1";

// Si nummod est dans l'adresse :
if ($nummod != "-1") {

    $module->fetch($nummod);

    if (isset($_POST["delete"])) {
        
        $module->delete();
        header('Location: index.php?element=modules&action=list&delete=true');
    }
    
}
