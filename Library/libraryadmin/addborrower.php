<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>Add New Borrower</title>
  
</head>
<body>
<?php
  if (isset($_POST['newborrowername'])) {

    $newborrowername = trim($_POST['newborrowername']);
    $newborroweraddress = trim($_POST['newborroweraddress']);

    if (!$newborrowername || !$newborroweraddress) {
      printf ("You must specify both a name and an address");
      printf ("<br><a href=index.php>Return to home page </a>");
      exit();
    }

    $newborrowername = addslashes($newborrowername);
    $newborroweraddress = addslashes($newborroweraddress);

    try {
	$db = new mysqli('andrew-peters.co.uk.mysql', 'andrew_peters_co_uk', 'FCaWTFyH', 'andrew_peters_co_uk');
      #$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
      catch (mysqli_sql_exception $e) {
      printf("Unable to open database: %s\n", $e->getMessage());
      printf ("<br><a href=index.php>Return to home page </a>");
    }

    $stmt = $db->prepare("insert into Borrowers values (DEFAULT, ?, ?)");
	$stmt->bind_param('ss', $newborrowername, $newborroweraddress); 
	$stmt->execute();
    printf ("<br>Borrower Added!");
    printf ("<br><a href=index.php>Return to home page </a>");
    exit;
  }

?>

<h3>Add a new borrower</h3>
<hr>
You must enter both a name and an address
<form action="addborrower.php" method="POST">
<table bgcolor="#bdc0ff" cellpadding="6">
  <tbody>
    <tr>
      <td>Name:</td>
      <td><INPUT type="text" name="newborrowername"></td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><INPUT type="text" name="newborroweraddress"></td>
    </tr>
    <tr>
      <td></td>
      <td><INPUT type="submit" name="submit" value="Add Borrower"></td>
    </tr>
  </tbody>
</table>
</form>
</body>
