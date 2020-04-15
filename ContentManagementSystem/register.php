<?php

    include 'session_connection.php';

    $register_error_message = '';

    if(!empty($_POST['btnRegister'])){
        if ($_POST['name'] == "") {
            $register_error_message = 'Name field is required!';
        } else if ($_POST['email'] == "") {
            $register_error_message = 'Email field is required!';
        } else if ($_POST['username'] == "") {
            $register_error_message = 'Username field is required!';
        } else if ($_POST['password'] == "") {
            $register_error_message = 'Password field is required!';
        } else if($_POST['password'] != $_POST['confirmpassword']) {
            $register_error_message = 'Password confirmation does not match';
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $register_error_message = 'Invalid email address!';
        } else if ($app->isEmail($_POST['email'])) {
            $register_error_message = 'Email is already in use!';
        } else if ($app->isUsername($_POST['username'])) {
            $register_error_message = 'Username is already in use!';
        } else {
            $user_id = $app->Register($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password']);

            header("Location: login.php");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register a New User</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-dark text-light">

	<?php include('navbar.php'); ?>

	<div class="container">
        <div class="row">
            <div class="col-md-5 well m-auto pt-2">
                <h4>Register</h4>
                <?php
                if ($register_error_message != "") {
                    echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $register_error_message . '</div>';
                }
                ?>
                <form action="register.php" method="post">
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
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirm Password</label>
                        <input type="password" name="confirmpassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>