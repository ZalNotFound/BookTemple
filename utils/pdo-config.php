<?php

    /* PDO Config */


require 'db-config.php';

function pdoConfig(string $db_name, bool $con_echo=true, string $encoding = 'utf8', string $errmode = 'EXCEPTION', string $fetchmode = 'OBJ', string $emulQuery = 'false'){

    class ValueException extends TypeError{};

    if (isset($db_name) && !empty($db_name)) {
        dbConfig($path=$db_name);
    }
    else { dbConfig(); }


    // ERRMODE Management //

    try{
        $errmode = strtoupper($errmode);
        switch($errmode) {
            case 'EXCEPTION':
            // Raises an exception for SQL errors
                $errmode = PDO::ERRMODE_EXCEPTION;
                break;
                    
            case 'WARNING':
            // Raises a warning for SQL errors
                $errmode = PDO::ERRMODE_WARNING;
                break;

            case 'SILENT':
            // Raises nothing for SQL errors
                $errmode = PDO::ERRMODE_SILENT;
                break;

            default:
                throw new ValueException("Entrée invalide. Essayez : 'EXCEPTION' / 'WARNING' / 'SILENT'");
                break;
            }
        }

    catch(ValueException $errmsg){
        echo $errmsg->getMessage();
    }

    ////////////////////////
    

    // FETCH_MODE Management //

    try{
        $fetchmode = strtoupper($fetchmode);
        switch($fetchmode) {
            case 'OBJ':
            // Raises an exception for SQL errors
                $fetchmode = PDO::FETCH_OBJ;
                break;
                    
            case 'ASSOC':
            // Raises a warning for SQL errors
                $fetchmode = PDO::FETCH_ASSOC;
                break;

            case 'BOTH':
            // Raises nothing for SQL errors
                $fetchmode = PDO::FETCH_BOTH;
                break;

            default:
                throw new ValueException("Entrée invalide. Essayez : 'OBJ' / 'ASSOC' / 'BOTH'");
                break;
            }
        }

    catch(ValueException $errmsg){
        echo $errmsg->getMessage();
    }

    //////////////////////////


    // EMULATE_PREPARES Management //

    try{
        switch($emulQuery) {
            case 'false':
            // Sets query emulation to false
                $emulQuery = false;
                break;
                    
            case 'true':
            // Sets query emulation to true
                $emulQuery = true;
                break;

            default:
                throw new ValueException("Entrée invalide. Essayez : 'true' / 'false'");
                break;
            }
        }

    catch(ValueException $errmsg){
        echo $errmsg->getMessage();
    }

    /////////////////////////////////
    
    

    // Main //

    try{
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$encoding,   // Encoding type
            PDO::ATTR_ERRMODE => $errmode,  // SQL error statement
            PDO::ATTR_DEFAULT_FETCH_MODE => $fetchmode,     // Type of fetch returning
            PDO::ATTR_EMULATE_PREPARES => false                 // Queries emulation
        ];

        $PDO = new PDO(DB_DSN, DB_USER, DB_PASS, $options);

        if ($con_echo) {
            echo '<p>Connexion à la base '.$db_name.' réussie !</p>';
        }

        return $PDO;
    }


    catch(PDOException $pe){
        echo 'ERREUR : '.$pe->getMessage();
    }

    //////////

}


?>