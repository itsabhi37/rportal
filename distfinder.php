<?php 
require_once("php/class.user.php");
$auth_user = new USER();

if(!empty($_POST['rect_id']))
{
$rect_id= $_POST['rect_id'];
}
?>		
<?php

$stmt = $auth_user->runQuery("SELECT md.name as distname FROM masterdist md,masterrecruitment mr WHERE mr.distid=md.id AND mr.id='$rect_id'");// Run your query	
$stmt->execute();

while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
{												
// Loop through the query results, outputing the options one by one
	
	echo '<input type="text" value="'.$userRow['distname'].'"  name="txtDistrictFor" class="form-control" disabled>';	
}				
?>
