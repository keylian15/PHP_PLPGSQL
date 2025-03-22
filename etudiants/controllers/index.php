<?php
require_once(dirname(__FILE__) . '/../../class/etudiant.class.php');

// Récupération Année 
$sqlListeAnnee = "select DISTINCT annetu from classement_etudiants_general";
$stmtListeAnnee = $db->prepare($sqlListeAnnee);
$stmtListeAnnee->execute();
$listeAnnee = $stmtListeAnnee->fetchAll(PDO::FETCH_ASSOC);
// Fin Récupération Année 

// Commande SQL
$sqlClassementEtudiant = "select * from classement_etudiants_general where annetu =:annetu;";
$stmtClassementEtudiant = $db->prepare($sqlClassementEtudiant);
// Fin Commande SQL

foreach ($listeAnnee as $data) {

    $annetu = $data["annetu"];

    // Assignation des variables.
    $stmtClassementEtudiant->bindParam(':annetu', $annetu);
    $stmtClassementEtudiant->execute();
    $listeClassementAnnee = $stmtClassementEtudiant->fetchAll(PDO::FETCH_ASSOC);

    $listeAnnee[$annetu]["classement"] = $listeClassementAnnee;
}
// On enleve l'element parasite (Le premier indice du tableaux).
unset($listeAnnee[0]);
