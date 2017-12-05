<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-12">
		<?php
		$folder = new folder('data/books');
		$all = $folder->files();
		$booksNum = count($all);
		if ($booksNum == 1)	{
			$wording = 'item';
		} else {
			$wording = 'items';
		}
		echo '<h3>Search your '. $booksNum . ' ' . $wording .'</h3>';
		?>
	</div>
</div>

<form method="post" action="search.php" class="searchForm">
	<div class="row search">
		<div class="form-group col-md-7 mb-3">
			<input type="text" class="form-control" id="needle" name="needle" placeholder="Text to search" required />
		</div>
		<div class="form-group col-md-3 mb-3">
			<div class="input-group">
				<div class="input-group-addon">in</div>
				<select class="custom-select" name="haystack" id="haystack" required>
					<option value="all">All fields</option>
					<option value="title">Title</option>
					<option value="author">Author</option>
					<option value="isbn">ISBN</option>
					<option value="publisher">Publisher</option>
					<option value="year">Year published</option>
					<option value="genres">Genre</option>
					<option value="description">Description</option>
					<option value="location">Location</option>
				</select>
			</div>
		</div>
		<div class="form-group col-md-2 mb-3">
			<input class="btn btn-primary btn-block" type="submit" name="submitSearch" value="Search" />
		</div>
	</div>
</form>

<div class="row">
	<div class="col-12">
		<h3>Browse your collection</h3>
		<?php readCollection(); ?>
	</div>
</div>
<?php include_once ('application/snippets/footer.php'); ?>
