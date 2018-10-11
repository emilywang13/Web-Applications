<?php
require_once "pdo.php";
session_start();
?>
<html>
<head>
</head>
<body>
<?php
  $stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ( $row === false ) {
      $_SESSION['error'] = 'Bad value for profile_id';
      header( 'Location: index.php' ) ;
      return;
  }

  $f = htmlentities($row['first_name']);
  $l = htmlentities($row['last_name']);
  $e = htmlentities($row['email']);
  $h = htmlentities($row['headline']);
  $s = htmlentities($row['summary']);
  //$pid = $row['profile_id'];
?>





<h1>Profile information</h1>
<p>First Name: <?= $f ?> </p>
<p>Last Name: <?= $l ?> </p>
<p>Email: <?= $e ?> </p>
<p>Headline: <br> <?= $h ?> </p>
<p>Summary: <br> <?= $s ?> </p>



<a href="index.php" style="text-decoration: none";>Done</a> 
</div>

</body>
</html>
