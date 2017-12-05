<?php
	$genresFolder = new folder('data/genres');
	$genresList = (array)$genresFolder->files();
	$genres = array();
	foreach  ($genresList['data'] as $genre) {
		$fileName = urldecode($genre->filename());
		$genreName = substr($fileName, 0, -4);
		$genres[] = $genreName;
	}
	$fuzzyGenreList = json_encode($genres);
?>
<script type="text/javascript">
	$(function() {
		var availableTags = <?php echo $fuzzyGenreList; ?>;
		$("#genre_input").autocomplete({
			source: availableTags
		});
	});
</script>
