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

$sql = "SELECT Initiative_Name, Initiative_Number, Initiative_Status from initiatives 
			where Lead_ID1 = $userid or Lead_ID2 = $userid or Lead_ID3 = $userid";

$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));
$count = mysqli_num_rows($result);

if ($count == 0) {
	echo "<br><br>Take your first initiative!";
} else {
	echo "<TABLE class=\"silentservanttable\" BORDER=\"solid\" BGCOLOR=\"black\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" >".PHP_EOL;
	echo "<THEAD BGCOLOR=\"lightgrey\"> <TH>Initiative</TH><TH>Status</TH><TH>Action</TH> </THEAD>".PHP_EOL;
	echo "<TBODY BGCOLOR=\"white\">".PHP_EOL;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo "<tr>".PHP_EOL;
		echo "<td>".$row['Initiative_Name']."</td>".PHP_EOL;
		echo "<td>".$row['Initiative_Status']."</td>".PHP_EOL;
		if ($row['Initiative_Status'] == 'Ongoing') {
			echo "<td><a href=\"EditContributions.php?ini_num=".$row['Initiative_Number']."\">Edit</a></td>".PHP_EOL;
		}
		else {
			echo "<td><a href=\"EditContributions.php?ini_num=".$row['Initiative_Number']."\">View</a></td>".PHP_EOL;
		}
		echo "</tr>".PHP_EOL;
	}

	echo "</TBODY>".PHP_EOL;
	echo "</TABLE>".PHP_EOL;
}

?>

</div>

</body>
</html>
