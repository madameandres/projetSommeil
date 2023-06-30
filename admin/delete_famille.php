<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_GET["id"])) {
    $message = deleteFamille($pdo,$_GET["id"]);
        disconnect($pdo);
        Header("Location:famille.php");
        exit();
    }
?>