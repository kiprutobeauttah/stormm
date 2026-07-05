<?php
session_start();
include "config.php";
include "./assets/components/login-arc.php";



if(isset($_COOKIE['logindata']) && $_COOKIE['logindata'] == $key['token'] && $key['expired'] == "no"){
    $_SESSION['IAm-logined'] = 'yes';
	header("location: panel.php");
}


elseif(isset($_SESSION['IAm-logined'])){
	header('location: panel.php');
	exit;
}


else{ 
	
	?>


    <!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Stormm - Login</title>
		<link href="./assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="./assets/css/style.css">
	</head>

	<body class="login-layout">
        <div id="login" class="wp-login-wrapper">
            <div class="wp-login-card">
                <div class="wp-login-header">
                    <div class="wp-login-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h1>Stormm</h1>
                    <p>Welcome back</p>
                </div>

                <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if(isset($_POST['username']) && isset($_POST['password'])){
                        $username = $_POST['username'];
                        $password = $_POST['password'];

                        if(isset($CONFIG[$username]) && $CONFIG[$username]['password'] == $password){
                            $_SESSION['IAm-logined'] = $username;
                            echo '<script>location.href="panel.php"</script>';
                        }else{
                            echo '<div class="wp-login-error">Username or password is incorrect!</div>';
                        }
                    }
                }
                ?>

                <form action="" method="POST" class="wp-login-form">
                    <label for="username">Username or Email Address</label>
                    <input type="text" name="username" id="username" class="form-control" value="" size="20" required autofocus>

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="" size="20" required>

                    <button class="wp-btn-submit" type="submit" name="wp-submit">Log In</button>
                </form>
            </div>

            <div class="wp-login-footer">
                <p>Stormm V3 &mdash; Dashboard</p>
            </div>
        </div>
	</body>
	</html>



	<?php
}

?>
