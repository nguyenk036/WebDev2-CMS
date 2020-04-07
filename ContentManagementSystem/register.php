<?php

	require('db_connect.php');

	$username = "";
	$password = "";
	$confirm_password = "";
	$username_err = "";
	$password_err = "";
	$confirm_password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){

		// Username validation
		if(empty(trim($_POST['username']))){

			$username_err = "Please enter a username.";

		}
		else{

			$query 

		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register a New User</title>
</head>
<body class="bg-dark text-light">

	<?php include('navbar.php'); ?>

	<div class="row">
        <div class="col-md-5 well">
            <h4>New User</h4>

            <?php if ($register_error_message != ""): ?>
                <div class="alert alert-danger"><strong>Error: <?= $register_error_message ?></strong></div>
            <?php endif?>

            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                </div>
            </form>
        </div>
    </div>

</body>
</html>