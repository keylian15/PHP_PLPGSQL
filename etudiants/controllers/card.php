<?php
// Initialisation des variables : 
require_once(dirname(__FILE__) . '/../../class/etudiant.class.php');
require_once(dirname(__FILE__) . '/../../class/module.class.php');

$etudiant = new Etudiant($db);

$numetu = GETPOST('numetu') ?? "-1";

$moduleManager = new Module($db);

// Si numetu est dans l'adresse :
if ($numetu != "-1") {

    $etudiant->fetch($numetu);
    if (GETPOST('creer') == true) {
        $_SESSION['mesgs']['confirm'][] = "Etudiant créer.";
    }

    // ====== Classement ======
    // $sql = "SELECT * 
    // FROM (
    //     SELECT 
    //         mo.nummod,
    //         mo.nommod,
    //         e.numetu,
    //         e.nometu,
    //         e.prenometu,
    //         ROUND(
    //             SUM(CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat) / SUM(ep.coefepr * ma.coefmat), 
    //             2
    //         ) AS moyenne,
    //         RANK() OVER (PARTITION BY mo.nummod, e.annetu ORDER BY 
    //             ROUND(
    //                 SUM(CAST(an.note AS DECIMAL) * ep.coefepr * ma.coefmat) / SUM(ep.coefepr * ma.coefmat), 
    //                 2
    //             ) DESC
    //         ) AS position,
    //         e.annetu
    //     FROM etudiants e
    //     JOIN avoir_note an ON e.numetu = an.numetu
    //     JOIN epreuves ep ON an.numepr = ep.numepr
    //     JOIN matieres ma ON ma.nummat = ep.matepr
    //     JOIN modules mo ON mo.nummod = ma.nummod
    //     GROUP BY mo.nummod, mo.nommod, e.numetu, e.nometu, e.prenometu, e.annetu
    // ) classement
    // WHERE classement.numetu = :numetu 
    // ORDER BY classement.annetu, classement.position;
    // ";

    // Requete avec les tables de classements.
    $sql = "select * from classement_etudiants where numetu = :numetu and annetu = :annetu order by position;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':numetu', $numetu);
    $stmt->bindValue(':annetu', $etudiant->annetu);
    $stmt->execute();
    $listeResultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ====== Fin Classement ======
}
