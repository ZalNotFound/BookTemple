<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plus en détails</title>
<!--<style>
</style>-->
</head>
<body>

<?php

// Session check //

require 'C:\wamp64\www\Exercices\PHP_MySQL\utils\session-start.php';


if(!isset($_SESSION['userlogin']) || empty($_SESSION['userlogin'])){
    echo '<meta http-equiv="refresh" content="3; url=unregistered-user.php">';
    die();
}

///////////////////



try {
    require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\pdo-config.php";

    $PDO = pdoConfig($db_name='bookstore', $con_echo=false);


   // Getting ID from URL
    $idBook = htmlspecialchars($_GET['id']);

   // Book infos query
    $bookQuery = $PDO->prepare(
        'SELECT book.*,
        -- New title
         TRIM(REGEXP_REPLACE(
             REGEXP_REPLACE(book.title, "^[[:digit:]]+-TRIAL-", ""),   -- TRIM(digits-TRIAL-)
         "[[:digit:]]{2,3}$", ""))   -- TRIM(endDigits)
         AS title, 

        -- New ISBN
         CASE
            WHEN isbn13 LIKE "%-TRIAL-%" THEN "invalide"
            ELSE isbn13
         END AS isbn13,



        -- New book id
         REGEXP_REPLACE(
            CONCAT(
             SUBSTRING_INDEX(book.isbn13, "-TRIAL-", 1),
             SUBSTRING_INDEX(book.isbn13, "-TRIAL-", -1),
             TRIM(book.book_id)),
         " ", "") AS new_book_id,

        -- Book language
         book_language.language_name AS lang,

        -- New date
         DATE_FORMAT(book.publication_date, "%e %b %Y") AS new_publication_date, 

        -- Author
         TRIM(REGEXP_REPLACE(
             REGEXP_REPLACE(author.author_name, "^[[:digit:]]+-TRIAL-", ""),   -- TRIM(digits-TRIAL-)
         "[[:digit:]]{2,3}$", ""))   -- TRIM(endDigits)
         AS author,

        -- Publisher
         TRIM(REGEXP_REPLACE(
             REGEXP_REPLACE(publisher.publisher_name, "^[[:digit:]]+-TRIAL-", ""),   -- TRIM(digits-TRIAL-)
         "[[:digit:]]{2,3}$", ""))   -- TRIM(endDigits)
         AS publisher

         FROM book LEFT JOIN book_language ON book.language_id = book_language.language_id
         LEFT JOIN (book_author LEFT JOIN author ON book_author.author_id = author.author_id) ON book.book_id = book_author.book_id
         LEFT JOIN publisher ON book.publisher_id = publisher.publisher_id

         -- WHERE New book id == URLs id
         WHERE REGEXP_REPLACE(
            CONCAT(
             SUBSTRING_INDEX(book.isbn13, "-TRIAL-", 1),
             SUBSTRING_INDEX(book.isbn13, "-TRIAL-", -1),
             TRIM(book.book_id)),
         " ", "") = '.strval($idBook).'
         OR CONCAT(book.isbn13, TRIM(book.book_id)) = '.strval($idBook));

    $bookQuery->execute();

    $results = $bookQuery->fetchAll(PDO::FETCH_ASSOC);



   // If book was found
    if ($book = $results[0]) {
        // title
        echo '<h2><em>' . $book["title"] . '</em></h2>';
        // Language
        echo '<p><strong>Langue :</strong> '.$book["lang"].'</p>';
        // Author
        echo '<p><strong>Auteur(e) :</strong> '.$book["author"].'</p>';
        // Publication date
        echo '<p><strong>Date de publication :</strong> ' . $book["new_publication_date"] . '</p>';
        // Publisher
        echo '<p><strong>Éditeur :</strong> '.$book["publisher"].'</p>';
        // Pages number
        echo '<p><strong>Nombre de pages :</strong> ' . $book["num_pages"] . '</p>';
        // ISBN
        if (strstr($book["isbn13"], "invalid")) {
            $_SESSION['book'] = $book;

            echo '<p><strong>ISBN :</strong> <i>' . $book["isbn13"] . "</i>\t<button><a href='book-info-modify.php?id=$idBook'>\u{1F58A}</a></button></p>";

        }
        else {
            echo '<p><strong>ISBN :</strong> <i>' . $book["isbn13"] . '</i></p>';
        }

        // Add new book info
    } 
    else {
        echo "Livre non trouvé.\u{1F615}";
    }
}

catch(Exception $pe){
    echo 'ERREUR : '.$pe->getMessage();
}


?>

</body>
</html>