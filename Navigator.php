<div class="banner">
<div class="logo">
<p>SilentService</p>
</div>

<div class="navigator">

<ul>
<li><a href="index.php" >Who we are</a></li>
<li><a href="Whatisdone.php">What is done</a></li>
<li><a href="Getinvolved.php">Get involved</a></li>
<li><a href="Contactus.php">Contact us</a></li>


<?php

session_start();

if(!isset($_SESSION['username']))
{
	echo "<li><a href=\"Login.php\">Login</a> </li>" . PHP_EOL;
} else {
	echo "<li><a href=\"Logout.php\">Logout (".$_SESSION['username'].")</a> </li>" . PHP_EOL;
}

?>

</ul>

</div>

</div>
