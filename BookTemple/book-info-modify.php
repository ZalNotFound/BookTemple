<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>🖊 Plus en détails</title>
<!--<style>
</style>-->
</head>
<body>

<?php

// Session check //

require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\session-start.php";


if(!isset($_SESSION['userlogin']) || empty($_SESSION['userlogin'])){
    echo '<meta http-equiv="refresh" content="3; url=unregistered-user.php">';
    die();
}

///////////////////

try {
    require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\pdo-config.php";

    $book = $_SESSION['book'];
    //unset($_SESSION['book']);


}


catch(Exception $pe){
    echo 'ERREUR : '.$pe->getMessage();
}

?>


    <form method="POST" action="book-info-result.php" id="idModif" name="modif_page">

       <!--title-->
        <h2><em><?php echo htmlspecialchars($book["title"]) ?></em></h2>


       <!--Language-->
        <p><label for="lang_book"><strong>Langue :</strong></label> <input type="text" id="lang_book" name="lang" placeholder="<?php echo htmlspecialchars($book['lang']) ?>" disabled></p>


       <!--Author-->
        <p><label for="auth_book"><strong>Auteur(e) :</strong></label> <input type="text" id="auth_book" name="auth" placeholder="<?php echo htmlspecialchars($book['author']) ?>" disabled></p>


       <!--Publication date-->
        <p><label for="pub_date_book"><strong>Date de publication :</strong></label> <input type="text" id="pub_date_book" name="publication" placeholder="<?php echo htmlspecialchars($book['new_publication_date']) ?>" disabled></p>
    

       <!--Publisher-->
        <p><label for="pub_book"><strong>Éditeur :</strong></label> <input type="text" id="pub_book" name="publisher" placeholder="<?php echo htmlspecialchars($book['publisher'])?>" disabled></p>


       <!--Pages number-->
        <p><label for="num_pages_book"><strong>Langue :</strong></label> <input type="text" id="num_pages_book" name="num_pages" placeholder="<?php echo htmlspecialchars($book['num_pages']) ?>" disabled></p>


       <!--ISBN-->
        <p><label for="isbn_book"><strong>ISBN :</strong></label> <input type="tel" id="isbn_book" name="isbn" pattern="[0-9]{3}[0-9]{1}[0-9]{4}[0-9]{4}[0-9]{1}"  placeholder="<?php echo htmlspecialchars($book["isbn13"])?>" required></p>


       <!--Validation-->
        <br><p><input type="submit" name="valid_form" value="Valider"></p>

    </form>
    
</body>
</html>