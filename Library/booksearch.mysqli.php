<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Book Search Results</title>
</head>
<body>
<h3>Book Search Results</h3>
<hr>
<?php


$searchtitle = trim($_POST['searchtitle']);
$searchauthor = trim($_POST['searchauthor']);

if (!$searchtitle && !$searchauthor) {
  echo "You must specify either a title or an author";
  exit();
}

$searchtitle  = addslashes($searchtitle);
$searchauthor = addslashes($searchauthor);

$db = new mysqli('andrew-peters.co.uk.mysql', 'andrew_peters_co_uk', 'FCaWTFyH', 'andrew_peters_co_uk');
 if ($db->connect_error) {
	echo "could not connect: " . $db->connect_error;
	exit();
}


$query = " select * from Books";
if ($searchtitle && !$searchauthor) { // Title search only
  $query = $query . " where title like '%" . $searchtitle . "%'"; 
}
if (!$searchtitle && $searchauthor) { // Author search only
  $query = $query . " where author like '%" . $searchauthor . "%'";
}
if ($searchtitle && $searchauthor) { // Title and Author search
  $query = $query . " where title like '%" . $searchtitle . "%' and author like '%" . $searchauthor . "%'"; // unfinished
}


try {
	echo "Running the query: $query <br/>";

	 if (isset($_COOKIE['colourpreference'])) 
		$colourpreference = $_COOKIE['colourpreference'];
	 else
		$colourpreference = "#bdc0ff";


	echo "Search found the following books <br/>";
	$stmt = $db->prepare($query);
	$stmt->bind_result($bookid, $title, $author, $onloan, $duedate, $borrowerid);
	$stmt->execute();
	printf('<table bgcolor="%s" cellpadding="6">', $colourpreference);
	printf('<tr><b><td>Title</td> <td>Author</td> <td>On Loan</td> <td>Due Date</td> </b> </tr>');
	while ($stmt->fetch()) {
		
		$reserveanchor = '<a href="reservebook.php?reservation=' . urlencode($title) . '"> Reserve </a>';
		printf("<tr> <td> %s </td><td> %s </td><td> $onloan </td><td> $duedate </td><td> %s </td></tr>",
			 htmlentities($title),
			 htmlentities($author),
			 $reserveanchor);

	}
	echo "</table>";
	echo "<br> <a href=index.php>Return to home page</a>";

}

catch (mysqli_sql_exception $e) {
      printf("We had a problem: %s\n", $e->getMessage());
      printf ("<br><a href=index.php>Return to home page </a>");
    }


?>
</body>
</html>
