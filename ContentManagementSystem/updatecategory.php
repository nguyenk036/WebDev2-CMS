<?php

	require 'authenticate.php';
	require 'db_connect.php';

	$getGenres = "SELECT * FROM Genre";
	$statementarray = $db->prepare($getGenres);
	$statementarray->execute();

	if($_POST && $_POST['action'] == 'Update' && !empty($_POST['genre'])){
		$genre			= filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_NUMBER_INT);

		$query 		= "UPDATE genre SET CategoryName = :genre";
		$statement 	= $db->prepare($query);
		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':id', $id, PDO::PARAM_INT);
		$statement->bindValue(':genre', $genre, PDO::PARAM_INT);

		$statement->execute();

		header("Location: movieedit.php?id={$id}");
		exit;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>WebFlix Reviews - Update Genres</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark">
	<?php include('navbar.php'); ?>
	<form method="post" action="updatecategory.php">
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

	<a href="movies.php" class="btn btn-dark d-block m-2">Return to Movies</a>
</body>
</html>