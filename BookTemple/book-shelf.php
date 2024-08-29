<?php

require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\session-start.php";


if(!isset($_SESSION['userlogin']) || empty($_SESSION['userlogin'])){
    echo '<meta http-equiv="refresh" content="3; url=unregistered-user.php">';
    die();
}

try {
    require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\pdo-config.php";

    $PDO = pdoConfig($db_name='bookstore', $con_echo=false);

    //include 'book-shelf.html';


    $validColumns = ['title', 'author', 'year']; // Valid column name list
    $validOrders = ['ASC', 'DESC']; // Valid order list


    $searchTerm = strval($_GET['book-search'] ?? '');
    $columnSort = strval($_GET['column-param'] ?? 'title');
    $orderSort = strval($_GET['order-param'] ?? 'ASC');




   // Data validation //
    if (is_null($searchTerm) || empty($searchTerm) || !is_string($searchTerm)) {
        $searchTerm = '';
    }
    if (!in_array($columnSort, $validColumns) || empty($columnSort) || !is_string($columnSort)) {
        $columnSort = 'title';
    }
    if (!in_array($orderSort, $validOrders) || empty($orderSort) || !is_string($orderSort)) {
        $orderSort = 'ASC';
    }



   // SQL Query //
    $searchQuery = $PDO->prepare(
        'SELECT TRIM(REGEXP_REPLACE(
             REGEXP_REPLACE(title, "^[[:digit:]]+-TRIAL-", ""),   -- TRIM(digits-TRIAL-)
         "[[:digit:]]{2,3}$", ""))   -- TRIM(endDigits)
         AS title, 
         REGEXP_REPLACE(
             CONCAT(
                 SUBSTRING_INDEX(isbn13, "-TRIAL-", 1),
                 SUBSTRING_INDEX(isbn13, "-TRIAL-", -1),
                 TRIM(book_id)),
                 " ", "") 
         AS id FROM book
         WHERE LOWER(title) LIKE LOWER(:searchTerm)
         ORDER BY '.$columnSort.' '.$orderSort.'
         LIMIT 25');

    $searchQuery->bindValue(':searchTerm', '%'.$searchTerm.'%');

    $searchQuery->execute();

    $results = $searchQuery->fetchAll(PDO::FETCH_ASSOC);


    foreach ($results as $result) {
        $title = $result['title'];
        //$formatedTitle = str_replace(" ", "", ucwords($title));
        $idBook = $result['id'];

        echo "<pre><a target='_blank' href=book-info.php?id=$idBook>".$title."</a></pre><br>";
        
    }

    echo "\t<button><a style='color:black;text-decoration:none' href='book-add.html'>\u{2795} Ajouter un livre</a></button></p>";

}



catch(Exception $pe){
    echo 'ERREUR : '.$pe->getMessage();
}

//require_once "C:\wamp64\www\Exercices\PHP_MySQL\utils\session-stop.php";


?>