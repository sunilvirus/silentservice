<!doctype.html>
<html>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">


<?php include("Header.php"); ?>
<?php include("Common.php"); ?>

<body>
<?php include("Navigator.php"); ?>


<div class="navleft" >
<ul >
<li ><a href="Silentservants.php" >Donations</a></li>
<li > <a href="Initiatives.php">Initiatives</a></li>
<li > <a href="Myreceipts.php">My Receipts</a></li>

</ul>

</div>

<div class="content" align="center" >

<br>
<a href="javascript:history.back()">Back</a>
<br>
<br>

<?php

session_start();

if(!isset($_SESSION['username']))
{
	// not logged in
	header('Location: Login.php');
	exit();
}

$id=$_SESSION["username"];
$userid=$_GET['userid'];
$prop_id=$_GET['prop_id'];

$filename="images/".$userid.$prop_id.".jpg" ;
$filename1="images/".$prop_id.".pdf" ;
$filename2="images/".$prop_id.".jpg" ;

if (file_exists($filename))
{
	echo "<img src='".$filename."' width=680 height=380 >";
}
else if (file_exists($filename1))
{
	echo "<iframe src='".$filename1."' width=\"100%\" style=\"height:100%\"></iframe>";
}
else if (file_exists($filename2))
{
	echo "<img src='".$filename2."' width=680 height=380 >";
}
else
{
	echo "<p align=center ><br /><br /><br /><br /><br /><br /><br /><br /><br />Receipt not available</p>";
}

?>

</div>
</body>
</html>
