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
$id=$_SESSION["userid"];

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

$sql = "SELECT A.Initiative_Number, B.Initiative_Name, A.Sponsorship_Total from contributions A, initiatives B 
			where A.silentservant_ID = $id and A.Initiative_Number = B.Initiative_Number 
			and Sponsorship_Total<>0 and B.Initiative_Status<>'Cancelled'";

$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));

?>

<TABLE class="silentservanttable" BORDER="solid" BGCOLOR="black" cellpadding="1" cellspacing="1" align="center" >

<THEAD BGCOLOR="lightgrey">
<TH>Initiative</TH><TH>Contribution</TH><TH>Receipt</TH>
</THEAD>

<TBODY BGCOLOR="white">

<?php

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row['Initiative_Name']."</td>";
	echo "<td>".$row['Sponsorship_Total']."</td>";
	echo "<td><a href=\"Receipts.php?prop_id=".$row['Initiative_Number']."\">Click </a></td>";
	echo "</tr>";
}

?>

</TBODY>

</TABLE>

</div>

</body>
</html>
