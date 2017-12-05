<?php
	require_once('application/toolkit/bootstrap.php');
	s::destroy(s::id());
	s::remove(s::id());
	f::remove('application/session/session.session');
	header::redirect('index.php');
	exit;
?>
