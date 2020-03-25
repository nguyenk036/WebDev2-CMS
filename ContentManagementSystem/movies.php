<?php
	require('db_connect.php');

	$getMovies 	= "SELECT * FROM movie";
	$statement 	= $db->prepare($getMovies);
	$statement->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Movies</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
	<!-- Navigation bar -->
	<?php include('navbar.php'); ?>

	<a href="newmovie.php" id="newmovie">Add a movie</a>
	<a href="newcategory.php" id="newcateogry">Add a genre</a>

	<?php if($statement->rowCount() === 0): ?>
			<h2>There are no movies.</h2>
	<?php else: ?>
		<?php while($row = $statement->fetch()): ?>
				<h3><a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>" class="text-primary"><?= $row['MovieTitle'] ?></a></h3>
				<a href="movieedit.php?id=<?= $row['MovieID'] ?>" class="text-secondary">edit</a>
				<p class=""><?= substr($row['MovieDescription'], 0, 200); ?> <a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>">...Read full description</a></p>
		<?php endwhile ?>
	<?php endif ?>
</body>
</html>