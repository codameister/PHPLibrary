<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Check Book Out</title>
</head>
<body>
<?php
  if (isset($_GET['borrower'])) {

    $bookid = trim($_GET['bookid']);      // From the hidden field
    $borrower = trim($_GET['borrower']);  // Entered by the user

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

    date_default_timezone_set("Europe/London");
    $due = time() + 7 * 24 * 60 * 60;  // Book due back two weeks from now
    $due = date("Y-m-d", $due);
    $stmt = $db->prepare("update Books set onloan=1, duedate=?, borrowerid=? where bookid=?");
	$stmt->bind_param('sdd', $due, $borrower, $bookid); 
	$stmt->execute();
    printf ("<br>Book Checked Out!");
    printf ("<br><a href=index.php>Return to home page </a>");
    exit;
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
