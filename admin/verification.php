<?
session_start();
if (!isset($_SESSION["id"])) {
	header("Location:connexion.php?erreur=1");
}

include_once "../bdd.php";
$pdo = connect();
if(!accesAdmin($pdo, $_SESSION["id"])){
	disconnect($pdo);
	header("Location: ../deconnexion.php?erreur=3");
}

?>
