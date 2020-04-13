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
		<div class="well">
			<h2>Profile</h2>
			<h3>Welcome <?php echo $user->name ?></h3>
			<a href="logout.php" class="btn btn-primary">Logout</a>
		</div>
	</div>
</body>
</html>

