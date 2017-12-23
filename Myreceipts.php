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

<?php

session_start();

if(!isset($_SESSION['username']))
{
	// not logged in
	header('Location: Login.php');
	exit();
}

// Accessing session data
$id=$_SESSION["username"];

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

$sql = "SELECT A.userid, B.Initiative_Number, C.Initiative_Name, B.Sponsorship_Total from useraccess A, contributions B, initiatives C 
			where A.username = '$id' and A.userid = B.silentservant_ID and B.Initiative_Number = C.Initiative_Number 
			and Sponsorship_Total<>0 and C.Initiative_Status<>'Cancelled'";

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
	echo "<td><a href=\"Receipts.php?userid=".$row[userid]."&prop_id=".$row['Initiative_Number']."\">Click </a></td>";
	echo "</tr>";
}

?>

</TBODY>
<CAPTION ALIGN="BOTTOM" STYLE="font-size=10px;">
</CAPTION>

</TABLE>

</div>

</body>
</html>
