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


$numepr = GETPOST('numepr') ?? "-1";

// Si numepr est dans l'adresse :
if ($numepr != "-1") {

    $epreuve->fetch($numepr);

    // Verification des données 
    if (isset($_POST['edit'])) {

        // On met a jour les variables de epreuves via la methode hydrate.
        // On ajoute le numepr dans _POST sinon il n'est jamais pris en compte.
        $_POST["numepr"] = $numepr;
        $epreuve->hydrate($_POST);

        if (empty($_SESSION['mesgs']['errors'])) {

            $epreuve->update();
            if (empty($_SESSION['mesgs']['errors'])) {
                header('Location: index.php?element=epreuves&action=list&modif=true');
            }
        }
    }
    if (isset($_POST["cancel"])) {
        header('Location: index.php?element=epreuves&action=list');
    }
}
