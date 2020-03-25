<?php

	require 'db_connect.php';

	if(isset($_GET['id'])){
		$id 		= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		$query 		= "SELECT * FROM movie WHERE MovieID = :id";
		$statement 	= $db->prepare($query);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);

		$statement->execute();
		$movie 		= $statement->fetch();
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>WebEx Reviews - <?= $movie['MovieTitle'] ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark">

	<?php include('navbar.php'); ?>
	<h3 class="text-light"><?= $movie['MovieTitle'] ?></h3>
	<a href="edit.php?id=<?= $movie['MovieID'] ?>" class="text-primary">edit</a>
	<p class="text-light"><?= $movie['MovieDescription'] ?></p>

</body>
</html>