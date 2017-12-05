<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-md-12">
		<h3>Delete item</h3>
		<?php
			$id = $_POST['id'];
			bookDelete($id);
		?>
	</div>
</div>
<?php include_once ('application/snippets/footer.php'); ?>
