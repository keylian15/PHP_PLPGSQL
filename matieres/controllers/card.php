<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/module.class.php');
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');

$matiere = new Matiere($db);
$moduleManager = new Module($db);

$epreuveManager = new Epreuve($db);

$nummat = GETPOST('nummat') ?? "-1";

// Si nummat est dans l'adresse :
if ($nummat != "-1") {

    $matiere->fetch($nummat);
    $moduleName = $moduleManager->fetch($matiere->nummod)["nommod"];

    $annepr = $epreuveManager->find(["matepr" => $nummat])[0]["annepr"];
    // ====== Classement ======
    // $sql = "SELECT 
    //     RANK() OVER (ORDER BY round(SUM(CAST(an.note AS DECIMAL) * ep.coefepr) / SUM(ep.coefepr), 2) DESC) AS position, 
    //     e.numetu, 
    //     e.nometu, 
    //     e.prenometu, 
    //     ROUND(SUM(CAST(an.note AS DECIMAL) * ep.coefepr) / SUM(ep.coefepr), 2) AS moyenne
    //     FROM etudiants e
    //     INNER JOIN avoir_note an ON e.numetu = an.numetu
    //     INNER JOIN epreuves ep ON an.numepr = ep.numepr
    //     WHERE ep.matepr = :nummat 
    //     AND e.annetu = ep.annepr
    //     GROUP BY e.numetu, e.nometu, e.prenometu
    //     ORDER BY position;
    // ";

    // Requete avec les tables de classements.
    $sql = "select * from classement_matieres where nummat = :nummat and annetu = :annetu order by position;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':nummat', $nummat);
    $stmt->bindValue(':annetu', $annepr);
    $stmt->execute();
    $listeResultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ====== Fin Classement ======

    if (GETPOST('creer') == true) {
        $_SESSION['mesgs']['confirm'][] = "Matiere créer.";
    }
}
