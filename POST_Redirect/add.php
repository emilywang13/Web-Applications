<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
	if (strlen($_POST['make']) < 1) {
    $_SESSION['error'] = "Make is required";
    header("Location: add.php");
    return;
  }
	else if (is_numeric($_POST['year'])=== false || is_numeric($_POST['mileage'])=== false) {
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: add.php");
    return;
  }
	else {
		$sql = "INSERT INTO autos (make, year, mileage)
              VALUES (:mk, :yr, :mi)";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute(array(
        	':mk' => $_POST['make'],
        	':yr' => $_POST['year'],
        	':mi' => $_POST['mileage']));
		//print successful added message and redirect to view.php
    $_SESSION['success'] = "Record inserted";
    header("Location: view.php");
    return;
    }
}

?>
<html>
<head></head><body>

<p>Add Car</p>
<form method="post">
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" value="Add"/>
</form>
  <form action="index.php">
    <input type="submit" value="Cancel"/>
  </form>
</p>

<?php

//use POST-Redirect-GET-Flash pattern so that error messages don't appear after refreshing
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>


</body>
