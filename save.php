<?php
require_once ('application/functions.php');

if(isset($_POST['submitNewBook'])) {
	$id = bookNew($bookNew);
	$page = 'book.php?id=' . $id;
}

if(isset($_POST['submitEditBook'])) {
	$id = bookEdited($bookNew);
	$page = 'book.php?id=' . $id;
}
header('Location: '.$page);
exit;
?>
