<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Add New Book</title>
</head>
<body>
<?php
  if (isset($_POST['newbooktitle'])) {

    $newbooktitle = trim($_POST['newbooktitle']);
    $newbookauthor = trim($_POST['newbookauthor']);

    if (!$newbooktitle || !$newbookauthor) {
      printf ("You must specify both a title and an author");
      printf ("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $newbooktitle = addslashes($newbooktitle);
    $newbookauthor = addslashes($newbookauthor);

    try {
	$db = new mysqli('andrew-peters.co.uk.mysql', 'andrew_peters_co_uk', 'FCaWTFyH', 'andrew_peters_co_uk');
      #$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (mysqli_sql_exception $e) {
      printf("Unable to open database: %s\n", $e->getMessage());
      printf ("<br><a href=index.php>Return to home page </a>");
    }

    $stmt = $db->prepare("insert into Books values (DEFAULT, ?, ?, false, DEFAULT, DEFAULT)");
    $stmt->bind_param('ss', $newbooktitle, $newbookauthor); 
	$stmt->execute();
    printf ("<br>Book Added!");
    printf ("<br><a href=index.php>Return to home page </a>");
    exit;
  }

?>

<h3>Add a new book</h3>
<hr>
You must enter both a title and an author
<form action="addbook.php" method="POST">
<table bgcolor="#bdc0ff" cellpadding="6">
  <tbody>
    <tr>
      <td>Title:</td>
      <td><INPUT type="text" name="newbooktitle"></td>
    </tr>
    <tr>
      <td>Author:</td>
      <td><INPUT type="text" name="newbookauthor"></td>
    </tr>
    <tr>
      <td></td>
      <td><INPUT type="submit" name="submit" value="Add Book"></td>
    </tr>
  </tbody>
</table>
</form>
</body>
