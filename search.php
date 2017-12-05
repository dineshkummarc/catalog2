<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-md-12">
		<?php
		$needle = strtolower($_POST['needle']);
		$haystack = strtolower($_POST['haystack']);
		if ($haystack == 'all') {
			$wording = 'all fields';
		} else if ($haystack == 'isbn') {
			$wording = 'ISBN';
		} else if ($haystack == 'genres') {
			$wording = 'genre';
		} else {
			$wording = $haystack;
		}
		echo '<h3>Search results for "' . $needle . '" in field: ' . $wording .'</h3>';
		searchCollection($needle, $haystack);
		?>
	</div>
</div>
<?php include_once ('application/snippets/footer.php'); ?>
