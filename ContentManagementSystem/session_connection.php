<!-- Refactored Code: Provides the php necessary to create a session and connection to the database, and create session user details object -->

<?php

	session_start();

	require 'db_connect.php';
	require 'registrationFunctions.php';

	$db = DB();
	$app = new registrationFunctions();

	if(!empty($_SESSION['user_id'])){
		$user = $app->UserDetails($_SESSION['user_id']);
	}

?>