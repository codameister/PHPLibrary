<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Check Book Out</title>
</head>
<body>
<?php
	if (isset($_GET['borrower'])) {

		$bookid = trim($_GET['bookid']);
		$borrower = trim($_GET['borrower']);
		$borrower2 = $borrower;

    if (!$borrower) {
      printf ("You must specify a valid borrower");
      printf ("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $bookid = addslashes($bookid);
    $borrower = addslashes($borrower);

    try {
		$db = new mysqli('andrew-peters.co.uk.mysql', 'andrew_peters_co_uk', 'FCaWTFyH', 'andrew_peters_co_uk');
		}
		catch (mysqli_sql_exception $e) {
		  printf("Unable to open database: %s\n", $e->getMessage());
		  printf ("<br><a href=index.php>Return to home page </a>");
    }
	
	$stmt1 = $db->prepare("select * from Borrowers where borrowerid = ?");
	$stmt1->bind_param('d', $borrower);
	$stmt1->bind_result($col1, $col2, $col3);
	$stmt1->execute();
	$stmt1->fetch();
	$borrowercount = $col1;
	$stmt1->close();
	
	if ($borrowercount > 0){

		date_default_timezone_set("Europe/London");
		$due = time() + 7 * 24 * 60 * 60;
		$due = date("Y-m-d", $due);
		$stmt2 = $db->prepare("update Books set onloan=1, duedate=?, borrowerid=? where bookid=?");
		$stmt2->bind_param('sdd', $due, $borrower2, $bookid);
		$stmt2->execute();
		printf ("<br>Book Checked Out!");
		printf ("<br><a href=index.php>Return to home page </a>");
		exit;
	}
	else
	{	
		printf("Borrow ID not found, please try again");
		printf("<br><a href=checkout.php>go back</a>");
		exit;
	}
  }

?>

<h3>Specify Borrower</h3>
<hr>
<form action="checkout.php" method="GET">
      Enter borrower ID:
      <INPUT type="text" name="borrower">
      <?php
      $bookid = trim($_GET['bookid']);
      echo '<INPUT type="hidden" name="bookid" value=' . $bookid . '>';
      ?>
      <INPUT type="submit" name="submit" value="Continue">
</form>
</body>
