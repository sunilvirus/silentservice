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

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

$sql = "select Sponsorship_Total,username from (
select sum(Sponsorship_Total) Sponsorship_Total,username from contributions group by username order by username asc
)  A where A.Sponsorship_Total <>0";
$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));

$sql1 = "select sum(Sponsorship_Total) Total from contributions";
$result1 = mysqli_query($db,$sql1) or die("Error: ".mysqli_error($db));

?>


<TABLE class="silentservanttable" BORDER="solid" BGCOLOR="black" cellpadding="1" cellspacing="1" align="center" >

<THEAD BGCOLOR="lightgrey">
<TH>Name</TH><TH>SponsorhipAmount</TH>
</THEAD>


<TBODY BGCOLOR="white">

<?php

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row['username']."</td>";
	echo "<td>".$row['Sponsorship_Total']."</td>";

	echo "</tr>";
}

while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC))
{
	echo "<tr>";
	echo "<td style=\"font-weight:bold\">TOTAL</td>";
	echo "<td style=\"font-weight:bold\">".$row['Total']."</td>";

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
