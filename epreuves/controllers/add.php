<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/etudiant.class.php');
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');
require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');

$epreuve = new Epreuve($db);

$etudiant = new Etudiant($db);

$matiereManager = new Matiere($db);
$matieres = $matiereManager->fetchAll();

$enseignantManager = new Enseignant($db);
$enseignants = $enseignantManager->fetchAll();

// Verification des données 
if (isset($_POST['confirm_envoyer'])) {

    $epreuve = new Epreuve($db, $_POST);

    if (empty($_SESSION['mesgs']['errors'])) {
        $epreuve->create();

        // On attend la confirmation :
        if (!empty($_SESSION['mesgs']['confirm'])) {

            // On recupere le numepr qu'on va mettre dans la epreuve.
            $t = $epreuve->fetch(null, $_POST["libepr"]);

            if (!empty($t)) {
                $epreuve->numepr = $t["numepr"];
            }

            header('Location: index.php?element=epreuves&action=card&numepr=' . $epreuve->numepr . "&creer=true");
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
