<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-12">
		<?php
		$url = $_SERVER['REQUEST_URI'];
		$view = parse_url($url, PHP_URL_QUERY);

		if (strpos($view, 'genre') !== FALSE) {
			$needle = urldecode(str_replace('genre=', '',$view));
			displayGenre($needle);
		}

		if (strpos($view, 'publisher') !== FALSE) {
			$needle = urldecode(str_replace('publisher=', '',$view));
			displayPublisher($needle);
		}

		if (strpos($view, 'author') !== FALSE) {
			$needle = urldecode(str_replace('author=', '',$view));
			displayAuthor($needle);
		}

		if (strpos($view, 'year') !== FALSE) {
			$needle = urldecode(str_replace('year=', '',$view));
			displayYear($needle);
		}

		?>
	</div>
</div>
<?php include_once ('application/snippets/footer.php'); ?>
