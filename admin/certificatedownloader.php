<?php
require_once("php/session.php");
require_once("php/class.user.php");/*Database Connection Include Here*/
$auth_user = new USER();

if(isset($_GET['applicationid'])&& $session->is_loggedin()&&$_GET['value'])
{
	$applicantid=$_GET['applicationid'];
	$value=$_GET['value'];		
}
?>

<?php
	$stmt = $auth_user->runQuery("SELECT eeducation,aeducation,local,identity,caste,other FROM imagedetails WHERE applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
		while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$eeducation = $userRow['eeducation'];
			$aeducation = $userRow['aeducation'];
			$local = $userRow['local'];
			$identity = $userRow['identity'];
			$caste = $userRow['caste'];
			$other = $userRow['other'];
		}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>RECRUITMENT PORTAL, DHANBAD</title>
</head>

<body>
<?php
if($value=='eedu')
{
		// Essential
		if($eeducation==""||$eeducation=="NULL")
		{
		?>
		<img src='assets/img/0000.jpg'>
		<?php
		}
		else
		{		
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $eeducation ).'"/>';		
		}
}
else if($value=='aedu')
{	
		// Additional
		if($aeducation==""||$aeducation=="NULL")
		{
		?>
		<img src='assets/img/0000.jpg'>
		<?php
		}
		else
		{
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $aeducation ).'"/>';		
		}
}
else if($value=='loc')
{	
		// Local
		if($local==""||$local=="NULL")
		{
		?>
		<img src='assets/img/0000.jpg'>
		<?php
		}
		else
		{
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $local ).'"/>';		
		}
}
else if($value=='ide')
{		
		// Identity
		if($identity==""||$identity=="NULL")
		{
		?>
		<img src='assets/img/0000.jpg'>
		<?php
		}
		else
		{
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $identity ).'"/>';		
		}
}
else if($value=='cas')
{
		//Caste
		if($caste==""||$caste=="NULL")
		{
		?>
		<img src='assets/img/0000.jpg'>
		<?php
		}
		else
		{
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $caste ).'"/>';
		}
}
else if($value=='oth')
{
		if($other==""||$other=="NULL")
		{
		?>
		<img src='assets/img/0000.jpg'>
		<?php
		}
		else
		{
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $other ).'"/>';
		}
}
else
{
	?>
	<img src='assets/img/0000.jpg'>
    <?php
}
?>

</body>
</html>