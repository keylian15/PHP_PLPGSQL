<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/epreuve.class.php');
require_once(dirname(__FILE__) . '/../../class/module.class.php');
require_once(dirname(__FILE__) . '/../../class/matiere.class.php');

$module = new Module($db);
$epreuveManager = new Epreuve($db);
$matiereManager = new Matiere($db);

$nummod = GETPOST('nummod') ?? "-1";

// Si nummod est dans l'adresse :
if ($nummod != "-1") {

    $module->fetch($nummod);
    if (GETPOST('creer') == true) {
        $_SESSION['mesgs']['confirm'][] = "Module créer.";
    }

    $nummat = $matiereManager->find(["nummod" => $nummod])[0]["nummat"];

    $annepr = $epreuveManager->find(["matepr" => $nummat])[0]["annepr"];

    // ====== Classement ======
    // $sql = "SELECT e.numetu, e.nometu, e.prenometu, 
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

    // Requete avec les tables de classements.
    $sql = "select * from classement_modules where nummod = :nummod and annetu = :annetu order by position;";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':nummod', $nummod);
    $stmt->bindValue(':annetu', $annepr);
    $stmt->execute();
    $listeResultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ====== Fin Classement ======
}
