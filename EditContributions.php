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

// Accessing session data
$userid=$_SESSION["userid"];
$ini_num=$_GET['ini_num'];

$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE)
		or die("Please contact Admin. Error: Could not connect to the database : ".mysqli_connect_error());

// Cross check once that legal lead is modifying content
$sql = "SELECT Initiative_Name, Initiative_Status from initiatives 
			where (Lead_ID1 = $userid or Lead_ID2 = $userid or Lead_ID3 = $userid) 
			and Initiative_Number = $ini_num";

$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));
$count = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($count == 0) {
	echo "<br><br>You are not lead for this initiative!<br><a href=\"javascript:history.back()\">Back</a>".PHP_EOL;
}
else if ($row['Initiative_Status'] != 'Ongoing') {
	// Came here only to view the table
	render_contri_table($db, $ini_num, false);
}
else if (isset($_GET['delete_ssid'])) {
	$sql = "delete from contributions where silentservant_ID = ".$_GET['delete_ssid']." and Initiative_Number = ".$ini_num;
	$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));
	echo "<br><br>Successfully deleted entry<br>".PHP_EOL;

	render_contri_table($db, $ini_num, true);
	render_add_contri_form($db, $ini_num);
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {
	$ssid = $_POST['ssid'];
	$sunits = $_POST['Sponsorships'];
	$sunitcost = $_POST['Sponsorship_Amount'];
	$stotal = $sunits * $sunitcost;
	$sdate = mysqli_real_escape_string($db,$_POST['Sponsorship_Date']);

	$sql = "select * from contributions where silentservant_ID = ".$ssid." and Initiative_Number = ".$ini_num;
	$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));
	$count = mysqli_num_rows($result);

	if ($count != 0) {
		echo "<br><br>Entry for the user already exists. Delete first and add again if you want to modify.<br>".PHP_EOL;
	}
	else {
		$sql = "insert into contributions values($ssid, $ini_num, $sunits, $sunitcost, $stotal, \"$sdate\")";
		$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));
		echo "<br><br>Successfully added entry<br>".PHP_EOL;
	}

	render_contri_table($db, $ini_num, true);
	render_add_contri_form($db, $ini_num);
}
else {
	render_contri_table($db, $ini_num, true);
	render_add_contri_form($db, $ini_num);
}

?>

</div>

</body>
</html>

<?php
function render_contri_table($db, $ini_num, $editable) {
	$sql = "select A.username, B.* from useraccess A, contributions B
				where A.userid = B.silentservant_ID
				and Initiative_Number = $ini_num";
	$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));

	echo "<TABLE class=\"silentservanttable\" BORDER=\"solid\" BGCOLOR=\"black\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" >".PHP_EOL;
	echo "<THEAD BGCOLOR=\"lightgrey\">".PHP_EOL;
	echo "<TH>User</TH>".PHP_EOL;
	echo "<TH>Sponsorships</TH>".PHP_EOL;
	echo "<TH>Sponsorship_Amount</TH>".PHP_EOL;
	echo "<TH>Sponsorship_Total</TH>".PHP_EOL;
	echo "<TH>Sponsorship_Date</TH>".PHP_EOL;
	echo "<TH>View Receipt</TH>".PHP_EOL;
	if ($editable) {
		echo "<TH>Upload Receipt</TH>".PHP_EOL;
		echo "<TH>Action</TH>".PHP_EOL;
	}
	echo "</THEAD>".PHP_EOL;
	echo "<TBODY BGCOLOR=\"white\">".PHP_EOL;

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo "<tr>";
		echo "<td>".$row['username']."</td>";
		echo "<td>".$row['Sponsorships']."</td>";
		echo "<td>".$row['Sponsorship_Amount']."</td>";
		echo "<td>".$row['Sponsorship_Total']."</td>";
		echo "<td>".$row['Sponsorship_Date']."</td>";
		echo "<td><a href=\"Receipts.php?uid=".$row['silentservant_ID']."&ini_num=".$ini_num."\">View </a></td>";
		if ($editable) {
			echo "<td><a href=\"UploadReceipt.php?uname=".$row['username']."&uid=".$row['silentservant_ID']."&ini_num=".$ini_num."\">Upload </a></td>";
			echo "<td><a href=\"EditContributions.php?ini_num=".$ini_num."&delete_ssid=".$row['silentservant_ID']."\">Delete</a></td>";
		}
		echo "</tr>".PHP_EOL;
	}

	echo "</TBODY>".PHP_EOL;
	echo "</TABLE>".PHP_EOL;

	if ($editable) {
		echo "<br><br><a href=\"UploadReceipt.php?ini_num=".$ini_num."\">Upload Common Receipt</a><br><br>";
	}
}

function render_add_contri_form($db, $ini_num) {
	$sql = "select * from useraccess";
	$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));

	echo "<br><br>Add new contribution<br><br>".PHP_EOL;
	echo "<TABLE>".PHP_EOL;
	echo "<form action =\"".htmlspecialchars($_SERVER['PHP_SELF'])."?ini_num=".$ini_num."\" method=post>";
	echo "<tr><td>User </td><td>: <select name=ssid>";
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo "<option value=".$row['userid'].">".$row['username']."</option>". PHP_EOL;
	}
	echo "</select></td>".PHP_EOL;
	echo "<tr><td>Number of sponsorships </td><td>: <input type=text name=Sponsorships></td></tr>".PHP_EOL;
	echo "<tr><td>Each sponsorship amount </td><td>: <input type=text name=Sponsorship_Amount></td></tr>".PHP_EOL;
	echo "<tr><td>Date </td><td>: <input type=date name=Sponsorship_Date placeholder=\"yyyy-mm-dd\"></td></tr>".PHP_EOL;
	echo "<tr><td><button type=submit name=Submit>Submit</button></td></tr>".PHP_EOL;
	echo "</form>";
	echo "</TABLE>".PHP_EOL;

}
?>
