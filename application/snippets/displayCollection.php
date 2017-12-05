<?php
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
if ($bookData['publisher'] === 'null') {
	echo '';
} else {
	echo '<a href="view.php?publisher=' . urlencode($bookData['publisher']) .'">' . $bookData['publisher'] . '</a>';
}
echo '</td>';
echo '<td class="align-middle desktopOnly">';
if ($bookData['year'] === 'null') {
	echo '';
} else {
	echo '<a href="view.php?year=' . urlencode($bookData['year']) .'">' . $bookData['year'] . '</a>';
}
echo '</td>';
echo '<td class="align-middle desktopOnly">';
if ($bookData['genres'][0] === 'null') {
	echo ' ';
} else {
	foreach ($bookData['genres'] as $genre) {
		echo '<a href="view.php?genre=' . urlencode($genre) .'">' . $genre . '</a><br />';
	}
}
echo '</td>';
echo '</tr>';
?>
