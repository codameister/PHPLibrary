<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Administrative Book Search</title>
</head>
<body>
<h3>Book Search Results</h3>
<hr>
<?php


$searchtitle = trim($_POST['searchtitle']);
$searchauthor = trim($_POST['searchauthor']);

if (!$searchtitle && !$searchauthor) {
  printf ("You must specify either a title or an author");
  exit();
}

$searchtitle = addslashes($searchtitle);
$searchauthor = addslashes($searchauthor);

try {
	$db = new mysqli('andrew-peters.co.uk.mysql', 'andrew_peters_co_uk', 'FCaWTFyH', 'andrew_peters_co_uk');
}

  catch (mysqli_sql_exception $e) {
      printf("Unable to open database: %s\n", $e->getMessage());
      printf ("<br><a href=index.php>Return to home page </a>");
    }


$query = "select * from Books";
if ($searchtitle && !$searchauthor) { 
  $query = $query . " where title like '%" . $searchtitle . "%'"; 
}
if (!$searchtitle && $searchauthor) { 
  $query = $query . " where author like '%" . $searchauthor . "%'";
}
if ($searchtitle && $searchauthor) { 
  $query = $query . " where title like '%" . $searchtitle . "%' and author like '%" . $searchauthor . "%'"; 
}


try {
  $sth = $db->query($query);
  $bookcount = $sth->num_rows; 
  if ($bookcount == 0) {
    printf("Sorry, we did not find any matching books");
    printf("<br> <a href=index.php>Back to home page</a>");
    exit;
  }

  printf('<table bgcolor="%s" cellpadding="6">', "#dddddd");
  printf('<tr><b><td>Title</td> <td>Author</td> <td>Check Out</td> <td> Check In </td></b> </tr>');
  while ($row = $sth->fetch_assoc()){
    $checkoutanchor = "-";
    $checkinanchor  = "-";
    if (! $row["onloan"])
      $checkoutanchor = '<a href="checkout.php?bookid=' . urlencode($row["bookid"]) . '">Check Out</a>';
    else
      $checkinanchor  = '<a href="checkin.php?bookid=' . urlencode($row["bookid"]) . '">Check In</a>';
    printf("<tr> <td> %s </td> <td> %s </td> <td> %s </td> <td> %s </td> </tr>",
           htmlentities($row["title"]),
           htmlentities($row["author"]),
           $checkoutanchor,
           $checkinanchor);
  }
}
catch (mysqli_sql_exception $e) {
      printf("We had a problem: %s\n", $e->getMessage());
    }

printf("</table>");
printf("<br> We found %s matching books", $bookcount);
printf("<br> <a href=index.php>Back to home page</a>");
?>
</body>
</html>
