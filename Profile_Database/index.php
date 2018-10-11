<?php
require_once "pdo.php";
session_start();
?>
<html>
<head></head><body>
<h1>Emily Wang's Registry</h1>
<?php

if (isset($_SESSION['name']) == false) {
  $_SESSION['user_id'] = false;
  echo '<a href="login.php">Please log in</a>';
  //if user is not logged in, show user names/headlines
  $stmt = $pdo->query("SELECT user_id, profile_id, first_name, last_name, headline FROM Profile");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

else if (isset($_SESSION['name']) == true) {
  echo '<p><a href="logout.php">Logout</a></p>';
  $stmt = $pdo->query("SELECT user_id, profile_id, first_name, last_name, headline FROM Profile");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo '<p><a href="add.php">Add New Entry</a></p>';
}

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
?>
<table border="1">
<?php
foreach ( $rows as $row ) {
    echo ("<tr><th>");
    echo("Name");
    echo("</th><th>");
    echo("Headline");
    //if user is the one who owns the entry in the database, allow it to perform updates/deletes
    if ($_SESSION['user_id'] == $row['user_id']) {
      echo("</th><th>");
      echo("Action");
      echo("</th></tr>");
      echo("<tr><td>");
      echo('<a href="view.php?profile_id='.htmlentities($row['profile_id']).'">'.htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a>");
      echo("</td><td>");
      echo(htmlentities($row['headline']));
      echo("</td><td>");
      echo('<a href="edit.php?profile_id='.htmlentities($row['profile_id']).'">'."Edit"."</a>");
      echo(" ");
      echo('<a href="delete.php?profile_id='.htmlentities($row['profile_id']).'">'."Delete"."</a>");
      echo("</td></tr>");
    }
    //else user can only view entries
    else {
      echo("</th></tr>");
      echo("<tr><td>");
      echo('<a href="view.php?profile_id='.htmlentities($row['profile_id']).'">'.htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a>");
      echo("</td><td>");
      echo(htmlentities($row['headline']));
      echo("</td></tr>");
    }
}
?>
</table>

</body>
</html>
