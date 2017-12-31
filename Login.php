<!doctype.html>

<html>   
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<?php include("Header.php"); ?>
<?php include("Common.php"); ?>

<body>
<?php include("Navigator.php"); ?>

<div class = "container form-signin">

<?php

// Remove all session variables (which has username)
$_SESSION = array();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	// username and password sent from form 

	$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

	$myusername = mysqli_real_escape_string($db,$_POST['username']);
	$mypassword = mysqli_real_escape_string($db,$_POST['password']); 

	$sql = "SELECT userid FROM useraccess WHERE username = '$myusername' and password = '$mypassword'";
	$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));;
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count == 1) {
		$_SESSION['username'] = mysqli_real_escape_string($db,$_POST['username']);
		$_SESSION['userid'] = $row['userid'];

		echo "Valid user logged in";
		header("location: Silentservants.php");
	} else {
		$error = "Your Login Name or Password is invalid";
		echo $error;
	}
}

?>
</div> <!-- /container -->

<div class="login-block">

<form class = "form-signin" role = "form" 
action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
?>" method = "post">
<h1><br><br>Login</h1>
<input type="text" class = "form-control"  value="" placeholder="Username" id="username" name="username" />
<input type="password"  class = "form-control"  value="" placeholder="Password" id="password" name="password" />
<button class = "btn btn-lg btn-primary btn-block" type = "submit" 
name = "login">Submit</button>

</form>

</div> 

</body>
</html>
