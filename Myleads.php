<!doctype.html>
<html>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">


<?php include("Header.php"); ?>
<?php include("Common.php"); ?>

<body>
<?php include("Navigator.php"); ?>
<?php include("LeftNavigator.php"); ?>

<div class="content" align="center" >

<?php

session_start();

if(!isset($_SESSION['username']))
{
	// not logged in
	header('Location: Login.php');
	exit();
}

// Accessing session data
$userid=$_SESSION["userid"];

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

$sql = "SELECT Initiative_Name, Initiative_Number from initiatives 
			where Lead_ID1 = $userid or Lead_ID2 = $userid or Lead_ID3 = $userid 
			and Initiative_Status<>'Cancelled'";

$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));
$count = mysqli_num_rows($result);

if ($count == 0) {
	echo "<br><br>Take your first initiative!";
} else {
	echo "<TABLE class=\"silentservanttable\" BORDER=\"solid\" BGCOLOR=\"black\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" >";
	echo "<THEAD BGCOLOR=\"lightgrey\"> <TH>Initiative</TH><TH>Action</TH> </THEAD>";
	echo "<TBODY BGCOLOR=\"white\">";

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo "<tr>";
		echo "<td>".$row['Initiative_Name']."</td>";
		echo "<td><a href=\"EditContributions.php?ini_num=".$row['Initiative_Number']."\">Edit</a></td>";
		echo "</tr>";
	}

	echo "</TBODY>";
	echo "</TABLE>";
}

?>

</div>

</body>
</html>
