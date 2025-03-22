<?php

// Initialisation des variables : 


require_once(dirname(__FILE__) . '/../../class/etudiant.class.php');

$etudiant = new Etudiant($db);

$numetu = GETPOST('numetu') ?? "-1";

// Si numetu est dans l'adresse :
if ($numetu != "-1") {

    $etudiant->fetch($numetu);

    // Verification des données 
    if (isset($_POST['edit'])) {

        // On met a jour les variables de etudiants via la methode hydrate.
        $_POST["numetu"] = $numetu;
        $etudiant->hydrate($_POST);

        if (empty($_SESSION['mesgs']['errors'])) {

            $etudiant->update();
            if (empty($_SESSION['mesgs']['errors'])) {

                header('Location: index.php?element=etudiants&action=list&modif=true');
            }
        }
    }
    if (isset($_POST["cancel"])) {
        header('Location: index.php?element=etudiants&action=list');
    }
}
