<?php

    /* PHPMyAdmin access config */
        // localhost only //

function dbConfig(string $path, 
                  string $user = 'root', 
                  string $strongPw = '') {

    define('DB_DSN', 'mysql:host=localhost;dbname='.$path);
    define('DB_USER', $user);
    define('DB_PASS', $strongPw);
}
