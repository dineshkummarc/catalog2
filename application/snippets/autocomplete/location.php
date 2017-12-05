<?php
	$locationsFolder = new folder('data/locations');
	$locationsList = (array)$locationsFolder->files();
	$locations = array();
	foreach  ($locationsList['data'] as $location) {
		$fileName = urldecode($location->filename());
		$locationName = substr($fileName, 0, -4);
		$locations[] = $locationName;
	}
	$fuzzylocationList = json_encode($locations);
?>
<script type="text/javascript">
	$(function() {
		var availableTags = <?php echo $fuzzylocationList; ?>;
		$("#location_input").autocomplete({
			source: availableTags
		});
	});
</script>
