<?php

/*.............................................................................
INCLUDE GETKIRBY TOOLKIT ......................................................
SOURCE: https://github.com/getkirby/toolkit ...................................
DOCUMENTATION: https://getkirby.com/docs/developer-guide/toolkit ..............
.............................................................................*/

require_once('toolkit/bootstrap.php');

/*.............................................................................
ADD NEW ITEMS TO THE COLLECTION ...............................................
USED IN save.php TO SAVE NEWLY ADDED BOOK DATA ................................
.............................................................................*/

function bookNew(&$bookNew) {
	/*
	include upload class, required for ebbok file uploads
	Catalog uses php-fileupload-class by Jovanni Lo
	See options and documentation here:
	https://github.com/lodev09/php-fileupload-class
	*/
	require_once('upload/class.file.php');
	require_once('upload/class.upload.php');
	// our base folder is data/books
	$folder = new folder('data/books');
	$data = $folder->files()->flip()->limit(1);
	foreach ($data as $file) {
		$fileData = yaml::read($file);
		$lastFile = $fileData['id'];
	}
	$fileId = $lastFile + 1;
	if($_POST['author'] === '') {
		$authors = array('null');
	} else {
		$_POST['author'] = rtrim($_POST['author'], '; ') . '';
		$authors = explode(';', $_POST['author']);
		$authors = array_map('trim', $authors);
	}
	if($_POST['genre'] === '') {
		$genres = array('null');
	} else {
		$_POST['genre'] = rtrim($_POST['genre'], '; ') . '';
		$genres = explode(';', $_POST['genre']);
		$genres = array_map('trim', $genres);
	}

	if($_POST['publisher'] === '') {
		$_POST['publisher'] = 'null';
	}
	if($_POST['year'] === '') {
		$_POST['year'] = 'null';
	}

	if (isset($_POST['ifEbook'])) {
		$type = 'ebook';
	} else {
		$type = 'book';
	}

	$bookNew = array(
		'id' => $fileId,
		'title' => $_POST['title'],
		'author' => $authors,
		'isbn' => $_POST['isbn'],
		'publisher' => $_POST['publisher'],
		'year' => $_POST['year'],
		'genres' => $genres,
		'cover' => $_POST['cover'],
		'description' => $_POST['description'],
		'type' => $type,
		'location' => $_POST['location']
	);
	$fileName = str_pad($fileId, 6, '0', STR_PAD_LEFT);

	yaml::write('data/books/'.$fileName.'.yml', $bookNew);

	// write to author index

	foreach ($authors as $author) {
		$author = urlencode($author);
		if ($author === '') {
			$author = 'null';
		}
		$authorFolder = new folder('data/authors');
		$data = $authorFolder->scan();
		if (in_array($author.'.yml', $data) === TRUE) {
			$authorFile = $authorFolder.'/'.$author.'.yml';
			$content = yaml::read($authorFile);
			array_push($content['books'], $fileName);
			yaml::write($authorFolder.'/'.$author.'.yml', $content);
		} else {
			$authorNew = array(
				'author' => urldecode($author),
				'books' => array($fileName)
			);
			yaml::write($authorFolder.'/'.$author.'.yml', $authorNew);
		}
	}

	// write to genre index

	foreach ($genres as $genre) {
		$genre = urlencode($genre);
		if ($genre === '') {
			$genre = 'null';
		}
		$genreFolder = new folder('data/genres');
		$data = $genreFolder->scan();
		if (in_array($genre.'.yml', $data) === TRUE) {
			$genreFile = $genreFolder.'/'.$genre.'.yml';
			$content = yaml::read($genreFile);
			array_push($content['books'], $fileName);
			yaml::write($genreFolder.'/'.$genre.'.yml', $content);
		} else {
			$genreNew = array(
				'genre' => urldecode($genre),
				'books' => array($fileName)
			);
			yaml::write($genreFolder.'/'.$genre.'.yml', $genreNew);
		}
	}

	// write to publisher index

	$publisher = urlencode($_POST['publisher']);
	if ($publisher === '') {
		$publisher = 'null';
	}
	$publisherFolder = new folder('data/publishers');
	$data = $publisherFolder->scan();
	if (in_array($publisher.'.yml', $data) === TRUE) {
		$publisherFile = $publisherFolder.'/'.$publisher.'.yml';
		$content = yaml::read($publisherFile);
		array_push($content['books'], $fileName);
		yaml::write($publisherFolder.'/'.$publisher.'.yml', $content);
	} else {
		$publisherNew = array(
			'publisher' => urldecode($publisher),
			'books' => array($fileName)
		);
		yaml::write($publisherFolder.'/'.$publisher.'.yml', $publisherNew);
	}

	// write to year index

	$year = urlencode($_POST['year']);
	if ($year === '') {
		$year = 'null';
	}
	$yearFolder = new folder('data/years');
	$data = $yearFolder->scan();
	if (in_array($year.'.yml', $data) === TRUE) {
		$yearFile = $yearFolder.'/'.$year.'.yml';
		$content = yaml::read($yearFile);
		array_push($content['books'], $fileName);
		yaml::write($yearFolder.'/'.$year.'.yml', $content);
	} else {
		$yearNew = array(
			'year' => urldecode($year),
			'books' => array($fileName)
		);
		yaml::write($yearFolder.'/'.$year.'.yml', $yearNew);
	}

	// if ebooks
	if (isset($_POST['ifEbook'])) {
		$ebookFolder = 'data/ebooks/'.$fileName;
		mkdir($ebookFolder);
		// file upload
		if (isset($_FILES['bookfile'])) {
			$validations = array(
				'category' => array('ebook'), // validate only those files within this list
				'size' => 200 // maximum of 20mb
			);

			// create new instance
			$upload = new Upload($_FILES['bookfile'], $validations);

			// for each file
			foreach ($upload->files as $file) {
				if ($file->validate()) {
					// do your thing on this file ...
					// ...
					// say we don't allow audio files
					if ($file->is('audio')) $error = 'Audio not allowed';
					else {
						// then get base64 encoded string to do something else ...
						$filedata = $file->get_base64();

						// or get the GPS info ...
						$gps = $file->get_exif_gps();

						// then we move it to 'path/to/my/uploads'
						$result = $file->put('./'.$ebookFolder);
						$error = $result ? '' : 'Error moving file';
					}

				} else {
					// oopps!
					$error = $file->get_error();
				}
				$filename = $file->name;
				// echo $file->name.' - '.($error ? ' [FAILED] '.$error : ' Succeeded!');
				// echo '<br />';
			}
		}
		// end file upload
	}

	// write location to .loc file
	$locationData = urlencode($_POST['location']);
	$locationsFolder = new folder('data/locations');
	$locationsList = (array)$locationsFolder->files();
	$locations = array();
	foreach  ($locationsList['data'] as $location) {
		$fileName = urldecode($location->filename());
		$locationName = substr($fileName, 0, -4);
		$locations[] = $locationName;
	}
	if (!in_array($locationData, $locations)) {
		f::write($locationsFolder.'/'.$locationData.'.loc', ' ', $append = false);
	}

	return $fileId;
}

/*.............................................................................
IMPORT NEW ITEMS FROM GOOGLE BOOKS ............................................
USED IN import.php TO FETCH BOOK DATA FROM GOOGLE BOOKS .......................
.............................................................................*/

function bookImport() {
	require_once('application/snippets/autocomplete/author.php');
	require_once('application/snippets/autocomplete/genre.php');
	require_once('application/snippets/autocomplete/publisher.php');
	require_once('application/snippets/autocomplete/location.php');
	if (isset($_POST['submitAPIKey'])) {
		$config = yaml::read('application/config/config.yml');
		$username = $config['username'];
		$password = $config['password'];
		$apikey = $_POST['apikey'];
		yaml::write('application/config/config.yml', array(
			'username' => $username,
			'password' => $password,
			'apikey' => $apikey
		));
	}
	if (isset($_POST['submitISBN'])) {
		/*
		Error reporting is set to ERROR only (ignoring NOTICEs and WARNINGs)
		so we can display nice error messages if there's a problem with
		connecting to Google Books via the API.
		For debugging purposes, you can comment out the next line of code.
		*/
		error_reporting(E_ERROR);
		$configFile = yaml::read('application/config/config.yml');
		$apikey = $configFile['apikey'];
		$isbn = $_POST['isbn'];
		$jsonFile = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=isbn:'.$isbn.'&key='.$apikey);
		if ($jsonFile) {
			$response = str::parse($jsonFile, $mode = 'json');
			$book = $response['items'][0]['volumeInfo'];
			$title = $book['title'];
			$authors = implode('; ', $book['authors']);
			$publisher = $book['publisher'];
			$year = substr($book['publishedDate'], 0, 4);
			$description = $book['description'];
			$coverFull = $book['imageLinks']['thumbnail'];
			$coverImg = explode('&zoom', $coverFull);
			$cover = $coverImg[0];
			echo '<form method="post" action="save.php">';
			echo '<div class="form-group">';
			echo '<label for="author">Author <span>(separate multiple authors by semicolon)</span></label>';
			echo '<input class="form-control" type="text" name="author" id="author_input" value="'.$authors.'" />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="title">Title</label>';
			echo '<input class="form-control" type="text" name="title" id="title" value="'.$title.'" required />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="isbn">ISBN Number</label>';
			echo '<input class="form-control" type="text" name="isbn" id="isbn" value="'.$isbn.'" />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="publisher">Publisher</label>';
			echo '<input class="form-control" type="text" name="publisher" id="publisher_input" value="'.$publisher.'" />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="year">Year Published</label>';
			echo '<input class="form-control" type="text" name="year" id="year" value="'.$year.'" />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="genre">Genre <span>(separate multiple genre labels by semicolon)</span></label>';
			echo '<input class="form-control" type="text" name="genre" id="genre_input" />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="cover">Cover Image</label>';
			echo '<input class="form-control" type="text" name="cover" id="cover" value="'.$cover.'"/>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="description">Description <span>(accepts Markdown)</span></label>';
			echo '<textarea class="form-control" name="description" id="description">'.$description.'</textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="location">Location</label>';
			echo '<input class="form-control" type="text" name="location" id="location_input" />';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<input class="btn btn-primary" type="submit" name="submitNewBook" value="Add new item" />';
			echo '</div>';
			echo '</form>';
		} else {
			echo '<div class="alert alert-danger" role="alert">';
			echo '<h5 class="alert-heading">No response :(</h5>';
			echo '<p>Possible causes are:</p><ul>';
			echo '<li>Bad API Key: please check your API Key in the config file: <code>application/config/config.yml</code>.</li>';
			echo '<li>You created an API Key, but Books API is not enabled: visit <a href="https://console.developers.google.com/apis/" target="_blank">Google APIs Console</a> and enable Books API.</li>';
			echo '<li>You are behind a proxy: check if your proxy settings allow API calls.</li>';
			echo '<li>Check your PHP settings: make sure that <code>allow_url_fopen</code> is set to <code>ON</code>.</li>';
			echo '<li>It\'s a long shot, but: are you connected to the Internet?</li>';
			echo '</ul><p class="mb-0">You can also <a href="new.php">add the item manually</a>.</p>';
			echo '</div>';
		}
	} else {
		$fieldStatus = array('<fieldset>', '</fieldset>');
		$configFile = yaml::read('application/config/config.yml');
		$apikey = $configFile['apikey'];
		if ($apikey === '' || !$apikey) {
			$fieldStatus = array('<fieldset disabled>', '</fieldset>');
			echo '<div class="alert alert-warning" role="alert">';
			echo '<h5 class="alert-heading">Missing API key</h5>';
			echo '<p>It looks like you haven\'t set up your Google Books API Key during user registration. Don\'t worry, you can do it now.</p>';
			echo '<form method="post" action="">';
			echo '<div class="row desktopOnly">';
			echo '<div class="col-10 pl-0">';
			echo '<input class="form-control" type="text" name="apikey" id="apikey" placeholder="Your Google Books API Key" required />';
			echo '</div>';
			echo '<div class="col-2 pr-0">';
			echo '<input class="btn btn-warning btn-block" type="submit" name="submitAPIKey" value="Save API Key" />';
			echo '</div>';
			echo '</div>';
			echo '<div class="row mobileOnly">';
			echo '<div class="col-12">';
			echo '<input class="form-control" type="text" name="apikey" id="apikey" placeholder="Your Google Books API Key" required /><br />';
			echo '</div>';
			echo '<div class="col-12">';
			echo '<input class="btn btn-warning btn-block" type="submit" name="submitAPIKey" value="Save API Key" />';
			echo '</div>';
			echo '</div>';
			echo '</form>';
			echo '</div>';
		}
		echo '<form method="post" action="">';
		echo $fieldStatus[0];
		echo '<div class="row desktopOnly">';
		echo '<div class="col-10 pl-0">';
		//echo '<label for="isbn">ISBN Number</label>';
		echo '<input class="form-control" type="text" name="isbn" id="isbn" placeholder="ISBN Number to search for on Google Books" required />';
		echo '</div>';
		echo '<div class="col-2 pr-0">';
		echo '<input class="btn btn-primary btn-block" type="submit" name="submitISBN" value="Search item" />';
		echo '</div>';
		echo '</div>';
		echo $fieldStatus[1];
		echo '</form>';
		echo '<div class="alert alert-info" role="alert">';
		echo '<p class="mb-0"><strong>Pro tip:</strong> if you have a barcode scanner, you can simply scan the barcode on the back of the book.</p>';
		echo '</div>';
	}
}

/*.............................................................................
SAVE ITEM MODIFICATIONS TO THE COLLECTION .....................................
USED IN save.php TO SAVE MODIFIED BOOK DATA ...................................
.............................................................................*/

function bookEdited(&$bookNew) {
	/*
	Since there are a lot of options for changes, it is easier
	to first remove the item from all indexes then write it back (even if
	no modifications were made regarding a specific index), than trying to
	code all possible scenarios in an "if changed/unchanged" approach.
	I havent observed significant speed loss because of this remove/rewrite.
	*/
	$fileId = (int)$_POST['id'];
	$fileName = str_pad($fileId, 6, '0', STR_PAD_LEFT);
	$bookData = yaml::read('data/books/'.$fileName.'.yml');
	$authors = $bookData['author'];
	$publisher = $bookData['publisher'];
	$year = $bookData['year'];
	$genres = $bookData['genres'];

	// remove book from author index

	foreach ($authors as $author) {
		$authorFile = 'data/authors/'.urlencode($author).'.yml';
		$content = yaml::read($authorFile);
		$booksArray = $content['books'];
		$key = array_search($fileName, $booksArray);
		unset($booksArray[$key]);
		array_values($booksArray);
		$authorNew = array(
			'author' => urldecode($author),
			'books' => $booksArray
		);
		yaml::write($authorFile, $authorNew);
		$content = yaml::read($authorFile);
		$booksArray = $content['books'];
		if (empty($booksArray)) {
			f::remove($authorFile);
		}
	}

	// write to author index

	if($_POST['author'] === '') {
		$authors = array('null');
	} else {
		$_POST['author'] = rtrim($_POST['author'], '; ') . '';
		$authors = explode(';', $_POST['author']);
		$authors = array_map('trim', $authors);
	}
	foreach ($authors as $author) {
		$author = urlencode($author);
		if ($author === '') {
			$author = 'null';
		}
		$authorFolder = new folder('data/authors');
		$data = $authorFolder->scan();
		if (in_array($author.'.yml', $data) === TRUE) {
			$authorFile = $authorFolder.'/'.$author.'.yml';
			$content = yaml::read($authorFile);
			array_push($content['books'], $fileName);
			yaml::write($authorFolder.'/'.$author.'.yml', $content);
		} else {
			$authorNew = array(
				'author' => urldecode($author),
				'books' => array($fileName)
			);
			yaml::write($authorFolder.'/'.$author.'.yml', $authorNew);
		}
	}

	// remove book from genre index

	foreach ($genres as $genre) {
		$genreFile = 'data/genres/'.urlencode($genre).'.yml';
		$content = yaml::read($genreFile);
		$booksArray = $content['books'];
		$key = array_search($fileName, $booksArray);
		unset($booksArray[$key]);
		array_values($booksArray);
		$genreNew = array(
			'genre' => urldecode($genre),
			'books' => $booksArray
		);
		yaml::write($genreFile, $genreNew);
		$content = yaml::read($genreFile);
		$booksArray = $content['books'];
		if (empty($booksArray)) {
			f::remove($genreFile);
		}
	}

	// write to genre index

	if($_POST['genre'] === '') {
		$genres = array('null');
	} else {
		$_POST['genre'] = rtrim($_POST['genre'], '; ') . '';
		$genres = explode(';', $_POST['genre']);
		$genres = array_map('trim', $genres);
	}
	foreach ($genres as $genre) {
		$genre = urlencode($genre);
		if ($genre === '') {
			$genre = 'null';
		}
		$genreFolder = new folder('data/genres');
		$data = $genreFolder->scan();
		if (in_array($genre.'.yml', $data) === TRUE) {
			$genreFile = $genreFolder.'/'.$genre.'.yml';
			$content = yaml::read($genreFile);
			array_push($content['books'], $fileName);
			yaml::write($genreFolder.'/'.$genre.'.yml', $content);
		} else {
			$genreNew = array(
				'genre' => urldecode($genre),
				'books' => array($fileName)
			);
			yaml::write($genreFolder.'/'.$genre.'.yml', $genreNew);
		}
	}

	// remove book from publisher index

	$publisherFile = 'data/publishers/'.urlencode($publisher).'.yml';
	$content = yaml::read($publisherFile);
	$booksArray = $content['books'];
	$key = array_search($fileName, $booksArray);
	unset($booksArray[$key]);
	array_values($booksArray);
	$publisherNew = array(
		'publisher' => urldecode($publisher),
		'books' => $booksArray
	);
	yaml::write($publisherFile, $publisherNew);
	$content = yaml::read($publisherFile);
	$booksArray = $content['books'];
	if (empty($booksArray)) {
		f::remove($publisherFile);
	}

	// write to publisher index

	$publisher = urlencode($_POST['publisher']);
	if ($publisher === '') {
		$publisher = 'null';
	}
	$publisherFolder = new folder('data/publishers');
	$data = $publisherFolder->scan();
	if (in_array($publisher.'.yml', $data) === TRUE) {
		$publisherFile = $publisherFolder.'/'.$publisher.'.yml';
		$content = yaml::read($publisherFile);
		array_push($content['books'], $fileName);
		yaml::write($publisherFolder.'/'.$publisher.'.yml', $content);
	} else {
		$publisherNew = array(
			'publisher' => urldecode($publisher),
			'books' => array($fileName)
		);
		yaml::write($publisherFolder.'/'.$publisher.'.yml', $publisherNew);
	}

	// remove file from year index

	$yearFile = 'data/years/'.urlencode($year).'.yml';
	$content = yaml::read($yearFile);
	$booksArray = $content['books'];
	$key = array_search($fileName, $booksArray);
	unset($booksArray[$key]);
	array_values($booksArray);
	$yearNew = array(
		'year' => urldecode($year),
		'books' => $booksArray
	);
	yaml::write($yearFile, $yearNew);
	$content = yaml::read($yearFile);
	$booksArray = $content['books'];
	if (empty($booksArray)) {
		f::remove($yearFile);
	}

	// write to year index

	$year = urlencode($_POST['year']);
	if ($year === '') {
		$year = 'null';
	}
	$yearFolder = new folder('data/years');
	$data = $yearFolder->scan();
	if (in_array($year.'.yml', $data) === TRUE) {
		$yearFile = $yearFolder.'/'.$year.'.yml';
		$content = yaml::read($yearFile);
		array_push($content['books'], $fileName);
		yaml::write($yearFolder.'/'.$year.'.yml', $content);
	} else {
		$yearNew = array(
			'year' => urldecode($year),
			'books' => array($fileName)
		);
		yaml::write($yearFolder.'/'.$year.'.yml', $yearNew);
	}

	/*
	Handle ebook changes.

	A couple of scenarios here:
	1. 	if ebook was previously checked and now it is unchecked:
	=> 	should delete the associated folder in data/ebooks with all
	ebook files present
	2. if ebook was previously unchecked and now it is checked
	=> 	standart "add new item" process, create associated folder in
	data/ebooks and upload all files attached to the form
	3. if ebook remains checked and delete associated files is also checked
	=>	delete all files from associated folder in data/ebooks
	a) if there are no new files to be uploaded => end
	b) if there are new files to be uploaded => upload new files to
	the same associated folder in data/ebooks
	4. if ebook remains checked and delete associated files is not checked
	=>	keep associated ebook folder in data/ebooks intact
	a) if there are new files to be uploaded => upload new files to
	the same associated folder in data/ebooks
	*/

	if (isset($_POST['ifEbook'])) {
		$type = 'ebook';
		$ebooksFolder = new folder('data/ebooks');
		$ebookFiles = $ebooksFolder->scan();
		if(!in_array($fileName, $ebookFiles)) {
			$ebookFolder = 'data/ebooks/'.$fileName;
			mkdir($ebookFolder);
		}
		if (isset($_POST['deleteFiles'])) {
			$ebookFolder = new folder('data/ebooks/'.$fileName);
			$ebookFiles = $ebookFolder->scan();
			var_dump($ebookFiles);
			foreach ($ebookFiles as $ebookFile) {
				f::remove($ebookFolder.'/'.$ebookFile);
			}
		}
		// file upload
		if (isset($_FILES['bookfile'])) {
			$ebookFolder = new folder('data/ebooks/'.$fileName);
			require_once('upload/class.file.php');
			require_once('upload/class.upload.php');
			$validations = array(
				'category' => array('ebook'), // validate only those files within this list
				'size' => 200 // maximum of 20mb
			);

			// create new instance
			$upload = new Upload($_FILES['bookfile'], $validations);

			// for each file
			foreach ($upload->files as $file) {
				if ($file->validate()) {
					// do your thing on this file ...
					// ...
					// say we don't allow audio files
					if ($file->is('audio')) $error = 'Audio not allowed';
					else {
						// then get base64 encoded string to do something else ...
						$filedata = $file->get_base64();

						// or get the GPS info ...
						$gps = $file->get_exif_gps();

						// then we move it to 'path/to/my/uploads'
						$result = $file->put('./'.$ebookFolder);
						$error = $result ? '' : 'Error moving file';
					}

				} else {
					// oopps!
					$error = $file->get_error();
				}
				$filename = $file->name;
				// echo $file->name.' - '.($error ? ' [FAILED] '.$error : ' Succeeded!');
				// echo '<br />';
			}
		}
		// end file upload
	} else {
		$type = 'book';
		$ebooksFolder = new folder('data/ebooks');
		$ebookFiles = $ebooksFolder->scan();
		if(in_array($fileName, $ebookFiles)) {
			$ebookFolder = new folder('data/ebooks/'.$fileName);
			$ebookFiles = $ebookFolder->scan();
			foreach ($ebookFiles as $ebookFile) {
				f::remove($ebookFile);
			}
			$ebookFolder->remove($keep = FALSE);
		}
	}

	// write location to .loc file (if not present)
	$locationData = urlencode($_POST['location']);
	$locationsFolder = new folder('data/locations');
	$locationsList = (array)$locationsFolder->files();
	$locations = array();
	foreach  ($locationsList['data'] as $location) {
		$fileName = urldecode($location->filename());
		$locationName = substr($fileName, 0, -4);
		$locations[] = $locationName;
	}
	if (!in_array($locationData, $locations)) {
		f::write($locationsFolder.'/'.$locationData.'.loc', ' ', $append = false);
	}

	// write modifications to the main book file

	if($_POST['author'] === '') {
		$authors = array('null');
	} else {
		$_POST['author'] = rtrim($_POST['author'], '; ') . '';
		$authors = explode(';', $_POST['author']);
		$authors = array_map('trim', $authors);
	}
	if($_POST['genre'] === '') {
		$genres = array('null');
	} else {
		$_POST['genre'] = rtrim($_POST['genre'], '; ') . '';
		$genres = explode(';', $_POST['genre']);
		$genres = array_map('trim', $genres);
	}

	if($_POST['publisher'] === '') {
		$_POST['publisher'] = 'null';
	}
	if($_POST['year'] === '') {
		$_POST['year'] = 'null';
	}

	$bookNew = array(
		'id' => $fileId,
		'title' => $_POST['title'],
		'author' => $authors,
		'isbn' => $_POST['isbn'],
		'publisher' => $_POST['publisher'],
		'year' => $_POST['year'],
		'genres' => $genres,
		'cover' => $_POST['cover'],
		'description' => $_POST['description'],
		'type' => $type,
		'location' => $_POST['location']
	);
	$fileName = str_pad($fileId, 6, '0', STR_PAD_LEFT);

	yaml::write('data/books/'.$fileName.'.yml', $bookNew);

	return $fileId;
}

/*.............................................................................
EDIT AN ITEM OF THE COLLECTION ................................................
USED IN edit.php TO FETCH BOOK DATA AND PASS IT TO THE EDIT ITEM FORM .........
.............................................................................*/

function bookEdit($id) {
	require_once('application/snippets/autocomplete/author.php');
	require_once('application/snippets/autocomplete/genre.php');
	require_once('application/snippets/autocomplete/publisher.php');
	require_once('application/snippets/autocomplete/location.php');
	$fileId = $id;
	$fileName = str_pad($fileId, 6, '0', STR_PAD_LEFT);
	$book = 'data/books/'.$fileName.'.yml';
	$bookData = yaml::read($book);
	$author = implode('; ', $bookData['author']);
	$title = $bookData['title'];
	$isbn = $bookData['isbn'];
	$publisher = $bookData['publisher'];
	$year = $bookData['year'];
	$genres = implode('; ', $bookData['genres']);
	$cover = $bookData['cover'];
	$description = $bookData['description'];
	$type = $bookData['type'];
	$location = $bookData['location'];
	echo '<h3>Edit item</h3>';
	echo '<form method="post" action="save.php" enctype="multipart/form-data">';
	echo '<input type="hidden" value="'.$fileName.'" name="filename" />';
	echo '<input type="hidden" value="'.$id.'" name="id" />';
	echo '<div class="form-group">';
	echo '<label for="author">Author <span>(separate multiple authors by semicolon)</span></label>';
	echo '<input class="form-control" type="text" name="author" id="author_input" value="';
	if ($author === 'null') {
		echo '';
	} else {
		echo $author;
	}
	echo '" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="title">Title</label>';
	echo '<input class="form-control" type="text" name="title" id="title" value="'.$title.'" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="isbn">ISBN Number</label>';
	echo '<input class="form-control" type="text" name="isbn" id="isbn" value="'.$isbn.'" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="publisher">Publisher</label>';
	echo '<input class="form-control" type="text" name="publisher" id="publisher_input" value="';
	if ($publisher === 'null') {
		echo '';
	} else {
		echo $publisher;
	}
	echo '" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="year">Year Published</label>';
	echo '<input class="form-control" type="text" name="year" id="year" value="';
	if ($year === 'null') {
		echo '';
	} else {
		echo $year;
	}
	echo '" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="genre">Genre <span>(separate multiple genre labels by semicolon)</span></label>';
	echo '<input class="form-control" type="text" name="genre" id="genre_input" value="';
	if ($genres === 'null') {
		echo '';
	} else {
		echo $genres;
	}
	echo '" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="cover">Cover Image</label>';
	echo '<input class="form-control" type="text" name="cover" id="cover" value="'.$cover.'" />';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="description">Description <span>(accepts Markdown)</span></label>';
	echo '<textarea class="form-control" name="description" id="description">'.$description.'</textarea>';
	echo '</div>';
	echo '<label for="alert">Is item an ebook?</label>';
	echo '<div class="alert alert-secondary" role="alert">';
	echo '<div class="form-check">';
	echo '<label class="form-check-label">';
	$ifChecked = '';
	if ($type === 'ebook') {
		$ifChecked = 'checked';
	}
	echo '<input class="form-check-input" type="checkbox" name="ifEbook" value="" '.$ifChecked.' >';
	echo 'This item is an ebook';
	echo '</label>';
	echo '</div>';
	if ($bookData['type'] === 'ebook') {
		$ebookFolder = new folder('data/ebooks/'.$fileName);
		$ebookFiles = $ebookFolder->scan();
		if (!empty($ebookFiles)) {
			echo '<p>The following ebook files are associated with the item:</p>';
			echo '<ul>';
			foreach ($ebookFiles as $ebookFile) {
				echo '<li>'.$ebookFile.'</li>';
			}
			echo '</ul>';
			echo '<p>Check the below box if you want to remove associated items. New additions will not overwrite previously uploaded items.</p>';
			echo '<div class="form-check">';
			echo '<label class="form-check-label">';
			echo '<input class="form-check-input" type="checkbox" name="deleteFiles" value="" >';
			echo 'Remove associated ebook files';
			echo '</label>';
			echo '</div>';
		}
	}
	echo '<div class="form-group">';
	echo '<div class="col-12 pl-0">';
	echo '<label for="file" class="indented"><span>Upload an ebook file (<abbr id="fileTypes" data-toggle="tooltip" data-placement="right" title=".cbr, .cbz, .cb7, .cbt, .cba, .djvu, .doc, .docx, .epub, .fb2, .html, .ibook, .inf, .azw, .lit, .prc, .mobi, .pkg, .pdb, .txt, .pdf, .ps, .tr2, .tr3, .oxps, .xps, .zip, .gzip, .7z, .tar, .rar, .rtf, .md, .mdown, .markdown">Allowed file types</abbr>)</span></label>';
	echo '</div>';
	echo '<label class="custom-file">';
	echo '<input type="file" id="file" name="bookfile" class="custom-file-input">';
	echo '<span class="custom-file-control"></span>';
	echo '</label>';
	echo '</div>';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<label for="location">Location</label>';
	echo '<input class="form-control" type="text" name="location" id="location_input" value="'.$location.'"/>';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<input class="btn btn-primary" type="submit" name="submitEditBook" value="Save modifications" />';
	echo '<input type="button" class="btn btn-secondary cancel" name="submitEdit" value="Cancel modifications" onClick="parent.location=\'book.php?id='.$id.'\'" />';
	echo '</div>';
	echo '</form>';
}

/*.............................................................................
DELETE AN ITEM FROM THE COLLECTION ............................................
USED IN delete.php TO DELETE AN ITEM FROM THE COLLECTION ......................
.............................................................................*/

function bookDelete($id) {
	$fileId = $id;
	$fileName = str_pad($fileId, 6, '0', STR_PAD_LEFT);
	$book = 'data/books/'.$fileName.'.yml';
	$bookData = yaml::read($book);
	$authors = $bookData['author'];
	$author = implode('; ', $bookData['author']);
	$title = $bookData['title'];
	$year = $bookData['year'];
	$genres = $bookData['genres'];
	$publisher = $bookData['publisher'];
	if (isset($_POST['deleteConfirm'])) {
		// delete book id from data/authors/[author].yml
		foreach ($authors as $author) {
			$authorFile = 'data/authors/'.urlencode($author).'.yml';
			$content = yaml::read($authorFile);
			$booksArray = $content['books'];
			$key = array_search($fileName, $booksArray);
			unset($booksArray[$key]);
			array_values($booksArray);
			$authorNew = array(
				'author' => urldecode($author),
				'books' => $booksArray
			);
			yaml::write($authorFile, $authorNew);
			$content = yaml::read($authorFile);
			$booksArray = $content['books'];
			if (empty($booksArray)) {
				f::remove($authorFile);
			}
		}

		// delete book id from data/genres/[genre].yml
		foreach ($genres as $genre) {
			$genreFile = 'data/genres/'.urlencode($genre).'.yml';
			$content = yaml::read($genreFile);
			$booksArray = $content['books'];
			$key = array_search($fileName, $booksArray);
			unset($booksArray[$key]);
			array_values($booksArray);
			$genreNew = array(
				'genre' => urldecode($genre),
				'books' => $booksArray
			);
			yaml::write($genreFile, $genreNew);
			$content = yaml::read($genreFile);
			$booksArray = $content['books'];
			if (empty($booksArray)) {
				f::remove($genreFile);
			}
		}

		// delete book id from data/years/[year].yml
		$yearFile = 'data/years/'.urlencode($year).'.yml';
		$content = yaml::read($yearFile);
		$booksArray = $content['books'];
		$key = array_search($fileName, $booksArray);
		unset($booksArray[$key]);
		array_values($booksArray);
		$yearNew = array(
			'year' => urldecode($year),
			'books' => $booksArray
		);
		yaml::write($yearFile, $yearNew);
		$content = yaml::read($yearFile);
		$booksArray = $content['books'];
		if (empty($booksArray)) {
			f::remove($yearFile);
		}


		// delete book id from data/publishers/[publisher].yml
		$publisherFile = 'data/publishers/'.urlencode($publisher).'.yml';
		$content = yaml::read($publisherFile);
		$booksArray = $content['books'];
		$key = array_search($fileName, $booksArray);
		unset($booksArray[$key]);
		array_values($booksArray);
		$publisherNew = array(
			'publisher' => urldecode($publisher),
			'books' => $booksArray
		);
		yaml::write($publisherFile, $publisherNew);
		$content = yaml::read($publisherFile);
		$booksArray = $content['books'];
		if (empty($booksArray)) {
			f::remove($publisherFile);
		}

		// if ebook: delete associated ebook files and folder
		if ($bookData['type'] === 'ebook') {
			$ebookFolder = new folder('data/ebooks/'.$fileName);
			$ebookFolder->remove($keep = FALSE);
		}

		// delete book from data/lendings
		f::remove('data/lendings/'.$fileName.'.yml');

		// remove main bookfile
		f::remove('data/books/'.$fileName.'.yml');
		header::redirect('index.php');
		exit;
	} else {
		echo '<div class="alert alert-danger" role="alert">';
		echo '<h5 class="alert-heading">Warning!</h5>';
		echo '<p>You are about to <strong>delete</strong> the following item:</p>';
		if ($author === 'null') {
			$author = 'Unknown Author';
		}
		echo '<ul><li>"'.$title.'" by '.$author.'</li></ul>';
		if ($bookData['type'] === 'ebook') {
			$ebookFolder = new folder('data/ebooks/'.$fileName);
			$ebookFiles = $ebookFolder->scan();
			if (!empty($ebookFiles)) {
				echo '<p>The following ebook files associated with the item will also be deleted:</p>';
				echo '<ul>';
				foreach ($ebookFiles as $ebookFile) {
					echo '<li>'.$ebookFile.'</li>';
				}
				echo '</ul>';
			}
		}
		echo '<p class="mb-0">This action <strong>cannot be undone</strong>, so think twice before clicking the red button. Are you sure?</p>';
		echo '</div>';
		echo '<form class="form-inline bookAction" method="post" action="book.php?id='.$id.'">';
		echo '<input type="submit" class="btn btn-primary" name="cancelDeletion" value="Cancel deletion" />';
		echo '</form>';
		echo '<form class="form-inline bookAction" method="post" action="">';
		echo '<input type="hidden" name="id" value="' . $id . '" />';
		echo '<input type="submit" class="btn btn-danger" name="deleteConfirm" value="Yes, delete this item" />';
		echo '</form>';
	}
}

/*.............................................................................
DISPLAY ALL ITEMS IN THE COLLECTION ...........................................
USED IN index.php TO DISPLAY THE WHOLE COLLECTION .............................
.............................................................................*/

function readCollection() {

	$folder = new folder('data/books');
	$url = $_SERVER['REQUEST_URI'];
	$page = parse_url($url, PHP_URL_QUERY);
	$pageNumber = urldecode(str_replace('page=', '', $page));
	if ($pageNumber === '' || $pageNumber === '0') {
		$offset = 0;
	} else {
		$offset = intval($pageNumber) * 20;
	}
	$dataCollection = $folder->files();
	$ifData = $folder->scan();
	$data = $dataCollection->offset($offset)->limit(20);
	$totalPages = count($dataCollection) / 20;
	include_once('application/snippets/tablehead.php');
	if (empty($ifData)) {
		echo '<tr><td class="align-middle" colspan="6">You have no items in your collection.</td></tr>';
	} else {
		foreach($data as $book) {
			$bookData = yaml::read($book);
			include('application/snippets/displayCollection.php');
		}
	}
	echo '</tbody>';
	echo '</table>';
	if ((intval($pageNumber) < $totalPages - 1)) {
		$nextPage = '?page=' . strval((int)$pageNumber + 1);
		echo '<a href="index.php'.$nextPage.'" class="btn btn-secondary nextPage">Next page &raquo;</a>';
	}
	if ((intval($pageNumber) > 0)) {
		$prevPage = '?page=' . strval((int)$pageNumber - 1);
		if ($prevPage === '?page=0') {
			$prevPage = '';
		}
		echo '<a href="index.php'.$prevPage.'" class="btn btn-secondary prevPage">&laquo; Previous page</a>';
	}
}

/*.............................................................................
DISPLAY A SINGLE ITEM FROM THE COLLECTION .....................................
USED IN book.php TO DISPLAY THE SELECTED ITEM .................................
.............................................................................*/

function displayBook() {
	require_once('parsedown/Parsedown.php');
	$Parsedown = new Parsedown();
	$url = $_SERVER['REQUEST_URI'];
	$id = str_replace('id=', '', parse_url($url, PHP_URL_QUERY));
	$folder = new folder('data/books');
	$fileName = str_pad($id, 6, '0', STR_PAD_LEFT).'.yml';
	$book = f::read($folder.'/'.$fileName);
	$bookData = yaml::read($book);
	if ($bookData['type'] === 'ebook') {
		$ifEbook = ' (Ebook)';
	} else {
		$ifEbook = '';
	}
	// title
	echo '<h3>' . $bookData['title'] . $ifEbook . '</h3>';
	$ifLent = 0;
	$lentFolder = new folder('data/lendings');
	$lentItems = $lentFolder->scan();
	if (in_array($fileName, $lentItems)) {
		$lentInfo = yaml::read($lentFolder.'/'.$fileName);
		echo '<div class="alert alert-warning" role="alert">';
		echo '<p class="mb-0">This book was lent to <strong>' .$lentInfo['lent to']. '</strong> on <strong>' .$lentInfo['lent at']. '</strong>.</p>';
		echo '</div>';
		$ifLent = 1;
	}
	// ending col-12
	echo '</div>';

	// left column
	echo '<div class="col-md-8">';
	echo '<div class="card">';
	// authors
	echo '<div class="card-header">Author</div>';
	echo '<ul class="list-group list-group-flush">';
	if (($bookData['author'][0] !== 'null')) {
		foreach ($bookData['author'] as $author) {
			if($author !== '') {
				echo '<li class="list-group-item"><a href="view.php?author=' . urlencode($author) .'">' . $author . '</a></li>';
			}
		}
	} else {
		echo '<li class="list-group-item">No authorship information.</li>';
	}
	echo '</ul>';
	//ISBN
	echo '<div class="card-header">ISBN</div>';
	echo '<ul class="list-group list-group-flush">';
	if (!empty($bookData['isbn'])) {
		echo '<li class="list-group-item">' . $bookData['isbn'] . '</li>';
	} else {
		echo '<li class="list-group-item">No ISBN information.</li>';
	}
	echo '</ul>';
	// publisher
	echo '<div class="card-header">Publisher</div>';
	echo '<ul class="list-group list-group-flush">';
	if ($bookData['publisher'] !== 'null') {
		echo '<li class="list-group-item"><a href="view.php?publisher=' . urlencode($bookData['publisher']) .'">' . $bookData['publisher'] . '</a></li>';
	} else {
		echo '<li class="list-group-item">No publisher information.</li>';
	}
	echo '</ul>';
	// year published
	echo '<div class="card-header">Year published</div>';
	echo '<ul class="list-group list-group-flush">';
	if ($bookData['year'] !== 'null') {
		echo '<li class="list-group-item"><a href="view.php?year=' . urlencode($bookData['year']) .'">' . $bookData['year'] . '</a></li>';
	} else {
		echo '<li class="list-group-item">No publication year added.</li>';
	}
	echo '</ul>';
	// genres
	echo '<div class="card-header">Genre</div>';
	echo '<ul class="list-group list-group-flush">';
	if ($bookData['genres'][0] !== 'null') {
		foreach ($bookData['genres'] as $genre) {
			if($genre !== '') {
				echo '<li class="list-group-item"><a href="view.php?genre=' . urlencode($genre) .'">' . $genre . '</a></li>';
			}
		}
	} else {
		echo '<li class="list-group-item">No genre tags added.</li>';
	}
	echo '</ul>';
	// description
	echo '<div class="card-header">Description</div>';
	echo '<ul class="list-group list-group-flush">';
	if (!empty($bookData['description'])) {
		echo '<li class="list-group-item">' . $Parsedown->text($bookData['description']) . '</li>';
	} else {
		echo '<li class="list-group-item">No description provided.</li>';
	}
	echo '</ul>';

	// ebook file (if any)
	if ($bookData['type'] === 'ebook') {
		$folderName = str_pad($id, 6, '0', STR_PAD_LEFT);
		$ebookFolder = new folder('data/ebooks/'.$folderName);
		$ebookFile = $ebookFolder->scan();
		echo '<div class="card-header">Ebook files</div>';
		echo '<ul class="list-group list-group-flush"><li class="list-group-item">';
		if(!empty($ebookFile)) {
			foreach ($ebookFile as $file) {
				echo '<a href="'.$ebookFolder.'/'.$file.'" class="btn btn-light download">' . $file . '</a>';
			}
		} else {
			echo 'No ebook file available.';
		}
		echo '</li></ul>';
	}
	echo '</div>';
	echo '</div>';
	echo '<div class="row mobileOnly"><p>&nbsp;</p></div>';
	// right column
	echo '<div class="col-md-4">';
	echo '<div class="card narrow">';
	echo '<div class="card-header">Cover image</div>';
	if (!empty($bookData['cover'])) {
		echo '<img class="card-img-top" src="' . $bookData['cover'] . '" />';
	} else {
		echo '<ul class="list-group list-group-flush"><li class="list-group-item">No cover linked.</li></ul>';
	}
	echo '<div class="card-header">Location</div>';
	echo '<ul class="list-group list-group-flush">';
	if (!empty($bookData['location'])) {
		echo '<li class="list-group-item">' . $bookData['location'] . '</li>';
	} else {
		echo '<li class="list-group-item">No location provided.</li>';
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';
	echo '<div class="col-md-12">';
	echo '<form class="form-inline bookAction" method="post" action="edit.php">';
	echo '<input type="hidden" name="id" value="' . $id . '" />';
	echo '<input type="submit" class="btn btn-primary" name="submitEdit" value="Edit item" />';
	echo '</form>';
	if ($ifLent == 0) {
		echo '<form class="form-inline bookAction" method="post" action="lend.php">';
		echo '<input type="hidden" name="id" value="' . $id . '" />';
		echo '<input type="submit" class="btn btn-secondary" name="submitLending" value="Lend this item" />';
		echo '</form>';
	} else if ($ifLent == 1) {
		echo '<form class="form-inline bookAction" method="post" action="lend.php">';
		echo '<input type="hidden" name="id" value="' . $id . '" />';
		echo '<input type="submit" class="btn btn-secondary" name="takeBack" value="Take this item back from lending" />';
		echo '</form>';
	}
	echo '<form class="form-inline bookAction" method="post" action="delete.php">';
	echo '<input type="hidden" name="id" value="' . $id . '" />';
	echo '<input type="submit" class="btn btn-danger" name="submitDelete" value="Delete item" />';
	echo '</form>';
	echo '</div>';
}

/*.............................................................................
LEND AN ITEM ..................................................................
USED IN lend.php TO SAVE LENDING DATA FOR AN ITEM .............................
.............................................................................*/

function lendBook($id) {
	$fileName = str_pad($id, 6, '0', STR_PAD_LEFT);
	if (isset($_POST['submitLending'])) {
		echo '<h3>Lend this item</h3>';
		$book = 'data/books/'.$fileName.'.yml';
		$bookData = yaml::read($book);
		$authors = implode('; ', $bookData['author']);
		echo '<div class="alert alert-warning" role="alert">';
		echo '<p>You are about to lend the following book:</p>';
		echo '<ul><li>'. $bookData['title'] . ' by ' . $authors . '</li></ul>';
		echo '<p class="mb-0">Please specify the details below.</p>';
		echo '</div>';
		echo '<div class="row mb-0"></div>';
		echo '<form method="post" action="">';
		echo '<input type="hidden" class="form-control" id="id" name="id" value="'.$id.'" />';
		echo '<input type="hidden" class="form-control" id="fileName" name="fileName" value="'.$fileName.'" />';
		echo '<div class="form-group">';
		echo '<label for="lentTo">Book will be lent to</label>';
		echo '<input type="text" class="form-control" id="lentTo" name="lentTo" />';
		echo '</div>';
		echo '<div class="form-group">';
		echo '<label for="lentAt">Book will be lent on <span>(leave blank for today)<span></label>';
		echo '<input type="date" class="form-control" id="lentAt" name="lentAt" />';
		echo '</div>';
		echo '<div class="form-group">';
		echo '<input type="submit" class="btn btn-primary" name="confirmLending" value="Lend this item" />';
		echo '<input type="button" class="btn btn-secondary cancel" name="cancelLending" value="Cancel lending" onClick="parent.location=\'book.php?id='.$id.'\'" />';
		echo '</div>';
		echo '</form>';
	}
	if (isset($_POST['confirmLending'])) {
		$fileName = $_POST['fileName'];
		$lentTo = $_POST['lentTo'];
		$lentAt = $_POST['lentAt'];
		$id = $_POST['id'];
		if ($lentAt === '') {
			$lentAt = date('Y-m-d');
		}
		$lentInfo = array(
			'bookfile' => $fileName,
			'lent to' => $lentTo,
			'lent at' => $lentAt
		);
		yaml::write('data/lendings/'.$fileName.'.yml', $lentInfo);
		header::redirect('book.php?id='.$id);
		exit;
	}
	if (isset($_POST['takeBack']) || isset($_POST['takeBackLentitems'])) {
		$id = $_POST['id'];
		f::remove('data/lendings/'.$fileName.'.yml');
		if (isset($_POST['takeBack'])) {
			header::redirect('book.php?id='.$id);
			exit;
		} else if (isset($_POST['takeBackLentitems'])) {
			header::redirect('lent.php');
			exit;
		}
	}
}

/*.............................................................................
DISPLAY ALL LENT ITEMS ........................................................
USED IN lent.php TO LIST ALL LENT ITEMS .......................................
.............................................................................*/

function displayLent() {
	$lentFolder = new folder('data/lendings');
	$lentItems = $lentFolder->files();
	$checkEmpty = (array)$lentItems;
	echo '<table class="table table-striped table-bordered">';
	echo '<thead>';
	echo '<tr>';
	echo '<th scope="col" class="desktopOnly">ID</th>';
	echo '<th scope="col">Author</th>';
	echo '<th scope="col">Title</th>';
	echo '<th scope="col" class="desktopOnly">Lent to</th>';
	echo '<th scope="col" class="desktopOnly">Lent on</th>';
	echo '<th scope="col" class="desktopOnly">Take back</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	if (!empty($checkEmpty['data'])) {
		foreach ($lentItems as $lentItem) {
			$lentContent = yaml::read($lentItem);
			$lentTo = $lentContent['lent to'];
			$lentAt = $lentContent['lent at'];
			$id = ltrim($lentContent['bookfile'], '0');
			$bookData = yaml::read('data/books/'.$lentContent['bookfile'].'.yml');
			echo '<tr>';
			echo '<td class="align-middle desktopOnly">'.$bookData['id'].'</td>';
			echo '<td class="align-middle">';
			if ($bookData['author'][0] === 'null') {
				echo '';
			} else {
				foreach ($bookData['author'] as $author) {
					echo '<a href="view.php?author=' . urlencode($author) .'">' . $author . '</a><br />';
				}
			}
			echo '</td>';
			echo '<td class="align-middle"><a href="book.php?id=' . $bookData['id'] . '">' . $bookData['title'] . '</a></td>';
			echo '<td class="align-middle desktopOnly">'.$lentTo.'</td>';
			echo '<td class="align-middle desktopOnly">'.$lentAt.'</td>';
			echo '<td class="align-middle desktopOnly">';
			echo '<form class="form-inline noMargin" method="post" action="lend.php">';
			echo '<input type="hidden" name="id" value="' . $id . '" />';
			echo '<input type="submit" class="btn btn-secondary" name="takeBackLentitems" value="Take back" />';
			echo '</form>';
			echo '</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr><td class="align-middle" colspan="6">You have no lent items.</td></tr>';
	}
	echo '</tbody>';
	echo '</table>';
	$i = count($lentItems);
	if ($i == 0) { } else {
		if ($i == 1) { $wording = ' record';} else {$wording = ' records';}
		echo '<p>' . $i . ' ' . $wording . ' found.</p>';
	}
}

/*.............................................................................
DISPLAY ALL GENRES IN THE COLLECTION ..........................................
USED IN genres.php TO LIST ALL GENRES .........................................
.............................................................................*/

function displayGenres() {
	echo '<div class="card">';
	echo '<ul class="list-group list-group-flush">';
	$folder = new folder('data/genres');
	$data = $folder->scan();
	$array = array();
	foreach ($data as $file) {
		$file = urldecode($file);
		$file = substr($file, 0, -4);
		$array[] = $file;
	}
	sort($array);
	foreach ($array as $item) {
		echo '<li class="list-group-item"><a href="view.php?genre=' . urlencode($item) .'">';
		if ($item === 'null') {
			echo 'No genre';
		} else {
			echo $item;
		}
		echo '</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	$records = count($array);
	echo '<p class="recordsNum">' . $records . ' records found.</p>';
}

/*.............................................................................
DISPLAY BOOKS IN SELECTED GENRE ...............................................
USED IN view.php?genre= TO LIST ALL ITEMS IN SELECTED GENRE ...................
.............................................................................*/

function displayGenre($needle) {
	if ($needle === 'null') {
		echo '<h3>Books without genre information</h3>';
	} else {
		echo '<h3>' . ucfirst($needle) . ' books</h3>';
	}
	include_once('application/snippets/tablehead.php');
	$file = urlencode($needle).'.yml';
	$folder = new folder('data/genres');
	if (file_exists($folder.'/'.$file)) {
		$content = yaml::read($folder.'/'.$file);
		$books = $content['books'];
		foreach ($books as $book) {
			$file = $book.'.yml';
			$folder = new folder('data/books');
			$bookData = yaml::read($folder.'/'.$file);
			include('application/snippets/displayCollection.php');
		}
		echo '</tbody>';
		echo '</table>';
		$i = count($books);
		if ($i == 1) { $wording = ' record';} else {$wording = ' records';}
		echo '<p>' . $i . $wording . ' found.</p>';
	} else {
		echo '<tr><td class="align-middle" colspan="6">No results.</td></tr>';
	}
}

/*.............................................................................
DISPLAY ALL PUBLISHERS IN THE COLLECTION ......................................
USED IN publishers.php TO LIST ALL PUBLISHERS .................................
.............................................................................*/

function displayPublishers() {
	echo '<div class="card">';
	echo '<ul class="list-group list-group-flush">';
	$folder = new folder('data/publishers');
	$data = $folder->scan();
	$array = array();
	foreach ($data as $file) {
		$file = urldecode($file);
		$file = substr($file, 0, -4);
		$array[] = $file;
	}
	sort($array);
	foreach ($array as $item) {
		echo '<li class="list-group-item"><a href="view.php?publisher=' . urlencode($item) .'">';
		if ($item === 'null') {
			echo 'No publisher';
		} else {
			echo $item;
		}
		echo '</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	$records = count($array);
	echo '<p class="recordsNum">' . $records . ' records found.</p>';
}

/*.............................................................................
DISPLAY BOOKS BY SELECTED PUBLISHER ...........................................
USED IN view.php?publisher= TO LIST ALL ITEMS BY SELECTED PUBLISHER ...........
.............................................................................*/

function displayPublisher($needle) {
	if ($needle === 'null') {
		echo '<h3>Books without publisher information</h3>';
	} else {
		echo '<h3>Books published by ' .$needle . '</h3>';
	}
	include_once('application/snippets/tablehead.php');
	$file = urlencode($needle).'.yml';
	$folder = new folder('data/publishers');
	if (file_exists($folder.'/'.$file)) {
		$content = yaml::read($folder.'/'.$file);
		$books = $content['books'];
		foreach ($books as $book) {
			$file = $book.'.yml';
			$folder = new folder('data/books');
			$bookData = yaml::read($folder.'/'.$file);
			include('application/snippets/displayCollection.php');
		}
		echo '</tbody>';
		echo '</table>';
		$i = count($books);
		if ($i == 1) { $wording = ' record';} else {$wording = ' records';}
		echo '<p>' . $i . $wording . ' found.</p>';
	} else {
		echo '<tr><td class="align-middle" colspan="6">No results.</td></tr>';
	}
}

/*.............................................................................
DISPLAY ALL AUTHORS IN THE COLLECTION .........................................
USED IN authors.php TO LIST ALL AUTHORS .......................................
.............................................................................*/

function displayAuthors() {
	echo '<div class="card">';
	echo '<ul class="list-group list-group-flush">';
	$folder = new folder('data/authors');
	$data = $folder->scan();
	$array = array();
	foreach ($data as $file) {
		$file = urldecode($file);
		$file = substr($file, 0, -4);
		$array[] = $file;
	}
	sort($array);
	foreach ($array as $item) {
		echo '<li class="list-group-item"><a href="view.php?author=' . urlencode($item) .'">';
		if ($item === 'null') {
			echo 'No author information';
		} else {
			echo $item;
		}
		echo '</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	$records = count($array);
	echo '<p class="recordsNum">' . $records . ' records found.</p>';
}

/*.............................................................................
DISPLAY BOOKS BY SELECTED AUTHOR ..............................................
USED IN view.php?author= TO LIST ALL ITEMS BY SELECTED AUTHOR .................
.............................................................................*/

function displayAuthor($needle) {
	if ($needle === 'null') {
		echo '<h3>Books without authorship information</h3>';
	} else {
		echo '<h3>Books written by ' . ucfirst($needle) . '</h3>';
	}
	include_once('application/snippets/tablehead.php');
	$file = urlencode($needle).'.yml';
	$folder = new folder('data/authors');
	if (file_exists($folder.'/'.$file)) {
		$content = yaml::read($folder.'/'.$file);
		$books = $content['books'];
		foreach ($books as $book) {
			$file = $book.'.yml';
			$folder = new folder('data/books');
			$bookData = yaml::read($folder.'/'.$file);
			include('application/snippets/displayCollection.php');
		}
		echo '</tbody>';
		echo '</table>';
		$i = count($books);
		if ($i == 1) { $wording = ' record';} else {$wording = ' records';}
		echo '<p>' . $i . $wording . ' found.</p>';
	} else {
		echo '<tr><td class="align-middle" colspan="6">No results.</td></tr>';
	}
}

/*.............................................................................
DISPLAY ALL PUBLISHING YEARS IN THE COLLECTION ................................
USED IN years.php TO LIST ALL PUBLISHING YEARS ................................
.............................................................................*/

function displayYears() {
	echo '<div class="card">';
	echo '<ul class="list-group list-group-flush">';
	$folder = new folder('data/years');
	$data = $folder->scan();
	$array = array();
	foreach ($data as $file) {
		$file = urldecode($file);
		$file = substr($file, 0, -4);
		$array[] = $file;
	}
	sort($array);
	foreach ($array as $item) {
		echo '<li class="list-group-item"><a href="view.php?year=' . urlencode($item) .'">';
		if ($item === 'null') {
			echo 'No publication year';
		} else {
			echo $item;
		}
		echo '</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	$records = count($array);
	echo '<p class="recordsNum">' . $records . ' records found.</p>';
}

/*.............................................................................
DISPLAY BOOKS PUBLISHED IN SELECTED YEAR ......................................
USED IN view.php?year= TO LIST ALL ITEMS PUBLISHED IN SELECTED YEAR ...........
.............................................................................*/

function displayYear($needle) {
	if ($needle === 'null') {
		echo '<h3>Books without year of publication</h3>';
	} else {
		echo '<h3>Books published in ' .$needle . '</h3>';
	}
	include_once('application/snippets/tablehead.php');
	$file = urlencode($needle).'.yml';
	$folder = new folder('data/years');
	if (file_exists($folder.'/'.$file)) {
		$content = yaml::read($folder.'/'.$file);
		$books = $content['books'];
		foreach ($books as $book) {
			$file = $book.'.yml';
			$folder = new folder('data/books');
			$bookData = yaml::read($folder.'/'.$file);
			include('application/snippets/displayCollection.php');
		}
		echo '</tbody>';
		echo '</table>';
		$i = count($books);
		if ($i == 1) { $wording = ' record';} else {$wording = ' records';}
		echo '<p>' . $i . $wording . ' found.</p>';
	} else {
		echo '<tr><td class="align-middle" colspan="6">No results.</td></tr>';
	}
}

/*.............................................................................
SEARCH ITEMS IN THE COLLECTION ................................................
USED IN search.php TO PERFORM A SEARCH BASED ON A needle IN THE haystack ......
.............................................................................*/

function searchCollection($needle, $haystack) {
	if ($haystack === 'author') {
		$bookArray = array();
		$needle = urlencode($needle);
		$authorFolder = new folder('data/authors');
		$authorFiles = $authorFolder->scan();
		foreach ($authorFiles as $authorFile) {
			$authorFile = strtolower($authorFile);
			if (strpos($authorFile, $needle) !== FALSE) {
				$match = yaml::read($authorFolder.'/'.$authorFile);
				foreach ($match['books'] as $matchBook) {
					if (in_array($matchBook, $bookArray)) {
						continue;
					} else {
						$bookArray[] = $matchBook;
					}
				}
			}
		}
	} else if ($haystack === 'genres') {
		$bookArray = array();
		$needle = urlencode($needle);
		$genreFolder = new folder('data/genres');
		$genreFiles = $genreFolder->scan();
		foreach ($genreFiles as $genreFile) {
			$genreFile = strtolower($genreFile);
			if (strpos($genreFile, $needle) !== FALSE) {
				$match = yaml::read($genreFolder.'/'.$genreFile);
				foreach ($match['books'] as $matchBook) {
					if (in_array($matchBook, $bookArray)) {
						continue;
					} else {
						$bookArray[] = $matchBook;
					}
				}
			}
		}
	} else if ($haystack === 'publisher') {
		$bookArray = array();
		$needle = urlencode($needle);
		$publisherFolder = new folder('data/publishers');
		$publisherFiles = $publisherFolder->scan();
		foreach ($publisherFiles as $publisherFile) {
			$publisherFile = strtolower($publisherFile);
			if (strpos($publisherFile, $needle) !== FALSE) {
				$match = yaml::read($publisherFolder.'/'.$publisherFile);
				foreach ($match['books'] as $matchBook) {
					if (in_array($matchBook, $bookArray)) {
						continue;
					} else {
						$bookArray[] = $matchBook;
					}
				}
			}
		}
	} else if ($haystack === 'year') {
		$bookArray = array();
		$needle = urlencode($needle);
		$yearFolder = new folder('data/years');
		$yearFiles = $yearFolder->scan();
		foreach ($yearFiles as $yearFile) {
			$yearFile = strtolower($yearFile);
			if (strpos($yearFile, $needle) !== FALSE) {
				$match = yaml::read($yearFolder.'/'.$yearFile);
				foreach ($match['books'] as $matchBook) {
					if (in_array($matchBook, $bookArray)) {
						continue;
					} else {
						$bookArray[] = $matchBook;
					}
				}
			}
		}
	} else if ($haystack === 'all') {
		$bookArray = array();
		$folder = new folder('data/books');
		$data = $folder->scan();
		foreach ($data as $book) {
			$bookData = yaml::read($folder.'/'.$book);
			$field = strtolower(var_export($bookData, TRUE));
			if (strpos($field, $needle) !== FALSE) {
				$bookId = substr($book, 0, -4);
				if (in_array($book, $bookArray)) {
					continue;
				} else {
					$bookArray[] = $bookId;
				}
			} else {
				continue;
			}
		}
	} else {
		$bookArray = array();
		$folder = new folder('data/books');
		$data = $folder->scan();
		foreach ($data as $book) {
			$bookData = yaml::read($folder.'/'.$book);
			$field = strtolower($bookData[$haystack]);
			if (strpos($field, $needle) !== FALSE) {
				$bookId = substr($book, 0, -4);
				if (in_array($book, $bookArray)) {
					continue;
				} else {
					$bookArray[] = $bookId;
				}
			} else {
				continue;
			}
		}
	}
	include_once('application/snippets/tablehead.php');
	$resultsNum = count($bookArray);
	if ($resultsNum == 0) {
		echo '<tr><td class="align-middle" colspan="6">No results.</td></tr>';
		echo '</tbody>';
		echo '</table>';
	} else {
		$folder = new folder('data/books');
		foreach ($bookArray as $book) {
			$bookData = yaml::read($folder.'/'.$book.'.yml');
			include('application/snippets/displayCollection.php');
		}
		echo '</tbody>';
		echo '</table>';
		if ($resultsNum == 1) {
			$wording = 'result';
		} else {
			$wording = 'results';
		}
		echo $resultsNum .' '. $wording.'.';
	}
}

/*.............................................................................
DISPLAY ALL EBOOKS IN THE COLLECTION ..........................................
USED IN ebooks.php TO LIST ALL EBOOKS IN THE COLLECTION .......................
.............................................................................*/

function displayEbooks() {
	echo '<table class="table table-striped table-bordered">';
	echo '<thead>';
	echo '<tr>';
	echo '<th scope="col" class="desktopOnly">ID</th>';
	echo '<th scope="col">Author</th>';
	echo '<th scope="col">Title</th>';
	echo '<th scope="col" class="desktopOnly">Genre</th>';
	echo '<th scope="col" class="desktopOnly">Files</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$ebookFolder = new folder('data/ebooks');
	$books = new folder('data/books');
	$ebookFiles = $ebookFolder->scan();
	if(!empty($ebookFiles)) {
		foreach ($ebookFiles as $ebookFile) {
			$bookData = yaml::read($books.'/'.$ebookFile.'.yml');
			echo '<tr>';
			echo '<td class="align-middle desktopOnly ">' . $bookData['id'] . '</td>';
			echo '<td class="align-middle">';
			if ($bookData['author'][0] === 'null') {
				echo '';
			} else {
				foreach ($bookData['author'] as $author) {
					echo '<a href="view.php?author=' . urlencode($author) .'">' . $author . '</a><br />';
				}
			}
			echo '</td>';
			echo '<td class="align-middle"><a href="book.php?id=' . $bookData['id'] . '">' . $bookData['title'] . '</a></td>';
			echo '<td class="align-middle desktopOnly">';
			if ($bookData['genres'][0] === 'null') {
				echo ' ';
			} else {
				foreach ($bookData['genres'] as $genre) {
					echo '<a href="view.php?genre=' . urlencode($genre) .'">' . $genre . '</a><br />';
				}
			}
			echo '</td>';
			echo '<td class="align-middle desktopOnly">';
			$relatedEbooks = new folder('data/ebooks/'.$ebookFile);
			$relatedFiles = $relatedEbooks->scan();
			if (!empty($relatedFiles)) {
				foreach ($relatedFiles as $relatedFile) {
					echo '<a href="'.$relatedEbooks.'/'.$relatedFile.'">' . $relatedFile . '</a><br />';
				}
			} else {
				echo 'No ebook file available.';
			}
			echo '</td>';

			echo '</tr>';



		}
		echo '</tbody>';
		echo '</table>';
		$i = count($ebookFiles);
		if ($i == 1) { $wording = ' record';} else {$wording = ' records';}
		echo '<p>' . $i . $wording . ' found.</p>';
	} else {
		echo '<tr><td class="align-middle" colspan="6">No results.</td></tr>';
	}
}

/*.............................................................................
MODIFY USER PROFILE ...........................................................
USED IN user.php MODIFY USER DATA SAVED TO config/config.yml ..................
.............................................................................*/

function userModify() {
	$userData = yaml::read('application/config/config.yml');
	$apikey = $userData['apikey'];
	$nicename = $userData['nicename'];
	if ($_POST['nicename'] !== '') {
		$nicenameNew = $_POST['nicename'];
	} else {
		$nicenameNew = $userData['nicename'];
	}
	if ($_POST['passwordNew'] !== '') {
		if(!password::match($_POST['password'], $userData['password'])) {
			echo '<div class="alert alert-danger" role="alert">
			<p class="mb-0">The current password you entered is incorrect.</p>
			</div>';
		} else {
			if ($_POST['passwordNew'] !== $_POST['passwordNewConfirm']) {
				echo '<div class="alert alert-danger" role="alert">
				<p class="mb-0">New password and new password confirmation must match.</p>
				</div>';
			} else {
				$passwordNew = password::hash($_POST['passwordNew']);
			}
		}
	} else {
		$passwordNew = $userData['password'];
	}
	if ($_POST['apikeyNew'] !== '') {
		$apikeyNew = $_POST['apikeyNew'];
	} else {
		$apikeyNew = $userData['apikey'];
	}

	yaml::write('application/config/config.yml', array(
		'username' => $userData['username'],
		'password' => $passwordNew,
		'apikey' => $apikeyNew,
		'nicename' => $nicenameNew
	));

	echo '<div class="alert alert-success" role="alert">
	<p class="mb-0">Your modifications were successfully saved.</p>
	</div>';
	header("Refresh: 1;url=");
	exit;
}

/*.............................................................................
PICK A RANDOM BOOK FROM THE COLLECTION ........................................
USED IN random.php TO PICK RANDOM READ FOR THE USER ...........................
.............................................................................*/

function randomBook() {
	$random = NULL;
	$books = new folder('data/books');
	$countItems = count($books->scan());
	$random = rand(1, $countItems);
	header::redirect('book.php?id='.$random);
	exit;
}

?>
