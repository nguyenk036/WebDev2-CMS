<?php

	require 'authenticate.php';
	require 'db_connect.php';

	include 'ImageResize.php';
	use \Gumlet\ImageResize;

	$getGenres = "SELECT * FROM Genre";
	$statement = $db->prepare($getGenres);
	$statement->execute();

	$statusMessage = "";


	function file_upload_path($original_filename, $upload_subfolder_name = 'savedImages\movieImages') {
	       $current_folder 		= dirname(__FILE__);
	       $title_no_whitespace = str_replace(' ', '', $_POST['title']);
	       $new_file_name 		= $title_no_whitespace . '.' . pathinfo($original_filename, PATHINFO_EXTENSION);
	       
	       $path_segments 		= [$current_folder, $upload_subfolder_name, $new_file_name];
	       
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

    
	if(isset($_POST) && !empty($_POST['title']) && !empty($_POST['description'])){
		$title 			= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$description 	= filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$genre 			= filter_input(INPUT_POST, 'genre', FILTER_VALIDATE_INT);
		$ImageRef		= "";

		$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

		// Image Upload
		if ($image_upload_detected) { 
	        $image_filename        = $_FILES['image']['name'];
	        $temporary_image_path  = $_FILES['image']['tmp_name'];
	        $new_image_path        = file_upload_path($image_filename);
	        
	        if (file_is_acceptable($temporary_image_path, $new_image_path)) {
	        		move_uploaded_file($temporary_image_path, $new_image_path);

		        	$image = new ImageResize($new_image_path);
		        	$image->resize(640, 400, true);
		        	$image->save($new_image_path);

		        	$ImageRef = pathinfo($new_image_path, PATHINFO_BASENAME);

		        	$query 	   = "INSERT INTO movie (GenreID, MovieTitle, MovieDescription, ImageRef) VALUES (:genre, :title, :description, :ImageRef)";

			    	$statement = $db->prepare($query);
			    	$statement->bindValue(':genre', $genre);
			    	$statement->bindValue(':title', $title);
			    	$statement->bindValue(':description', $description);
			    	$statement->bindValue(':ImageRef', $ImageRef);

			    	$statement->execute();
	        }
	    }
	    else{

	    	$createMovie = "INSERT INTO movie (GenreID, MovieTitle, MovieDescription) VALUES (:genre, :title, :description)";
			$statement 	= $db->prepare($createMovie);

			$statement->bindValue(':title', $title);
			$statement->bindValue(':description', $description);
			$statement->bindValue(':genre', $genre);

			$statement->execute();
	    }
		

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
<body class="bg-dark text-light">
	<?php include('navbar.php'); ?>

	<form method="post" action="newmovie.php" enctype="multipart/form-data">
		<div>
			<label for="title" class="d-block m-2">Title</label>
        	<input id="title" name="title" class="d-block m-2">
		</div>
        <div>
        	<label for="description" class="d-block m-2">Description</label>
        	<textarea id="description" name="description" cols="68" class="d-block m-2" style="resize: none;"></textarea>
        </div>
        <div>
			<label for="genre" class="d-block m-2">Genre</label>
        	<select name="genre" class="d-block m-2">
        		<?php foreach ($statement as $genre): ?>
        			<option value="<?php echo $genre[0] ?>"><?php echo $genre[1] ?></option>
        		<?php endforeach ?>
        	</select>
		</div>
		<div>
			<label for="image" class="d-block m-2">Filename:</label>
        	<input type="file" name="image" id="image" class="d-block m-2" />
		</div>
        <div id="buttons">
        	<input type="submit" class="d-block m-2">
        </div>
        
    </form>

    <h4 class="m-2"><?= $statusMessage ?></h4>

	<a href="movies.php" class="btn btn-dark d-block m-2">Return to Movies</a>
</body>
</html>