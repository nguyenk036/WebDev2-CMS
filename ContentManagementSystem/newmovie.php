<?php

	require 'authenticate.php';
	require 'db_connect.php';

	$getGenres = "SELECT * FROM Genre";
	$statement = $db->prepare($getGenres);
	$statement->execute();

	$statusMessage = "";

	if(isset($_POST) && !empty($_POST['title']) && !empty($_POST['description'])){
		$title 			= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description 	= filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$genre 			= filter_input(INPUT_POST, 'genre', FILTER_VALIDATE_INT);

		$createMovie = "INSERT INTO movie (GenreID, MovieTitle, MovieDescription) VALUES (:genre, :title, :description)";
		$statement 	= $db->prepare($createMovie);

		$statement->bindValue(':title', $title);
		$statement->bindValue(':description', $description);
		$statement->bindValue(':genre', $genre);

		if($statement->execute()){
			$statusMessage = "Successfully created";
		}
	}
	else if(isset($_POST['submit']) && isset($_POST['title']) || isset($_POST['description'])){
		$statusMessage = "** Fields cannot be empty";
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>New Movie</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php include('navbar.php'); ?>

	<form method="post" action="newmovie.php">
		<div>
			<label for="title">Title</label>
        	<input id="title" name="title">
		</div>
        <div>
        	<label for="description">Description</label>
        	<textarea id="description" name="description" cols="68"></textarea>
        </div>
        <div>
			<label for="genre">Genre</label>
        	<select name="genre">
        		<?php foreach ($statement as $genre): ?>
        			<option value="<?php echo $genre[0] ?>"><?php echo $genre[1] ?></option>
        		<?php endforeach ?>
        	</select>
		</div>
        <div id="buttons">
        	<input type="submit">
        </div>
        
    </form>

    <h4><?= $statusMessage ?></h4>

	
</body>
</html>