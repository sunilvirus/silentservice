<!doctype.html>
<html>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">


<?php include("Header.php"); ?>

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
 
$id=$_SESSION["username"];
$id1=$_GET['prop_id'];


   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'silenwrr_silentservice');
   define('DB_PASSWORD', 'silentservice007');
   define('DB_DATABASE', 'silenwrr_silentservice');

 $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
 $sql = "SELECT concat(userid,Initiative_Number) receipt1,Initiative_Number FROM useraccess A,silentservants B WHERE A.username = '$id' AND A.userid=B.silentservant_ID  and B.Initiative_Number='$id1'";
      
$result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$filename="/home/silenwrr/public_html/images/".$row['receipt1'].".jpg" ;
$filename1="/home/silenwrr/public_html/images/".$row['Initiative_Number'].".pdf" ;
$filename2="/home/silenwrr/public_html/images/".$row['Initiative_Number'].".jpg" ;



 


 if (file_exists($filename))
 {
echo "<img src='../images/".$row['receipt1'].".jpg ' width=680 height=380 >";

 }
  else if (file_exists($filename1))
  {

  
  echo "<iframe src=\"../images/".$row['Initiative_Number'].".pdf\" width=\"100%\" style=\"height:100%\"></iframe>";
    
  }
  else if (file_exists($filename2))
  {
echo "<img src='../images/".$row['Initiative_Number'].".jpg ' width=680 height=380 >";
  }
  else
  {
    echo "<p align=center ><br /><br /><br /><br /><br /><br /><br /><br /><br />Receipt not available</p>";
  }

  
               ?>
      

</div>
</body>
</html>