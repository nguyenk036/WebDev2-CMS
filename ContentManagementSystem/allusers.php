<?php

	include 'session_connection.php';

	$getUsers = "SELECT * FROM users";
	$userStatement = $db->prepare($getUsers);
	$userStatement->execute();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel - All Users</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark text-light">
	<?php include('navbar.php'); ?>

	<?php if($_SESSION['user_id'] && $user->AdminStatus > 0): ?>
		<h2 class="m-2">All Users</h2>
		<a href="register.php" class="btn btn-primary m-2">+ Add User</a>
		<table class="table table-hover table-dark">
			<tr>
				<th>Username</th>
				<th>Name</th>
				<th>E-mail</th>
				<th>Administrative Status</th>
				<th>Date Created</th>
			</tr>
			<?php while($row = $userStatement->fetch()): ?>
				<tr>
					<td><?= $row['Username'] ?></td>
					<td><?= $row['Name'] ?></td>
					<td><?= $row['Email'] ?></td>
					<td><?php if($row['AdminStatus'] == 1): ?>
							Yes
						<?php else: ?>
							No
						<?php endif?>
					</td>
					<td><?= $row['DateCreated'] ?></td>
					<td><a href="edituser.php?uid=<?= $row['UserID'] ?>" class="btn btn-primary">Edit</a></td>
				</tr>
			<?php endwhile ?>
		</table>
	<?php else: ?>
		<?php header("Location: login.php"); ?>
	<?php endif ?>
</body>
</html>