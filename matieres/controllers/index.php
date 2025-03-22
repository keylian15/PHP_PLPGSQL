<?php
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');

$matiereManager = new Matiere($db);
$epreuveManager = new Epreuve($db);

// Récupération Numéro Matiere
$sqlListeNumeroMatiere = "select DISTINCT nummat from classement_matieres;";
$stmt = $db->prepare($sqlListeNumeroMatiere);
$stmt->execute();
$listeNumeroMatiere = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Fin Récupération Numéro Matiere

// Initialisation des variables.
$nummat = $annepr = 0;

// Commande SQL
// $sqlMatiere = "SELECT 
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

$sqlMatiere = "select * from classement_matieres where nummat = :nummat and annetu = :annetu order by position;";
$stmtMatiere = $db->prepare($sqlMatiere);

// $sqlEpreuve = "
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
$sqlEpreuve = "select * from classement_epreuves where numepr = :numepr and annetu = :annetu order by position;";
$stmtEpreuve = $db->prepare($sqlEpreuve);
// Fin Commande SQL

foreach ($listeNumeroMatiere as $key => $value) {
    $nummat = $value["nummat"];
    // Récupération des epreuves concernée 
    $result = $epreuveManager->find(["matepr" => $nummat]);

    // Assignation des valeurs.
    $annepr = $result[0]["annepr"];
    $stmtMatiere->bindParam(':nummat', $nummat);
    $stmtMatiere->bindParam(':annetu', $annepr); // A mettre en param pour la longue requete
    $stmtMatiere->execute();

    $listeNumeroMatiere[$nummat]["nommat"] = $matiereManager->fetch($nummat)["nommat"];

    // Recupereation du classement.
    $listeResultatMatiere = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);
    $listeNumeroMatiere[$nummat]["classement"] = $listeResultatMatiere;

    foreach ($result as $value) {

        $numepr = $value["numepr"];

        // Assignation des variables.
        $stmtEpreuve->bindParam(':numepr', $numepr);
        $stmtEpreuve->bindParam(':annetu', $annepr); 
        $stmtEpreuve->execute();

        $listeResultatEpreuve = $stmtEpreuve->fetchAll(PDO::FETCH_ASSOC);
        $listeNumeroMatiere[$nummat]["epreuve"][$numepr] = $listeResultatEpreuve;
    }

    // On enleve l'element parasite.
    unset($listeNumeroMatiere[0]);
}
