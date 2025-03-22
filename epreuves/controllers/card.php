<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/enseignant.class.php');

$epreuve = new Epreuve($db);
$matiereManager = new Matiere($db);
$enseignantManager = new Enseignant($db);

$numepr = GETPOST('numepr') ?? "-1";

// Si numepr est dans l'adresse :
if ($numepr != "-1") {

    $epreuve->fetch($numepr);

    $matiereName = $matiereManager->fetch($epreuve->matepr)["nommat"];

    $enseignantName = $enseignantManager->fetch($epreuve->ensepr)["nomens"];

    // ====== Classement ======
    // $sql = "
    // SELECT 
    //     RANK() OVER (ORDER BY an.note DESC) AS position,
    //     an.numetu,
    //     an.note,
    //     e.nometu,
    //     e.prenometu
    // FROM avoir_note an
    // INNER JOIN etudiants e ON an.numetu = e.numetu
    // WHERE an.numepr = :numepr and annetu = :annetu 
    // ORDER BY position;
    // ";

    // Requete avec les tables de classements.
    $sql = "select * from classement_epreuves where numepr = :numepr and annetu = :annetu order by position;";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':numepr', $numepr);
    $stmt->bindValue(':annetu', $epreuve->annepr);
    $stmt->execute();
    $listeResultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ====== Fin Classement ======

    if (GETPOST('creer') == true) {
        $_SESSION['mesgs']['confirm'][] = "Epreuve créer.";
    }
}
