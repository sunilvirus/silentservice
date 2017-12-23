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




    define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'silenwrr_silentservice');
   define('DB_PASSWORD', 'silentservice007');
   define('DB_DATABASE', 'silenwrr_silentservice');
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   
     
  

           
      $sql = "select A.Initiative_Name,A.Initiative_Details,A.Initiative_Category,A.Contributions from (select B.Initiative_Name Initiative_Name,B.Initiative_Details Initiative_Details,B.Initiative_Category Initiative_Category,A.Contributions Contributions from (select Initiative_Name,Initiative_Category,Initiative_Details,Initiative_Number from initiatives where Initiative_Status<>'Cancelled') B, (select sum(Sponsorship_Total) Contributions,Initiative_Number from contributions group by Initiative_Number) A where B.Initiative_Number=A.Initiative_Number) A WHERE A.Contributions <>0";
      $result = mysqli_query($db,$sql) or die("Error: ".mysqli_error($db));;

      ?>

           
   <TABLE class="silentservanttable" BORDER="solid" BGCOLOR="black" cellpadding="1" cellspacing="1" align="center" >
   
   <THEAD BGCOLOR="lightgrey">
    <TH>Initiative_Name</TH><TH>Initiative_Details</TH><TH>Initiative_Category</TH><TH>Contributions</TH>
     </THEAD>


<TBODY BGCOLOR="white">
      
<?php

  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
  echo "<tr>";
   
  echo "<td>".$row['Initiative_Name']."</td>";
  echo "<td>".$row['Initiative_Details']."</td>";
  echo "<td>".$row['Initiative_Category']."</td>";
  echo "<td>".$row['Contributions']."</td>";
  
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