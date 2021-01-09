<?php
session_start();
include_once('php/dbconnect.php'); /*Database Connection Include Here*/
$deleteid=$_GET['id'];
$tablename=$_GET['table'];
$Query="DELETE  FROM ".$tablename." WHERE vacancyid='$deleteid'";

mysql_query($Query);
?>
<script type="text/javascript">
alert("Row Deleted Successfully...!");
window.location.href = "vacancydetail.php";
</script>