<?php
require_once "pdo.php";

session_start();
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['password']) ) {
    //unset($_SESSION['name']); //logout current user
    //if there is no email or password
    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
      $_SESSION['error'] = "Email and password are required.";
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
        if ( $check == $stored_hash ) {
            // Redirect the browser to autos.php
            error_log("Login success ".$_POST['email']);
            $_SESSION['name'] = $_POST['email'];
            header("Location: view.php");
            return;
        } else {
          $_SESSION['error'] = "Incorrect username and password";
          header("Location: login.php");
          return;
        }
    }
}
?>
<p>Please Login</p>
<form method="post">
<p>Email:
<input type="text" size="40" name="email"></p>
<p>Password:
<input type="text" size="40" name="password"></p>
<p><input type="submit" value="Login"/>
<a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
<?php
//use POST-Redirect-GET-Flash pattern so that error messages don't appear after refreshing
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
</p>
</form>
<!--The password is php123 -->
</p>
