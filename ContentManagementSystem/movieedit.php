<?php

	require 'authenticate.php';
	require 'db_connect.php';

	include 'ImageResize.php';
	use \Gumlet\ImageResize;

	$getGenres = "SELECT * FROM Genre";
	$statementarray = $db->prepare($getGenres);
	$statementarray->execute();


	if($_POST && $_POST['action'] == 'Update' && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['id'])){
		$title 			= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description 	= filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$genre			= filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_NUMBER_INT);
		$id 			= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
		
		$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
		$ImageRef 			   = "";

		function file_upload_path($original_filename, $upload_subfolder_name = 'savedImages\movieImages') {
	       $current_folder = dirname(__FILE__);
	       
	       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
	       
	       return join(DIRECTORY_SEPARATOR, $path_segments);
	    }

	    function file_is_acceptable($temporary_path, $new_path) {
	        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
	        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
	        
	        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
	        $actual_mime_type        = getimagesize($temporary_path)['mime'];
	        
	        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
	        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
	        
	        return $file_extension_is_valid && $mime_type_is_valid;
	    }

	    // Image Upload
		if ($image_upload_detected) { 
	        $image_filename        = $_FILES['image']['name'];
	        $temporary_image_path  = $_FILES['image']['tmp_name'];
	        $new_image_path        = file_upload_path($image_filename);
	        
	        if (file_is_acceptable($temporary_image_path, $new_image_path)) {
	        		move_uploaded_file($temporary_image_path, $new_image_path);

		        	$image = new ImageResize($new_image_path);
		        	$image->resize(640, 400);
		        	$image->save($new_image_path);

		        	$ImageRef = $image_filename;

		        	$query 	= "INSERT INTO images (MovieID, imageName) VALUES (:id, :ImageRef)";
			    	$statement = $db->prepare($query);
			    	$statement->bindValue(':id', $id);
			    	$statement->bindValue(':ImageRef', $ImageRef);

			    	$statement->execute();
	        }
	    }

	    //Descriptions wont update..
		$query1 		= "UPDATE movie SET GenreID = :genre, MovieTitle = :title, MovieDescription = :description, ImageRef = :ImageRef WHERE MovieID = :id";
		$statement1 	= $db->prepare($query1);
		$statement1->bindValue(':title', $title);
		$statement1->bindValue(':description', $description);
		$statement1->bindValue(':id', $id, PDO::PARAM_INT);
		$statement1->bindValue(':genre', $genre);
		$statement1->bindValue(':ImageRef', $ImageRef);

		$statement1->execute();

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
<body class="bg-dark text-light">

	<?php include('navbar.php'); ?>
	<?php if($id): ?>
		<form method="post" action="movieedit.php" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?= $post['MovieID'] ?>">
			<div>
				<label for="title" class="d-block m-2">Title</label>
	        	<input id="title" name="title" class="d-block m-2" value="<?= $post['MovieTitle'] ?>">
			</div>
	        <div>
	        	<label for="description" class="d-block m-2">Description</label>
	        	<textarea id="description" class="d-block m-2" name="description" cols="68" style="resize: none;"><?= $post['MovieDescription'] ?></textarea>
	        </div>
	        <div>
				<label for="genre" class="d-block m-2">Genre</label>
	        	<select name="genre" class="d-block m-2">
	        		<?php foreach ($statementarray as $genre): ?>
	        			<option value="<?php $genre['GenreID'] ?>"><?php echo $genre['CategoryName'] ?></option>
	        		<?php endforeach ?>
	        	</select>
			</div>
			<div>
				<label for="image" class="d-block m-2">Filename:</label>
	        	<input type="file" name="image" id="image" class="d-block m-2 btn btn-dark"/>
			</div>
	        <div id="buttons">
	        	<input type="submit" name="action" value="Update" class="m-2 btn btn-dark">
	        	<input type="submit" name="action" value="Delete" class="m-2 btn btn-dark">
	        </div>
	    </form>
	<?php elseif(!$id || !$title || !$description): ?>
		<p>ERROR: Title and/or content cannot be empty, or may contain inappropriate characters.  Please try again.</p>
	<?php endif ?>
	
	<a href="movies.php" class="btn btn-dark d-block m-2">Return to Movies</a>
</body>
</html>