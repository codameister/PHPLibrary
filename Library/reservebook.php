<?php
  	if(session_status()!=PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
		<head>
			<title>Book Reservation Confirmation</title>
		</head>
	<body>
<?php
   $booktoreserve = urldecode($_GET['reservation']);

    if (!isset($_SESSION['reservedbooklist2']))
      $reservedbooklist = array();
	else
      $reservedbooklist = json_decode($_SESSION['reservedbooklist2']);
  
	foreach ($reservedbooklist as $book)
			if ($book == $booktoreserve){
				echo "book is already in the basket";
				exit;
			}
   array_push($reservedbooklist, $booktoreserve);
   $_SESSION['reservedbooklist2'] = json_encode($reservedbooklist);
   
   
   echo "Thankyou.  $booktoreserve has been added to your reservation list";
   echo "<br><a href=index.php>Return to home page</a>";
?>
</body>
</html>
