<?php

    include 'session_connection.php';

    $register_error_message = '';
    $successful = false;

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
            $successful = true;
            $register_error_message = 'Successfully registered!';
            // header("Location: login.php");
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
                <?php if ($successful && $register_error_message != ""): ?>
                    <div class="alert alert-success">
                        <?= $register_error_message ?>
                    </div>
                <?php elseif(!$successful && $register_error_message != ""): ?>
                    <div class="alert alert-danger">
                        <strong>Error: </strong> <?= $register_error_message ?> 
                    </div>
                <?php endif ?>
                <form method="post">
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

<?php if($successful): ?>
    <div class="modal fade" id="registered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Successfully Registered</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
            <div class="modal-body">
                Account has been successfully created!
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <a href="login.php" class="btn btn-primary">Continue to Login</a>
            </div>
          
        </div>
      </div>
    </div>
<?php endif ?>
</body>
</html>