<?php
require_once "pdo.php";

// p' OR '1' = '1

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['password']) ) {
    //if there is no email or password
    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
      echo "<p>Email and password are required.</p>\n";
    }
    else if (strpos($_POST['email'], "@")=== FALSE)
      echo "<p>Email must have an at-sign (@)</p>\n";
    else {
        $check = hash('md5', $salt.$_POST['password']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to autos.php
            error_log("Login success ".$_POST['email']);
            header("Location: autos.php?name=".urlencode($_POST['email']));            
            return;
        } else {
            echo "<h1>Incorrect username/password.</h1>\n";
            error_log("Login fail ".$_POST['email']." $check");
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
</form>
<!--The password is php123 -->
</p>

