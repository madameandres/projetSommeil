<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_GET["id"])) {
    $message = deleteMembre($pdo,$_GET["id"]);
        disconnect($pdo);
        Header("Location:utilisateur.php");
        exit();
    }
?>