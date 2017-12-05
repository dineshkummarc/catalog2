<?php
require_once('application/toolkit/bootstrap.php');

if (isset($_POST['registerSubmit'])) {
	$username = $_POST['username'];
	$password = password::hash($_POST['password']);
	$apikey = $_POST['apikey'];
	yaml::write('application/config/config.yml', array(
		'username' => $username,
		'password' => $password,
		'apikey' => $apikey,
		'nicename' => ''
	));
	header::redirect('login.php');
	exit;
} else if (file_exists('application/config/config.yml')) {
	header::redirect('login.php');
	exit;
} else { ?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keyword" content="">

		<title>Catalog 2</title>

		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom styles -->
		<link href="bootstrap/css/supplement.css" rel="stylesheet">
		<!-- countdown script -->

		<script src="bootstrap/js/jquery-3.2.1.slim.min.js"></script>
		<script src="bootstrap/js/popper.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>

	</head>

	<body>
		<div class="container">
			<div class="row desktopOnly"></div>
			<div class="row">
				<div class="col-md-4 desktopOnly"></div>
				<div class="col-md-4">
					<h3>Welcome to Catalog2</h3>
					<div class="alert alert-warning" role="alert">
						You must create a user to continue.
					</div>
					<form method="post" action="">
						<div class="form-group">
							<label for="username">Username</label>
							<input class="form-control" type="text" name="username" id="username" required />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input class="form-control" type="password" name="password" id="password" required />
						</div>
						<div class="form-group">
							<label for="apikey">Google Books API Key <span>(You can set this up later)</span></label>
							<input class="form-control" type="text" name="apikey" id="apikey" />
						</div>
						<div class="form-group">
							<input class="btn btn-primary" type="submit" name="registerSubmit" value="Create user" />
						</div>
					</form>
				</div>
				<div class="col-md-4 desktopOnly"></div>
			</div>
		</div>
	</body>

	</html>

<?php } ?>
