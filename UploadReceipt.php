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

if (!$ini_num) {
	echo "Invalid request";
	return;
}

if (isset($_GET['uname'])) {
	$username=$_GET['uname'];
} else {
	$username='Common Recepit';
}

if (isset($_GET['uid'])) {
	$donor_id=$_GET['uid'];
}

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
else if($_SERVER["REQUEST_METHOD"] == "POST") {
	$file_loc = $_FILES['Receipt']['tmp_name'];
	$file_name = $_FILES['Receipt']['name'];
	$file_size = $_FILES['Receipt']['size'];
	$file_type = $_FILES['Receipt']['type'];
	$file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

	if ($donor_id) {
		$final_filename = "images/receipts/".$donor_id."_".$ini_num.".".$file_ext;
	}
	else {
		$final_filename = "images/receipts/".$ini_num.".".$file_ext;
	}

	if ($file_ext != 'jpg' && $file_ext != 'pdf') {
		echo "<br><br>Invalid file uploaded. It should be pdf or jpg.<br><a href=\"javascript:history.go(-2)\">Back</a>".PHP_EOL;
	}
	else {
		move_uploaded_file($file_loc, $final_filename);
		echo "<br><br>File uploaded successfully<br><a href=\"javascript:history.go(-2)\">Back</a>".PHP_EOL;
	}
}
else {
	$action_url = htmlspecialchars($_SERVER['PHP_SELF']);
	$action_url = "$action_url?ini_num=$ini_num&uname=$username";
	if ($donor_id) {
		$action_url = "$action_url&uid=$donor_id";
	}

	echo "<br><br>".PHP_EOL;
	echo "<TABLE>".PHP_EOL;
	echo "<form action =\"$action_url\" method=post enctype=\"multipart/form-data\">";
	echo "<tr><td>User </td><td>: ".$username."</td>".PHP_EOL;
	echo "<tr><td>File (pdf/jpg only)</td><td>: <input type=file name=Receipt></td></tr>".PHP_EOL;
	echo "<tr><td><button type=submit name=Submit>Upload</button></td></tr>".PHP_EOL;
	echo "</form>";
	echo "</TABLE>".PHP_EOL;
	echo "<br><br><a href=\"javascript:history.go(-1)\">Back</a>".PHP_EOL;
}

?>

</div>

</body>
</html>
