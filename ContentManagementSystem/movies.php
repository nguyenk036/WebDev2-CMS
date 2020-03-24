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
<body>
	<!-- Navigation bar -->
	<?php include('navbar.php'); ?>

	<a href="newmovie.php" id="newmovie">Add a Movie</a>

	<?php if($statement->rowCount() === 0): ?>
			<h2>There are no movies.</h2>
	<?php else: ?>
		<?php while($row = $statement->fetch()): ?>
				<h3 class="posttitle"><a href="fullpost.php?id=<?= $row['MovieID'] ?>"><?= $row['MovieTitle'] ?></a></h3>
				<a href="movieedit.php?id=<?= $row['MovieID'] ?>" class="edit">edit</a>
				<p class="postcontent"><?= substr($row['MovieDescription'], 0, 200); ?> <a href="fullpost.php?id=<?= $row['MovieID'] ?>">...Read full description</a></p>
		<?php endwhile ?>
	<?php endif ?>
</body>
</html>