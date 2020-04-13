<?php

	define('DB_DSN', 'mysql:host=localhost;dbname=webflix_reviews;charset=utf8');
	define('DB_USER','root');
    define('DB_PASS','');     

    function DB(){
    	try{

    		$db = new PDO(DB_DSN, DB_USER, DB_PASS);
    		return $db;

    	}
    	catch(PDOException $e){

    		return "Error: " . $e->getMessage();
    		die();
    		
    	}
    }
    
?>