<?php
/**
 * Created by PhpStorm.
 * User: zahead
 * Date: 11/06/15
 * Time: 13:31
 */

header("Content-Type: text/csv; charset=UTF-8");
header("Content-disposition: filename=resultat-recherche.csv");
// Création de la ligne d'en-tête
$entete = array("Module", "Partie", "Type", "HED","Semestre", "Public","Enseignant.nom","Enseignant.prenom","Enseignant.login","Responsable");


$separateur = ";";

// Affichage de la ligne de titre, terminée par un retour chariot
echo implode($separateur, $entete)."\r\n";

// Affichage du contenu du tableau
foreach ($export as $ligne) {
    echo implode($separateur, $ligne)."\r\n";
}