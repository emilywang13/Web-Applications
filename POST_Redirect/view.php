<?php
require_once "pdo.php";
session_start();
//check if user is logged in
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}


$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
</head>
<body>


<table border="1">
<?php
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
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

<a href="add.php" style="text-decoration: none"; color: #00FFFF;>Add New</a> |
<a href="logout.php" style="text-decoration: none"; color: #00FFFF;>Logout</a>
</div>

</body>
</html>
