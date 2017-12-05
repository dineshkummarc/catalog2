<?php
	ob_start();
	require_once('application/functions.php');

	$sessionId = yaml::read('application/session/session.session');
	if ($sessionId['sid'] !== s::id()) {
		header::redirect('login.php');
		exit;
	}
	$userLoggedIn = $sessionId['user'];
?>
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
	<link href="bootstrap/css/jquery-ui.min.css" rel="stylesheet">
	<!-- Custom styles -->
	<link href="bootstrap/css/supplement.css" rel="stylesheet">
	<!-- countdown script -->

	<script src="bootstrap/js/jquery-3.2.1.min.js"></script>
	<script src="bootstrap/js/popper.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/jquery-ui.min.js"></script>

</head>

<body>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>

	<div class="container">

		<?php
		$url = $_SERVER['REQUEST_URI'];
		?>

		<div class="row">
			<div class="col-12">
				<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
					<a class="navbar-brand" href="index.php">Catalog<sup>2</sup></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
						<ul class="nav navbar-nav">
							<li><a class="nav-item nav-link <?php if (strpos($url, 'index.php') !== FALSE) { echo 'active'; } ?>" href="index.php">Browse</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'new.php') !== FALSE) { echo 'active'; } ?>" href="new.php">Add new item</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'import.php') !== FALSE) { echo 'active'; } ?>" href="import.php">Import new item</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'author') !== FALSE) { echo 'active'; } ?>" href="authors.php">Authors</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'publisher') !== FALSE) { echo 'active'; } ?>" href="publishers.php">Publishers</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'genre') !== FALSE) { echo 'active'; } ?>" href="genres.php">Genres</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'ebooks') !== FALSE) { echo 'active'; } ?>" href="ebooks.php">Ebooks</a></li>
							<li><a class="nav-item nav-link <?php if (strpos($url, 'lent') !== FALSE) { echo 'active'; } ?>" href="lent.php">Lent items</a></li>
						</ul>
						<ul class="nav navbar-nav ">
							<li class="nav-item dropdown">
        						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<?php
										$userData = yaml::read('application/config/config.yml');
										if ($userData['nicename'] !== '') {
											echo $userData['nicename'];
										} else {
											echo $userData['username'];
										}
          							?>
        						</a>
        						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
          							<a class="dropdown-item" href="user.php">Your profile</a>
          							<a class="dropdown-item" href="random.php">A random book for you</a>
          							<div class="dropdown-divider"></div>
          							<a class="dropdown-item" href="logout.php">Log out</a>
        						</div>
      						</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
