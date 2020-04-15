<?php 
	
	//start a session
	include 'session_connection.php';

	if(empty($_SESSION['user_id'])){
		header("Location: home.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark text-light">
	<?php include('navbar.php'); ?>

	<div class="container">
		<div class="well m-2">
			<h2>Welcome <?php echo $user->name ?></h2>
			<a href="logout.php" class="btn btn-primary m-2">Logout</a>
		</div>
	</div>
</body>
</html>

