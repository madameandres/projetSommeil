<?
include "verification.php"; 
$rows = listeSommeil($pdo);
disconnect($pdo);
$message="";

$entete = "id_sommeil;jour;prenom;nom;heure_coucher;heure_endormissement;heure_lever;temps_sommeil;fatigue;activite;campagne";
# Chemin vers fichier texte
$file = "export.txt";
# Ouverture en mode écriture
$fileopen = (fopen("$file", "w+"));
# Ecriture de "Début du fichier" dansle fichier texte
fwrite($fileopen, "$entete\n");
foreach($rows as $row){
    $ligne = $row["id_sommeil"].";"
            . $row["jour"].";"
            . $row["prenom"].";"
            . $row["nom"].";"
            . $row["coucher"].";"
            . $row["endormissement"].";"
            . $row["lever"].";"
            . $row["temps_sommeil"].";"
            . $row["fatigue"].";"
            . $row["activite"].";"
            . $row["id_campagne"];
    fwrite($fileopen, "$ligne\n");
}
# On ferme le fichier proprement
fclose($fileopen);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $file . '"');

// Force le téléchargement du fichier
readfile($file);

?>
