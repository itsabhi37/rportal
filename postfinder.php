<?php 
require_once("php/class.user.php");
$auth_user = new USER();


if(!empty($_POST['rect_id']))
{
$rect_id= $_POST['rect_id'];
}
?>
<option value="">Please Select Post</option>		
<?php

$stmt = $auth_user->runQuery("SELECT id,name FROM masterpost WHERE recruitmentid='$rect_id' ORDER BY name");// Run your query	
$stmt->execute();
while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
{												
// Loop through the query results, outputing the options one by one
	echo '<option value="'.$userRow['id'].'">'.$userRow['name'].'</option>';				
}	
?>
