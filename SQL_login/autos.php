<?php
require_once "pdo.php";

// p' OR '1' = '1

if ( isset($_GET['name'])  === FALSE) {
    die("Name parameter missing");

}

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
	if (strlen($_POST['make']) < 1)
		echo("<p>Make is required.</p>\n");
	else if (is_numeric($_POST['year']===FALSE || !is_numeric($_POST['mileage']===FALSE)))
		echo("<p>Mileage and year must be numeric.</p>\n");
	else {
		$sql = "INSERT INTO autos (make, year, mileage) 
              VALUES (:mk, :yr, :mi)";
    	$stmt = $pdo->prepare($sql);
    	$stmt->execute(array(
        	':mk' => $_POST['make'],
        	':yr' => $_POST['year'],
        	':mi' => $_POST['mileage']));

		//print successful added message
    	echo ('<span style="color:green;text-align:center;">Record inserted</span>');
    }
}

$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<p><input type="submit" value="Add"/></p>
</form>

<table border="1">
<?php
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td></tr>\n");
}
?>
</table>

</body>