<?php

require 'C:\wamp64\www\Exercices\PHP_MySQL\utils\session-start.php';

?>

<!-- HTML part -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>"Connexion..."</title>
</head>
<body>
    <p><a href="login.html">&laquo; Retour au formulaire</a></p>
</body>
</html>
<!--------------->

<?php
require 'C:\wamp64\www\Exercices\PHP_MySQL\utils\pdo-config.php';

$userLogin = (string) $_POST['user_email'];
$userPassword = (string) $_POST['user_password'];

//echo htmlspecialchars($userLogin).'<br>';
//echo htmlspecialchars($userPassword).'<br>';



$PDO = pdoConfig($db_name='bookstore', $con_echo=false);

try{

    $requestLog = $PDO->prepare('SELECT 1 FROM customer WHERE EXISTS(SELECT email FROM customer WHERE email = :_login)');
    $requestLog->bindValue(':_login', $userLogin);
    $requestLog->execute();

    
    if(!empty($requestLog->fetch()->{1})){
        $bool = 1;
    }

    else {$bool = 0;}

    //echo $bool;
    
    


    if($bool){
        $requestPW = $PDO->prepare('SELECT password FROM customer WHERE email = :_login');

            
        $requestPW->bindValue(':_login', $userLogin);
        $requestPW->execute();
        $realPW = $requestPW->fetch()->password;

        //echo $realPW;


        // All good >> Login //
        if ($realPW == $userPassword){
            echo '<p>Connexion réussie !</p>';
            echo '<meta http-equiv="refresh" content="2; url=book-shelf.php">';

            $_SESSION['userlogin'] = htmlspecialchars($userLogin);
            session_write_close();
        }

        // Incorrect password >> Warning //
        else {
            echo '<p>Mot de passe incorrect.</p>';
            
            require 'C:\wamp64\www\Exercices\PHP_MySQL\utils\session-stop.php';
        }
    }

    else{
        // Inexistant user >> Redirection //
        echo '<p>Utilisateur inexistant...</p>';
        echo '<p><b>Redirection...</b></p>';
        echo '<meta http-equiv="refresh" content="3; url=new-user.php">';

        require 'C:\wamp64\www\Exercices\PHP_MySQL\utils\session-stop.php';
        
        die();

    }


}



catch(PDOException $pe){
    echo 'ERREUR : '.$pe->getMessage();
}


?>