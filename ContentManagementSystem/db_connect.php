<?php

	define('DB_DSN', 'mysql:host=localhost;dbname=webflix_reviews;charset=utf8');
	define('DB_USER','admin');
    define('DB_PASS','testadmin1');     

    $db = new PDO(DB_DSN, DB_USER, DB_PASS);

?>