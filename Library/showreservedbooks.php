<?php 
if(session_status()!=PHP_SESSION_ACTIVE){
		session_start();
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <title>List reserved books</title>
</head>
<body>
<?php
if(session_status()!=PHP_SESSION_ACTIVE){
		session_start();
	}
  
    if (!isset($_SESSION['reservedbooklist2'])) {
      echo "You have no reserved books";
      echo "<br><a href=index.php>Return to home page</a>";
      exit;
    }
    echo "You have reserved these books: <br> <br>";
        
	$reservedbooklist = json_decode($_SESSION['reservedbooklist2']);
	#$reservedbooklist = explode("/", $_SESSION['reservedbooklist']);
    foreach($reservedbooklist as $reservedbook) {
      echo $reservedbook . "<br>";
    }
    echo "<br><a href=index.php>Return to home page</a>";
?>
</body>
</html>
