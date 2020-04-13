<?php

	include 'session_connection.php';

	$getUser = $db->prepare("SELECT * FROM users WHERE UserId = " . $_GET['uid']);
	$getUser->execute();


?>

<!DOCTYPE html>
<html>
<head>
	<title>Editing User</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php include('navbar.php'); ?>
	<?php if($_SESSION['user_id'] && $user->AdminStatus > 0): ?>
		<form method="post" action="edituser.php">
			<input type="hidden" name="uid" value="<?= $user['UserID'] ?>">
			<div>
				<label for="username" class="d-block m-2">Username</label>
				<input name="username" class="d-block m-2" value="<?= $user['Username'] ?>">
			</div>
			<div>
				<label for="password" class="d-block m-2">Password</label>
				<input type="Password" name="password" class="d-block m-2" value="<?= $user['Password'] ?>">
			</div>
			<div>
				<label for="name" class="d-block m-2">Name</label>
				<input name="name" class="d-block m-2" value="<?= $user['Name'] ?>">
			</div>
			<div>
				<label for="email" class="d-block m-2">Email</label>
				<input type="email" name="email" class="d-block m-2" value="<?= $user['email'] ?>">
			</div>
			<div>
				<label for="admin" class="d-block m-2">Administrative Level</label>
				<select name="admin" class="d-block m-2">
					<option value="0">User</option>
					<option value="1">Administrator</option>
				</select>
			</div>
			<div>
				<input type="submit" name="action" value="Update" class="m-2 btn btn-dark">
				<input type="submit" name="action" value="Delete" class="m-2 btn btn-dark">
			</div>
		</form>
</body>
</html>