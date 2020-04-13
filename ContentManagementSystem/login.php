<?php

	include 'session_connection.php';

	$login_error_message = '';

	if(!empty($_POST['btnLogin'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if($username == ""){
            $login_error_message = 'Username field is required.';
        }
        else if($password == ""){
            $login_error_message = 'Password field is required.';
        }
        else{
            $login = $app->Login($username, $password);

            if($login){
            	$user_id = $login['userID'];
            	$adminstatus = $login['AdminStatus'];

            	if($user_id > 0){
	                $_SESSION['user_id'] = $user_id;
	                $_SESSION['adminstatus'] = $adminstatus;
	                header("Location: profile.php");
	            }
	            
            }
            else{
                $login_error_message = 'Invalid login details.';
            }
        
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
                <h4>Login</h4>
                <?php
                if ($login_error_message != "") {
                    echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
                }
                ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="">Username/Email</label>
                        <input type="text" name="username" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
                    </div>
                </form>
            </div>
		</div>
	</div>
</body>
</html>