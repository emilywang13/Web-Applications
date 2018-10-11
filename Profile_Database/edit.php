<?php
require_once "pdo.php";
session_start();

if (isset ($_SESSION['name'])==false)
  die('Not logged in');


  if ( isset($_POST['first_name']) && isset($_POST['last_name'])
       && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {

      // Data validation
      if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?profile_id=".$_POST["profile_id"]);
        return;
      }

      if (strpos($_POST['email'], "@")=== FALSE){
        $_SESSION['error'] = "Email address must contain @";
        header("Location: edit.php?profile_id=".$_POST["profile_id"]);
        return;
      }



    $sql = "UPDATE Profile SET first_name = :first_name,
    last_name = :last_name, email = :email, headline = :headline, summary = :summary
    WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record Updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that profile_id is present

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$f = htmlentities($row['first_name']);
$l = htmlentities($row['last_name']);
$e = htmlentities($row['email']);
$h = htmlentities($row['headline']);
$s = htmlentities($row['summary']);
$pid = $row['profile_id'];
?>

<h1>Editing Profile</h1>
<form method="post">
<p>First Name:
<input type="text" name="first_name" value="<?= $f ?>"></p>
<p>Last Name:
<input type="text" name="last_name" value="<?= $l ?>"></p>
<p>Email:
<input type="text" name="email" value="<?= $e ?>"></p>
<p>Headline:
<input type="text" name="headline" value="<?= $h ?>"></p>
<p>Summary:
<input type="text" name="summary" value="<?= $s ?>"></p>
<input type="hidden" name="profile_id" value="<?= $pid ?>">

<p><input type="submit" value="Save"/>
  <input class="button" type="button" onclick="window.location.replace('index.php')" value="Cancel"/>
</p>
</form>
