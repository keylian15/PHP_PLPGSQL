<?php

// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/module.class.php');

$matiere = new Matiere($db);
$moduleManager = new Module($db);
$modules = $moduleManager->fetchAll();

$nummat = GETPOST('nummat') ?? "-1";

// Si nummat est dans l'adresse :
if ($nummat != "-1") {

    $matiere->fetch($nummat);

    // Verification des données 
    if (isset($_POST['edit'])) {

        $_POST["nummat"] = $nummat;

        $matiere->hydrate($_POST);

        if (empty($_SESSION['mesgs']['errors'])) {
            $matiere->update();

            if (empty($_SESSION['mesgs']['errors'])) {

                header('Location: index.php?element=matieres&action=list&modif=true');
            }
        }
    }
}
if (isset($_POST["cancel"])) {
    header('Location: index.php?element=matieres&action=list');
}
