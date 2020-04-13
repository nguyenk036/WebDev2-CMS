<?php

	include 'session_connection.php';

	$getImageRef = "SELECT ImageRef FROM movie WHERE MovieID = " . $_GET['id'];
	$imgref = $db->prepare($getImageRef);
	$imgref->execute();
	$rowImage = $imgref->fetch();

	if(isset($_GET['id']) || isset($_POST)){
		$id 		= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		$query 		= "SELECT * FROM movie WHERE MovieID = :id";
		$getComments = "SELECT * FROM Comments WHERE MovieID = :id ORDER BY CommentDate DESC";
		$statement 	= $db->prepare($query);
		$statement2 = $db->prepare($getComments);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement2->bindValue(':id', $id, PDO::PARAM_INT);

		$statement->execute();
		$statement2->execute();

		$movie 		= $statement->fetch();
	}

	if(isset($_POST) && !empty($_POST['comment']) && !empty($_POST['username'])){
		$name 		= filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$comment 	= filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$id 		= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		$createComment = "INSERT INTO comments (MovieID, Name, Comment) VALUES (:id, :name, :comment)";
		$statement 	= $db->prepare($createComment);

		$statement->bindValue(':id', $id);
		$statement->bindValue(':name', $name);
		$statement->bindValue(':comment', $comment);

		$statement->execute();

		echo "<meta http-equiv='refresh' content='0'>";
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
<body class="bg-dark text-light">

	<?php include('navbar.php'); ?>
	<h3 class="d-inline m-2"><?= $movie['MovieTitle'] ?></h3>
	<a href="movieedit.php?id=<?= $movie['MovieID'] ?>" class="btn btn-secondary btn-sm m-2">edit</a>
	<?php if($rowImage['ImageRef'] != NULL): ?>
		<img src="savedimages/movieImages/<?= $movie['ImageRef'] ?>" alt="MoviePoster" class="d-block rounded border border-white m-2 float-left">
	<?php endif?>
	<p class="font-weight-light m-2 clearfix"><?= $movie['MovieDescription'] ?></p>

	<div>
		<h4 class="m-2">Leave a comment below:</h4>
		<form method="post" action="fullmoviedescription.php?id=<?= $movie['MovieID'] ?>">
			<div>
				<label for="username" class="d-block m-2">Name</label>
	        	<input id="username" name="username" class="d-block m-2">
			</div>
	        <div>
	        	<label class="d-block m-2" for="comment">Comment</label>
	        	<textarea id="comment" name="comment" cols="68" class="d-block m-2" style="resize: none;"></textarea>
	        </div>
	        <div id="buttons">
	        	<input type="submit" class="d-block m-2">
	        </div>
	    </form>
	</div>

	<a href="movies.php" class="btn btn-dark d-block m-2">Return to Movies</a>

	<div>
		<?php if($statement2->rowCount() === 0): ?>
			<p class="m-2 d-block">There are no comments.</p>
		<?php else: ?>

			<?php while($row = $statement2->fetch()): ?>
				<div class="border border-white p-2 m-1">
					<h5><?= $row['Name']?></h6>
					<p>Posted: <?= $row['CommentDate'] ?></p>
					<p><?= $row['Comment'] ?></p>
				</div>
			<?php endwhile ?>

		<?php endif ?>
	</div>

</body>
</html>