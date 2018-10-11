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
      header("Location: add.php");
      return;
    }

    if (strpos($_POST['email'], "@")=== FALSE){
      $_SESSION['error'] = "Email address must contain @";
      header("Location: add.php");
      return;
    }

    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

?>
<h1>Adding Profile</h1>
<form method="post">
<p>First Name:
<input type="text" name="first_name"></p>
<p>Last Name:
<input type="text" name="last_name"></p>
<p>Email:
<input type="text" name="email"></p>
<p>Headline:
<input type="text" name="headline"></p>
<p>Summary:
<textarea name="summary" rows="8" cols="80"></textarea></p>
<p><input type="submit" value="Add"/>
  <input class="button" type="button" onclick="window.location.replace('index.php')" value="Cancel"/>
</p>
</form>
