<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Check Book In</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
    $bookid = trim($_GET['bookid']);

    $bookid = addslashes($bookid);

    try {
	$db = new mysqli('andrew-peters.co.uk.mysql', 'andrew_peters_co_uk', 'FCaWTFyH', 'andrew_peters_co_uk');
    }
    catch (mysqli_sql_exception $e) {
      printf("Unable to open database: %s\n", $e->getMessage());
      printf ("<br><a href=index.php>Return to home page </a>");
    }

    $stmt = $db->prepare("update Books set onloan=0, duedate=null, borrowerid=null where bookid = ?");
	$stmt->bind_param('d', $bookid); 
    $stmt->execute();
    printf ("<br>Book Checked In!");
    printf ("<br><a href=index.php>Return to home page </a>");
    exit;
?>
</body>
</html>

