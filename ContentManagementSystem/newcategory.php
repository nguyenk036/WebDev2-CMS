<?php

	require 'authenticate.php';
	require 'db_connect.php';

	$statusMessage = "";

	if(isset($_POST) && !empty($_POST['category']) && strlen(trim($_POST['category'])) > 0){
		$category			= filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$query = "INSERT INTO genre (CategoryName) VALUES (:category)";
		$statement 	= $db->prepare($query);

		$statement->bindValue(':category', $category);

		if($statement->execute()){
			$statusMessage = "Category successfully created";
		}
	}
	else if(isset($_POST) && isset($_POST['category'])){
		$statusMessage = "** Fields cannot be empty";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>WebFlix Reviews - New Category</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
	<?php include('navbar.php'); ?>

	<form method="post" action="newcategory.php">
		<div>
			<label for="category">Category Name</label>
        	<input id="category" name="category">
		</div>
       
        <div id="buttons">
        	<input type="submit">
        </div>
    </form>

    <h4><?= $statusMessage ?></h4>
</body>
</html>