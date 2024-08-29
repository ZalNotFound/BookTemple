<?php

require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\session-start.php";


if(!isset($_SESSION['userlogin']) || empty($_SESSION['userlogin'])){
    echo '<meta http-equiv="refresh" content="3; url=unregistered-user.php">';
    die();
}

try {
    require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\pdo-config.php";

    $PDO = pdoConfig($db_name='bookstore', $con_echo=false);

   // Data retrieving
    $newBookTitle = strval($_POST['book_title']);
    $newBookLang = strval($_POST['book_lang']);
    $newBookAuth = strval($_POST['book_auth']);
    $newBookDate = strval($_POST['book_date']);
    $newBookPubl = strval($_POST['book_publ']);
    $newBookPages = strval($_POST['book_pages']);
    $newBookIsbn = strval($_POST['book_isbn']);


    $sql = ""



   // Title validation
    if(isset($newBookTitle) && !empty($newBookTitle) && is_string($newBookTitle) && strlen($newBookTitle)<=400){
        $titleBool = TRUE;
    }
    else { $titleBool = FALSE; }
    

   // Language validation
    if(isset($newBookLang) && !empty($newBookLang) && is_string($newBookLang) && (strlen($newBookLang)==3 || strlen($newBookLang)==5)){
        $langBool = TRUE;
    }
    else { $langBool = FALSE; }


   // Author validation
    if(isset($newBookAuth) && !empty($newBookAuth) && is_string($newBookAuth) && strlen($newBookAuth)<=400){
        $authBool = TRUE;
    }
    else { $authBool = FALSE; }


   // Date validation
    if(isset($newBookDate) && !empty($newBookDate) && is_string($newBookDate) && (strlen($newBookDate)==8 || strlen($newBookDate)==10) && $newBookDate<=date("Y-m-d")){
        $dateBool = TRUE;
    }
    else { $dateBool = FALSE; }
    

   // Publisher validation
    if(isset($newBookPubl) && !empty($newBookPubl) && is_string($newBookPubl) && strlen($newBookPubl)<=400){
        $publBool = TRUE;
    }
    else { $publBool = FALSE; }


   // Page number validation
    if(isset($newBookPages) && !empty($newBookPages) && is_numeric($newBookPages) && $newBookPages>=4 && $newBookPages<=2400){
        $pageBool = TRUE;
    }
    else { $pageBool = FALSE; }


   // Ibsn validation
    if(isset($newBookIsbn) && !empty($newBookIsbn) && is_numeric($newBookIsbn) && strlen($newBookIsbn)==13){
        $isbnBool = TRUE;
    }
    else { $isbnBool = FALSE; }
    
    
    




    if($titleBool && $langBool && $authBool && $dateBool && $publBool && $pageBool && $isbnBool) {
        /*
        $addQuery = $PDO->prepare($sql);

        $addQuery->bindValue(':newIsbn', $isbn);
        $addQuery->bindValue(':bookId', $bookId);

        $addQuery->execute();

        echo "Modification opérée avec succès ! \u{2714}";
        echo '<meta http-equiv="refresh" content="5; url=book-shelf.php">';

        die();*/
        

    }
    else {

        echo $titleBool ? "\u{2714}" : "\u{274C}";
        echo " Titre<br>";
    
        echo $langBool ? "\u{2714}" : "\u{274C}";
        echo " Langue<br>";
    
        echo $authBool ? "\u{2714}" : "\u{274C}";
        echo " Auteur(e)<br>";
    
        echo $dateBool ? "\u{2714}" : "\u{274C}";
        echo " Date de publication<br>";
    
        echo $publBool ? "\u{2714}" : "\u{274C}";
        echo " Éditeur<br>";
    
        echo $pageBool ? "\u{2714}" : "\u{274C}";
        echo " Nombre de pages<br>";
    
        echo $isbnBool ? "\u{2714}" : "\u{274C}";
        echo " ISBN13<br>";
        
    }


    
    /*
    
    &&
    isset($inexistantVerifBool) && empty($inexistantVerifBool) &&
    isset($isbn) && !empty($isbn) && !is_numeric($invalidVerifResult) && strstr($invalidVerifResult, '-TRIAL-')){
        $addQuery = $PDO->prepare($sql);

        $addQuery->bindValue(':newIsbn', $isbn);
        $addQuery->bindValue(':bookId', $bookId);

        $addQuery->execute();

        echo "Modification opérée avec succès ! \u{2714}";
        
        // Need to refresh book-shelf first //
        //echo '<meta http-equiv="refresh" content="3; url=book-info.php">';

        echo '<meta http-equiv="refresh" content="5; url=book-shelf.php">';

        die();

    }


    else {
        echo "L'ISBN saisi est invalide \u{274C}" ;
    }
*/
}



catch(Exception $pe){
    echo 'ERREUR : '.$pe->getMessage();
}