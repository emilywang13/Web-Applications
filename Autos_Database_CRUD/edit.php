<?php
require_once "pdo.php";
session_start();

if (isset ($_SESSION['name'])==false)
  die('ACCESS DENIED');


if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id'])) {
    // Data validation
     if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
       $_SESSION['error'] = 'All fields are required';
       header("Location: edit.php?autos_id=".$_POST['autos_id']);
       return;
     }
     if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
       $_SESSION['error'] = 'Year and Mileage must be numeric';
       header("Location: edit.php?autos_id=".$_POST['autos_id']);
       return;
     }
    $sql = "UPDATE autos SET make = :make,
    model = :model, year = :year, mileage = :mileage
    WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that autos_id is present

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$aid = $row['autos_id'];
?>
<p>Edit Automobile</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $ma ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $mo ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mi ?>"></p>
<input type="hidden" name="autos_id" value="<?= $aid ?>">
<p><input type="submit" value="Update"/>
<a href="index.php">Cancel</a></p>
</form>
