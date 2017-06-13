<?php

  $colours = array("Pink"=>"f0d0d0", "Violet"=>"cda8ef", "Blue"=>"a8c1ef", "Green"=>"a8efab", "Yellow"=>"efee7b"); 

	if (isset($_GET['colourchosen'])) {
		$temp = $_GET['colourchosen'];
		$temp2 = $colours[$temp];
		
    setcookie("colourpreference", $temp2, time()+24*3600, "/");
	}
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Choose Colour Preference</title>
</head>
<body>
<?php
  if (isset($_GET['colourchosen'])) {
    echo "Your colour preference has been recorded";
    echo "<br> <a href=index.php>Return to home page</a>";
    exit;
  }

?>
<form action="colour-chooser.php" method="GET">
<table>
  <tbody>
    <tr>
      <td>Choose your search background colour preference:</td>
      <td>
        <select size="1" name="colourchosen">
          <?php
          foreach ($colours as $name => $hex)
            printf('<option value="' . $name . '">' . $name . '</option>');
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan = "2">
        <INPUT type="submit" name="Confirm" value="Confirm Preference"></td>
      <td></td>
    </tr>
  </tbody>
</table>
</form>
</body>
</html>
