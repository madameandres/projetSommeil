<?
session_start();
if (!isset($_SESSION["id"])) {
	header("Location:connexion.php?erreur=1");
}

include_once "bdd.php";
$pdo = connect();
if(!campagneActive($pdo)){
	disconnect($pdo);
	header("Location:deconnexion.php?erreur=2");
}

?>
