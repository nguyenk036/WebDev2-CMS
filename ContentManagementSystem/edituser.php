<?php

	include 'session_connection.php';

	$error_message = '';

	if($_POST && $_POST['action'] == 'Update' && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['admin'])){
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		// $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$admin = filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_NUMBER_INT);
		$uid = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_NUMBER_INT);

		if($app->isEmail($email)){
			$error_message = 'Email is already in use.';
		}
		else if($app->isUsername($username)){
			$error_message = 'Username is already in use.';
		}
		else if($_POST['password'] != $_POST['confirmpassword']){
			$error_message = 'Passwords do not match';
		}
		else{
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$updateQuery = $db->prepare("UPDATE users SET Username = :username, Password = :password, Name = :name, Email = :email, AdminStatus = :admin WHERE UserID = :uid");
			$updateQuery->bindValue(':username', $username);
			$updateQuery->bindValue(':name', $name);
			$updateQuery->bindValue(':email', $email);
			$updateQuery->bindValue(':admin', $admin);
			$updateQuery->bindValue(':uid', $uid);
			$updateQuery->execute();
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'Delete'){
		$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$query = "DELETE FROM users WHERE UserID = :id";
		$deleteQuery = $db->prepare($query);
		$deleteQuery->bindValue(':id', $id, PDO::PARAM_INT);
		$deleteQuery->execute();

		header("Location: allusers.php");
	}

	
	if(isset($_GET['uid'])){
		$uid = filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT);
		$query = "SELECT * FROM users WHERE UserID = :uid";
		$getUser = $db->prepare($query);
		$getUser->bindValue(':uid', $uid, PDO::PARAM_INT);
		$getUser->execute();

		$user_selected = $getUser->fetch();
	}
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
<body class="bg-dark text-light">
	<?php include('navbar.php'); ?>

	<?php if($_SESSION['user_id'] && $_SESSION['adminstatus'] > 0): ?>
		<div class="container">
			<div class="row">
				<div class="col-md-5 well m-auto pt-2">
					<h4>Editing <?= $user_selected['Username'] ?></h4>
					<?php if($error_message != ""): ?>
						<div class="alert alert-danger">
							<strong>Error :</strong>
							<?= $error_message ?>
						</div>
					<?php endif ?>
					<form method="post" action="edituser.php">
						<input type="hidden" name="uid" value="<?= $user_selected['UserID'] ?>">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control" value="<?= $user_selected['Username'] ?>">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="Password" name="password" class="form-control">
						</div>
						<div class="form-group">
							<label for="confirmpassword">Confirm Password</label>
							<input type="Password" name="confirmpassword" class="form-control">
						</div>
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" class="form-control" value="<?= $user_selected['Name'] ?>">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" value="<?= $user_selected['Email'] ?>">
						</div>
						<div class="form-group">
							<label for="admin">Administrative Level</label>
							<select name="admin" class="form-control">
								<option value="0">User</option>
								<option value="1">Administrator</option>
							</select>
						</div>
						<div class="form-group">
							<input type="submit" name="action" value="Update" class="m-2 btn btn-dark">
							<input type="submit" name="action" value="Delete" class="m-2 btn btn-dark">
						</div>
					</form>
				</div>
			</div>
		</div>
		
	<?php else: ?>
		<?php header("Location: login.php"); ?>
	<?php endif ?>
</body>
</html>