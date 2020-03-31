<?php

	require 'authenticate.php';
	require 'db_connect.php';

	$getGenres = "SELECT * FROM Genre";
	$statementarray = $db->prepare($getGenres);
	$statementarray->execute();

	if($_POST && $_POST['action'] == 'Update' && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['id'])){
		$title 			= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description 	= filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$genre			= filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_NUMBER_INT);
		$id 			= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

		$query 		= "UPDATE movie SET GenreID = :genre, MovieTitle = :title, MovieDescription = :description WHERE MovieID = :id";
		$statement 	= $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->bindValue(':genre', $genre, PDO::PARAM_INT);

		$statement->execute();

		header("Location: movieedit.php?id={$id}");
		exit;
	}
	else if($_POST && $_POST['action'] == 'Delete'){
		$id 		= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

		$query 		= "DELETE FROM movie WHERE MovieID = :id";
		$statement 	= $db->prepare($query);
		$statement->bindValue(':id', $id);

		$statement->execute();

		header("Location: home.php");
		exit;
	}
	else if(isset($_GET['id'])){
		$id 		= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

		$query 		= "SELECT * FROM movie WHERE MovieID = :id";
		$statement 	= $db->prepare($query);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);

		$statement->execute();
		$post 		= $statement->fetch();
	}
	else{
		$id 		= false;
		$title 		= false;
		$content 	= false;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>WebFlix Reviews - <?= $post['MovieTitle'] ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<?php include('navbar.php'); ?>
	<?php if($id): ?>
		<form method="post" action="movieedit.php">
			<input type="hidden" name="id" value="<?= $post['MovieID'] ?>">
			<div>
				<label for="title">Title</label>
	        	<input id="title" name="title" value="<?= $post['MovieTitle'] ?>">
			</div>
	        <div>
	        	<label for="description">Description</label>
	        	<textarea id="description" name="description" cols="68"><?= $post['MovieDescription'] ?></textarea>
	        </div>
	        <div>
				<label for="genre">Genre</label>
	        	<select name="genre">
	        		<?php foreach ($statementarray as $genre): ?>
	        			<option value="<?php echo $genre[0] ?>"><?php echo $genre[1] ?></option>
	        		<?php endforeach ?>
	        	</select>
			</div>
	        <div id="buttons">
	        	<input type="submit" name="action" value="Update">
	        	<input type="submit" name="action" value="Delete">
	        </div>
	    </form>
	<?php elseif(!$id || !$title || !$description): ?>
		<p>ERROR: Title and/or content cannot be empty, or may contain inappropriate characters.  Please try again.</p>
	<?php endif ?>

</body>
</html>