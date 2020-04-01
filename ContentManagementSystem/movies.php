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
<body class="bg-dark">
	<!-- Navigation bar -->
	<?php include('navbar.php'); ?>

	<!-- Dropdown List of Actions -->
	<div class="dropdown m-2">
		
	  <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Add/Edit...
	  </a>

	  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
	    <a class="dropdown-item" href="newmovie.php">Add Movie</a>
	    <a class="dropdown-item" href="newcategory.php">Add Genre</a>
	    <a class="dropdown-item" href="updatecategory.php">Edit Genres</a>
	  </div>

	</div>

	<?php if($statement->rowCount() === 0): ?>
			<h2>There are no movies.</h2>
	<?php else: ?>
		<div class="row row-cols-1 row-cols-md-3">
			<?php while($row = $statement->fetch()): ?>
				<div class="col mb-4">
					<div class="card bg-secondary w-100">
						<?php if(empty($row['ImageRef'])): ?>
							<a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>"><img src="no-img-placeholder.png" class="card-img-top" alt="#"></a>
						<?php else: ?>
							<a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>"><img src="<?= $row['ImageRef'] ?>" class="card-img-top" alt="#"></a>
						<?php endif ?>
						<div class="card-body">
							<h5 class="card-title"><a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>" class="text-primary"><?= $row['MovieTitle'] ?></a></h5>
							<p class="card-text text-light"><?= substr($row['MovieDescription'], 0, 50); ?> <a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>">...more</a></p>
						</div>
					</div>
				</div>
				
				<!-- <h3><a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>" class="text-primary"><?= $row['MovieTitle'] ?></a></h3>
				<a href="movieedit.php?id=<?= $row['MovieID'] ?>" class="text-primary">edit</a>
				<p class="text-light"><?= substr($row['MovieDescription'], 0, 50); ?> <a href="fullmoviedescription.php?id=<?= $row['MovieID'] ?>">...Read full description</a></p> -->
			<?php endwhile ?>
		</div>
		
	<?php endif ?>
</body>
</html>