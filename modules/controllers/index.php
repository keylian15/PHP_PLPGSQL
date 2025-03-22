<?php
require_once(dirname(__FILE__) . '/../../class/module.class.php');
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');

$moduleManager = new Module($db);
$matiereManager = new Matiere($db);
$epreuveManager = new Epreuve($db);

// Récupération Numéro Module
$sqlListeNumeroModule = "select DISTINCT nummod from classement_modules;";
$stmt = $db->prepare($sqlListeNumeroModule);
$stmt->execute();
$listeNumeroModule = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Fin Récupération Numéro Module

// Initialisation des variables.
$nummod = $annepr = 0;

// Commande SQL
// $sqlModule = "SELECT e.numetu, e.nometu, e.prenometu, 
// RANK() OVER (ORDER BY round(sum(CAST(an.note AS DECIMAL) * ep.coefepr * m.coefmat) / sum(ep.coefepr * m.coefmat) , 2) DESC) AS position, 
// round(sum(CAST(an.note AS DECIMAL) * ep.coefepr * m.coefmat) / sum(ep.coefepr * m.coefmat) , 2) as moyenne
// from etudiants e 
// INNER JOIN avoir_note an on e.numetu = an.numetu 
// inner join epreuves ep on an.numepr = ep.numepr 
// inner join matieres m on ep.matepr = m.nummat 
// where m.nummod = :nummod 
// and e.annetu = ep.annepr
// group by e.numetu, e.nometu, e.prenometu 
// order by moyenne desc;";

$sqlModule = "select * from classement_modules where nummod = :nummod and annetu = :annetu order by position;";
$stmtModule = $db->prepare($sqlModule);

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
// Fin Commande SQL

foreach ($listeNumeroModule as $key => $value) {

    $nummod = $value["nummod"];
    // Récupération des matieres concernées 
    $result = $matiereManager->find(["nummod" => $nummod]);

    // Assignation des valeurs.
    $n = 0;

    // $tempo = $epreuveManager->find(["matepr" => $result[$n]["nummat"]]);
    $tempo = false;

    // Récupération de l'année 
    while (!$tempo) {
        // On va tester avec toutes les epreuves possibles des matieres concernées.
        // Verification d'une epreuve trouvée.
        $tempo = $epreuveManager->find(["matepr" => $result[$n]["nummat"]]);

        $n++;
    }
    // ====== Nettoyage Messages Erreurs ======
    foreach ($_SESSION['mesgs']['errors'] as $key => $error) {
        if (strpos($error, "Aucune epreuves trouvée pour ces filtres.") !== false) {
            unset($_SESSION['mesgs']['errors'][$key]);
        }
    }
    // ====== Nettoyage Messages Erreurs ======

    $annepr = $tempo[0]["annepr"];

    $stmtModule->bindParam(':nummod', $nummod);
    $stmtModule->bindParam(':annetu', $annepr); // A mettre en param pour la longue requete
    $stmtModule->execute();

    $listeNumeroModule[$nummod]["nommod"] = $moduleManager->fetch($nummod)["nommod"];

    // Recupereation du classement.
    $listeResultatModule = $stmtModule->fetchAll(PDO::FETCH_ASSOC);
    $listeNumeroModule[$nummod]["classement"] = $listeResultatModule;

    foreach ($result as $value) {

        $nummat = $value["nummat"];

        $stmtMatiere->bindParam(':nummat', $nummat);
        $stmtMatiere->bindParam(':annetu', $annepr); // A mettre en param pour la longue requete
        $stmtMatiere->execute();

        $listeResultatMatiere = $stmtMatiere->fetchAll(PDO::FETCH_ASSOC);
        $listeNumeroModule[$nummod]["matiere"][$nummat] = $listeResultatMatiere;
    }

    // On enleve l'element parasite.
    unset($listeNumeroModule[0]);
}
