<?
include "verification.php"; 
$message = "";

//On modifie
if (isset($_GET["id"])) {
    $message = deleteCampagne($pdo,$_GET["id"]);
        disconnect($pdo);
        Header("Location:campagne.php");
        exit();
    }
?>