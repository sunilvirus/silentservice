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

if(!isset($_SESSION['username']))
{
	// not logged in
	header('Location: Login.php');
	exit();
}

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

$sql = "select sum(B.Sponsorship_Total) Sponsorship_Total, A.username from useraccess A, contributions B 
			where A.userid = B.Silentservant_ID 
			and B.Sponsorship_Total<>0 
			group by B.Silentservant_ID 
			order by A.username ";

$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));

?>


<TABLE class="silentservanttable" BORDER="solid" BGCOLOR="black" cellpadding="1" cellspacing="1" align="center" >

<THEAD BGCOLOR="lightgrey">
<TH>Name</TH><TH>SponsorhipAmount</TH>
</THEAD>


<TBODY BGCOLOR="white">

<?php

$GrandTotal = 0;

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row['username']."</td>";
	echo "<td>".$row['Sponsorship_Total']."</td>";
	echo "</tr>";

	$GrandTotal += $row['Sponsorship_Total'];
}

echo "<tr>";
echo "<td style=\"font-weight:bold\">TOTAL</td>";
echo "<td style=\"font-weight:bold\">".$GrandTotal."</td>";
echo "</tr>";

?>

</TBODY>
<CAPTION ALIGN="BOTTOM" STYLE="font-size=10px;">
</CAPTION>


</TABLE>





</div>
</body>
</html>
