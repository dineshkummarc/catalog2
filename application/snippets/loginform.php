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
					<div class="alert alert-<?php echo $alert[0]; ?>" role="alert">
						<?php echo $alert[1]; ?>
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
							<input class="btn btn-primary" type="submit" name="loginSubmit" value="Log in" />
						</div>
					</form>
				</div>
				<div class="col-md-4 desktopOnly"></div>
			</div>
		</div>
	</body>

</html>
