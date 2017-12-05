<?php
	$authorsFolder = new folder('data/authors');
	$authorsList = (array)$authorsFolder->files();
	$authors = array();
	foreach  ($authorsList['data'] as $author) {
		$fileName = urldecode($author->filename());
		$authorName = substr($fileName, 0, -4);
		$authors[] = $authorName;
	}
	$fuzzyauthorList = json_encode($authors);
?>
<script type="text/javascript">
	$(function() {
		var availableTags = <?php echo $fuzzyauthorList; ?>;
		$("#author_input").autocomplete({
			source: availableTags
		});
	});
</script>
