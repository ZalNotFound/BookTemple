<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats 🖊</title>
<!--<style>
</style>-->
</head>
<body>


<?php

require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\session-start.php";


if(!isset($_SESSION['userlogin']) || empty($_SESSION['userlogin'])){
    echo '<meta http-equiv="refresh" content="3; url=unregistered-user.php">';
    die();
}

try {
    require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\pdo-config.php";

    $PDO = pdoConfig($db_name='bookstore', $con_echo=false);

    $sql = "";

    $isbn = $_POST['isbn'];

    if(!empty($isbn) && isset($isbn) && strlen($isbn)==13) {
        $isbn = strval($isbn);
        echo "oui";
    }

}



catch(PDOException $pe){
    echo 'ERREUR : '.$pe->getMessage();
}


echo '<p><a href="book-info-modify.php?id=$idBook">&laquo; Retour au formulaire</a></p>';


?>
</body>
</html>