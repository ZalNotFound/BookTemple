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

    $sql = "UPDATE book
            SET isbn13 = :newIsbn
            WHERE book_id = :bookId";

    $bookId = $_SESSION['book']['book_id'];

    $isbn = htmlspecialchars($_POST['isbn']);

   // Make sure the isbn isn't already taken
    $inexistantVerifQuery = $PDO->prepare("SELECT * FROM book WHERE isbn13 = :isbn");

    $inexistantVerifQuery->bindValue(':isbn', $isbn);
    $inexistantVerifQuery->execute();
    $inexistantVerifBool = $inexistantVerifQuery->fetchAll(PDO::FETCH_ASSOC);


   // Make sure the ISBN is invalid
    $invalidVerifQuery = $PDO->prepare("SELECT isbn13 FROM book WHERE book_id = :bookId");

    $invalidVerifQuery->bindValue(':bookId', $bookId);
    $invalidVerifQuery->execute();
    $invalidVerifResult = $invalidVerifQuery->fetchAll(PDO::FETCH_ASSOC)[0]['isbn13'];



    if(isset($isbn) && !empty($isbn) && is_numeric($isbn) && strlen($isbn)==13 &&
    isset($inexistantVerifBool) && empty($inexistantVerifBool) &&
    isset($isbn) && !empty($isbn) && !is_numeric($invalidVerifResult) && strstr($invalidVerifResult, '-TRIAL-')){
        $addQuery = $PDO->prepare($sql);

        $addQuery->bindValue(':newIsbn', $isbn);
        $addQuery->bindValue(':bookId', $bookId);

        $addQuery->execute();

        echo "Modification opérée avec succès ! \u{2714}";
        
        /* Need to refresh book-shelf first */
        //echo '<meta http-equiv="refresh" content="3; url=book-info.php">';

        echo '<meta http-equiv="refresh" content="5; url=book-shelf.php">';

        die();

    }


    else {
        echo "L'ISBN saisi est invalide \u{274C}" ;
    }

}



catch(PDOException $pe){
    echo 'ERREUR : '.$pe->getMessage();
}


echo '<p><a href="book-info-modify.php?id=$idBook">&laquo; Retour au formulaire</a></p>';
die();


?>
</body>
</html>