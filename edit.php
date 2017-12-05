<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-12">
		<?php
			$id = $_POST['id'];
			bookEdit($id);
		?>
	</div>
<?php include_once ('application/snippets/footer.php'); ?>
