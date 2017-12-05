<?php include_once ('application/snippets/header.php'); ?>

<div class="row">
	<div class="col-12">
		<h3>Add an item to your collection</h3>

		<form method="post" action="save.php" enctype="multipart/form-data">
			<div class="form-group">
				<label for="author">Author <span>(separate multiple authors by semicolon)</span></label>
				<?php include_once('application/snippets/autocomplete/author.php'); ?>
				<input class="form-control" type="text" name="author" id="author_input" />
			</div>
			<div class="form-group">
				<label for="title">Title</label>
				<input class="form-control" type="text" name="title" id="title" required />
			</div>
			<div class="form-group">
				<label for="isbn">ISBN Number</label>
				<input class="form-control" type="text" name="isbn" id="isbn" />
			</div>
			<div class="form-group">
				<label for="publisher">Publisher</label>
				<?php include_once('application/snippets/autocomplete/publisher.php'); ?>
				<input class="form-control" type="text" name="publisher" id="publisher_input" />
			</div>
			<div class="form-group">
				<label for="year">Year Published</label>
				<input class="form-control" type="text" name="year" id="year" />
			</div>
			<div class="form-group">
				<label for="genre">Genre <span>(separate multiple genre labels by semicolon)</span></label>
				<?php include_once('application/snippets/autocomplete/genre.php'); ?>
				<input class="form-control" type="text" name="genre" id="genre_input" />
			</div>
			<div class="form-group">
				<label for="cover">Cover Image</label>
				<input class="form-control" type="text" name="cover" id="cover" />
			</div>
			<div class="form-group">
				<label for="description">Description <span>(accepts Markdown)</span></label>
				<textarea class="form-control" name="description" id="description"></textarea>
			</div>
			<label for="alert">Is item an ebook?</label>
			<div class="alert alert-secondary" role="alert">
				<div class="form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="checkbox" name="ifEbook" value="">
						This item is an ebook
					</label>
				</div>
				<p></p>
				<div class="form-group">
					<div class="col-12 pl-0">
						<label for="file" class="indented"><span>Upload an ebook file (<abbr id="fileTypes" data-toggle="tooltip" data-placement="right" title=".cbr, .cbz, .cb7, .cbt, .cba, .djvu, .doc, .docx, .epub, .fb2, .html, .ibook, .inf, .azw, .lit, .prc, .mobi, .pkg, .pdb, .txt, .pdf, .ps, .tr2, .tr3, .oxps, .xps, .zip, .gzip, .7z, .tar, .rar, .rtf, .md, .mdown, .markdown">Allowed file types</abbr>)</span></label>
					</div>
					<label class="custom-file">
						<input type="file" id="file" name="bookfile[]">
						<span class="custom-file-control"></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="location">Location</label>
				<?php include_once('application/snippets/autocomplete/location.php'); ?>
				<input class="form-control" type="text" name="location" id="location_input" />
			</div>
			<div class="form-group">
				<input class="btn btn-primary" type="submit" name="submitNewBook" value="Add new item" />
			</div>
		</form>

	</div>
</div>

<?php include_once ('application/snippets/footer.php'); ?>
