<?php
session_start();
include('includes/config.php');
if (isset($_POST['login'])) {
	$uname = $_POST['username'];
	$password = md5($_POST['password']);
	$sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
	$query = $dbh->prepare($sql);
	$query->bindParam(':uname', $uname, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		$_SESSION['alogin'] = $_POST['username'];
		echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
	} else {
		echo "<script>alert('Invalid Details');</script>";
	}
}
?>

<!DOCTYPE HTML>
<html>

<head>
	<title>B&B Travels and Tours Pvt. Ltd. Admin Sign in</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/morris.css" type="text/css" />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<!-- jQuery -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<!-- //jQuery -->
	<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->

	<!-- Additional CSS for Styling -->
	<style>
		body {
			background: url('../assets/images/sange.jpg') no-repeat center center fixed;
			background-size: cover;
			font-family: 'Montserrat', sans-serif;
		}
		.main-wthree {
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			padding: 20px;
			background: rgba(0, 0, 0, 0.5); /* Dark overlay */
		}
		.sin-w3-agile {
			background: #fff;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
			text-align: center;
			max-width: 400px;
			width: 100%;
			position: relative;
		}
		.sin-w3-agile h2 {
			margin-bottom: 30px;
			font-size: 24px;
			color: #333;
			position: relative;
		}
		.sin-w3-agile h2::after {
			content: '';
			width: 50px;
			height: 3px;
			background: #5151E5;
			position: absolute;
			bottom: -10px;
			left: 50%;
			transform: translateX(-50%);
		}
		.form-control {
			border-radius: 20px;
			padding: 10px 15px;
			font-size: 16px;
			margin-bottom: 20px;
			border: 1px solid #ddd;
			box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
			transition: all 0.3s ease-in-out;
		}
		.form-control:focus {
			border-color: #5151E5;
			box-shadow: 0 0 8px rgba(81, 81, 229, 0.1);
		}
		.login-w3 input {
			background: #5151E5;
			border: none;
			padding: 10px 20px;
			border-radius: 20px;
			color: #fff;
			font-size: 18px;
			cursor: pointer;
			transition: all 0.3s ease-in-out;
		}
		.login-w3 input:hover {
			background: #4141d5;
		}
		.back a {
			color: #333;
			text-decoration: none;
			display: inline-block;
			margin-top: 20px;
			transition: all 0.3s ease-in-out;
		}
		.back a:hover {
			color: #5151E5;
			text-decoration: underline;
		}
	</style>
</head>

<body>
	<div class="main-wthree">
		<div class="container">
			<div class="sin-w3-agile">
				<h2>Sign In</h2>
				<form method="post">
					<div class="form-group">
						<label for="username">Username:</label>
						<input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required="">
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required="">
					</div>
					<div class="login-w3">
						<input type="submit" class="login" name="login" value="Sign In">
					</div>
				</form>
				<div class="back">
					<a href="../index.php">Back to home</a>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
