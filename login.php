<?php
require_once('application/toolkit/bootstrap.php');
if (!file_exists('application/config/config.yml')) {
	header::redirect('register.php');
	exit;
}
if (isset($_POST['loginSubmit'])) {
	$credentials = yaml::read('application/config/config.yml');
	if ($credentials['username'] === $_POST['username'] && password::match($_POST['password'], $credentials['password'])) {
		s::start();
		yaml::write('application/session/session.session', array(
			'sid' => s::id(),
			'user' => $_POST['username']
		));
		header::redirect('index.php');
		exit;
	} else {
		$alert = array('danger', 'Bad credentials.');
		include ('application/snippets/loginform.php');
	}
} else {
	$alert = array('warning', 'You must log in to continue.');
	include ('application/snippets/loginform.php');
}
?>
