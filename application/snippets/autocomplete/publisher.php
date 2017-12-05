<?php
	$publishersFolder = new folder('data/publishers');
	$publishersList = (array)$publishersFolder->files();
	$publishers = array();
	foreach  ($publishersList['data'] as $publisher) {
		$fileName = urldecode($publisher->filename());
		$publisherName = substr($fileName, 0, -4);
		$publishers[] = $publisherName;
	}
	$fuzzypublisherList = json_encode($publishers);
?>
<script type="text/javascript">
	$(function() {
		var availableTags = <?php echo $fuzzypublisherList; ?>;
		$("#publisher_input").autocomplete({
			source: availableTags
		});
	});
</script>
