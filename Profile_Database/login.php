<?php
require_once "pdo.php";

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);

$salt = 'XyZzy12*_';
// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['password']) ) {
    //unset($_SESSION['name']); //logout current user
    //if there is no email or password
    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
      $_SESSION['error'] = "User name and password are required.";
      header("Location: login.php");
      return;
    }
    else if (strpos($_POST['email'], "@")=== FALSE){
      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;
    }
    else {
        $check = hash('md5', $salt.$_POST['password']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users
          WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //correct user name and password
        if ( $row !== false ) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            // Redirect the browser to index.php
            header("Location: index.php");
            return;
        }
        else {
          $_SESSION['error'] = "Incorrect user and password";
          header("Location: login.php");
          return;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Emily Wang's Login Page</title>
</head>
<body>
<h1>Please Log In</h1>
<?php
//use POST-Redirect-GET-Flash pattern so that error messages don't appear after refreshing
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST" action="login.php">
<label for="id_1215">Email</label>
<input type="text" size="40" name="email" id="id_1215"><br/>
<label for="id_1723">Password</label>
<input type="password" size="40" name="password" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Login">
<a href="index.php">Cancel</a>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
</p>
<!-- Hint: The account is umsi@umich.edu. The password is php123 -->

<script>
  function doValidate() {
    console.log('Validating...');
    try {
      pw = document.getElementById('id_1723').value;
      user = document.getElementById('id_1215').value;
      console.log("Validating pw="+pw);
      console.log("Validating user="+user);
      if (pw == null || pw == "" || user == null || user == "") {
        alert("Both fields must be filled out");
        return false;
      }
      if (user.indexOf('@') == -1) {
        alert("Invalid email");
        return false;
      }
      return true;
    } catch(e) {
      return false;
    }
    return false;
  }
</script>
</body>
