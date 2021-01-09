<link rel="icon" href="assets/img/logo.png" type="image/png">
<?php
require_once("php/session.php");
require_once("php/class.user.php");/*Database Connection Include Here*/
$auth_user = new USER();

if(isset($_GET['applicationid'])&& $session->is_loggedin())
{
	$applicantid=$_GET['applicationid'];		
}
?>
<?php
date_default_timezone_set('Asia/Kolkata');
?>

<?php
	$stmt = $auth_user->runQuery("SELECT mr.startdate,mr.enddate FROM masterrecruitment mr,registrationdetails rd WHERE rd.recruitmentid=mr.id AND rd.applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
	
	$ststmt = $auth_user->runQuery("SELECT status FROM registrationdetails WHERE applicantid=:applicantid");
	$ststmt->execute(array(":applicantid"=>$applicantid));
	$row = $ststmt->fetch(PDO::FETCH_ASSOC);
	$status = $row['status'];
	
	// Loop through the query results, outputing the options one by one
		
	while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$vaccurrent_date=date('Y/m/d');	
		$startdate=date($userRow['startdate']);														
		$enddate=date($userRow['enddate']);
		if(strtotime($vaccurrent_date)<=strtotime($enddate)&&strtotime($vaccurrent_date)>=strtotime($startdate))
		{	
			if($status!=5)
			{
			header("Location: form.php");
			}
		}	
		else 
		{
			if($status!=5)
			{
			header("Location: userdashboard.php");
			}
		}
	}													
?>

<?php
	   $stmt = $auth_user->runQuery("SELECT rd.applicantname,mr.name as recruitmentname,mr.ageondate as certaindate,mp.name as postname,md.name as distname,rd.fathername,rd.dob,rd.ageondate,rd.mobileno,rd.email,rd.gender,rd.marital,rd.category,rd.phhandicaped,rd.documenttype,rd.documentno,rd.identification1,rd.identification2,rd.presentaddress,rd.presentdistrict,rd.presentstate,rd.presentpin,rd.permanentaddress,rd.permanentdistrict,rd.permanentdistrict,rd.permanentstate,rd.permanentpin,img.photo as photo,img.sign as sign FROM registrationdetails rd,imagedetails img,masterrecruitment mr,masterpost mp,masterdist md WHERE md.id=mr.distid AND mr.id=rd.recruitmentid AND img.applicantid=rd.applicantid AND mp.id=rd.postid AND rd.applicantid=:applicantid");// Run your query	
	   $stmt->execute(array(":applicantid"=>$applicantid));
		while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$applicantname = $userRow['applicantname'];
			$recruitmentname = $userRow['recruitmentname'];
			$certaindate = date("d-m-Y", strtotime($userRow['certaindate']));//dd-mm-yy			
			$postname = $userRow['postname'];
			$distname = $userRow['distname'];
			$fathername = $userRow['fathername'];
			$dob = date("d-m-Y", strtotime($userRow['dob']));//dd-mm-yy
			$ageondate = $userRow['ageondate'];
			$mobileno = $userRow['mobileno'];
			$email = $userRow['email'];
			$gender = $userRow['gender'];
			$marital = $userRow['marital'];
			$category = $userRow['category'];
			$phhandicaped = $userRow['phhandicaped'];
			$documenttype = $userRow['documenttype'];
			$documentno = $userRow['documentno'];
			$identification1 = $userRow['identification1'];
			$identification2 = $userRow['identification2'];
			
            $presentaddress = $userRow['presentaddress'];
			$presentdistrict = $userRow['presentdistrict'];
			$presentstate = $userRow['presentstate'];
			$presentpin = $userRow['presentpin'];
			
			$permanentaddress = $userRow['permanentaddress'];
			$permanentstate = $userRow['permanentstate'];
			$permanentdistrict = $userRow['permanentdistrict'];
			$permanentpin = $userRow['permanentpin'];
            
			$photo=$userRow['photo'];
			$sign=$userRow['sign'];
		}
    
        $edustmt = $auth_user->runQuery("SELECT *FROM educationdetails WHERE applicantid=:applicantid");// Run your query	
	    $edustmt->execute(array(":applicantid"=>$applicantid));
		while ($userRow = $edustmt->fetch(PDO::FETCH_ASSOC))
		{
                // Education Qualification Details
                $fquali[]=$userRow['quali'];			
                $fsubj[]=$userRow['subj'];
                $fper[]=$userRow['per'];	
                $fpy[]= date("d-m-Y", strtotime($userRow['py'])); 
        }

        $addstmt = $auth_user->runQuery("SELECT *FROM additionalqualification WHERE applicantid=:applicantid");// Run your query	
	    $addstmt->execute(array(":applicantid"=>$applicantid));
		while ($userRow = $addstmt->fetch(PDO::FETCH_ASSOC))
        {
                // Additional Qualification Details
                $faquali[]=$userRow['quali'];			
                $fasubj[]=$userRow['subj'];
                $faper[]=$userRow['per'];		
                $fapy[] = date("d-m-Y", strtotime($userRow['py'])); //dd-mm-yyyy
        }

        $expstmt = $auth_user->runQuery("SELECT *FROM experiencedetails WHERE applicantid=:applicantid");// Run your query	
	    $expstmt->execute(array(":applicantid"=>$applicantid));
		while ($userRow = $expstmt->fetch(PDO::FETCH_ASSOC))
        {
                // Experience Details
                $forganisation[]=$userRow['organisation'];	
                $fdesignation[]=$userRow['designation'];	
                $fnature[]=$userRow['nature'];
                $ffrom[] = date("d-m-Y", strtotime($userRow['wfrom'])); //dd-mm-yyyy
                $fto[] = date("d-m-Y", strtotime($userRow['wto'])); //dd-mm-yyyy	
        }
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>RECRUITMENT PORTAL, DHANBAD</title>
    <!-- Additional Jquery file -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- custom styles -->
	<link href="assets/css/custom.css" rel="stylesheet">
	<link href="assets/css/prettify.css" rel="stylesheet">
	
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLE CSS -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="assets/css/bootstrap-select.css">
    <!-- GOOGLE FONT CSS -->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css' />
	<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css"/>
  	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
	<script>
	$(function() {
		$( ".cal" ).datepicker({ 
		dateFormat: 'dd-mm-yy' ,
		changeMonth: true,
		changeYear: true
		});
	});  
	</script>
</head>
<style>
@media print {
   .noprint{
      display: none !important;
   }
}
</style>
<body>
    <form  method="POST">
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered'>
							<tr>
    						<td colspan="2" style="font-weight:bold; font-size:21px; text-align:center;"><?php echo $recruitmentname;?><br><font style="font-size:18px;"></font></td>
  							</tr>
							<tr>
                                <td colspan="2" style="text-align:center;font-weight:bold; font-size:16px;">APPLICATION FORM</td>
                           </tr>
  							<tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px; width:50%">Applicant ID :</td>
                                <td style="text-align:left; font-weight:bold; font-size:14px;"><?php 
									echo $applicantid;
								?></td>
                           </tr>
						   <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px; width:50%">Post Applied For :</td>
                                <td style="text-align:left; font-size:14px;"><?php 
									echo $postname;
								?></td>
                           </tr>
						   <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px; width:50%">Applied For :</td>
                                <td style="text-align:left; font-size:14px;"><?php 
									echo $distname;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Applicant Name :</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $applicantname;
								?></td>
                           </tr>
  							<tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px; width:50%">Father Name :</td>
                                <td style="text-align:left;font-size:14px;"><?php 
									echo $fathername;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Date Of Birth :</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $dob;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Age On (<?php echo $certaindate;?>) :</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $ageondate;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">Gender:</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $gender;
								?></td>
                           </tr>
						   <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">Marital Status:</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $marital;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">Category:</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $category;
								?></td>
                           </tr>                            
                            <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Mobile No. :</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $mobileno;
								?></td>
                           </tr>
						   <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Document Type :</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $documenttype;
								?></td>
                           </tr>
						    <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Document No. :</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $documentno;
								?></td>
                           </tr>
						   <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Identification Marks :</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $identification1.'<br/>';
								echo $identification2;
								?>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Email ID:</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $email;
								?></td>
                           </tr>
                           <tr>
                                <td colspan="2" style="font-weight:bold; font-size:16px;">Communication Details</td>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">Address:</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $presentaddress;
								?></td>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold;  font-size:15px;width:50%">District:</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $presentdistrict;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold; font-size:15px;width:50%">State:</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $presentstate;
								?></td>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">Pin:</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $presentpin;
								?></td>
                           </tr>
						   <tr>
                                <td colspan="2" style="font-weight:bold; font-size:16px;">Permanent Details</td>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">Address:</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $permanentaddress;
								?></td>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">District:</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $permanentdistrict;
								?></td>
                           </tr>
                           <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">State:</td>
                                <td style="text-align:left;font-size:14px;"><?php 
								echo $permanentstate;
								?></td>
                           </tr>
                            <tr>
                                <td style="text-align:right; font-weight:bold;font-size:15px;width:50%">Pin:</td>
                                <td style="text-align:left; font-size:14px;"><?php 
								echo $permanentpin;
								?></td>
                           </tr>
							</table>
						</div>
                        </div>
                        <!-- Table for Education Details-->
						
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered'>
							<tr>
                                <td colspan="4" style="font-weight:bold; font-size:16px;">Essential Educational Details</td>
                           </tr>
							
						   <tr>
								<td style="text-align:left; font-weight:bold;font-size:15px;width:35%">Qualification</td>
								<td style="text-align:left; font-weight:bold;font-size:15px; width:30%">University / Institute Name </td>
								<td style="text-align:left; font-weight:bold; font-size:15px;width:15%">Percentage</td>
                                <td style="text-align:left; font-weight:bold; font-size:15px;width:20%">Passing Year</td>
						   </tr>
						   <tr>
								<td style="text-align:left; font-size:14px;width:35%"><?php 
								echo $fquali[0];
								?></td>
								<td style="text-align:left;font-size:14px; width:30%"><?php
								echo $fsubj[0];
								?> </td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
								if($fper[0]==0)
									{
										echo '';
									}
									else
									{
									echo $fper[0];
									}
								?>
                                </td>
								<td style="text-align:left;font-size:14px; width:20%"><?php
								if($fpy[0]=="00-00-0000"||$fpy[0]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $fpy[0];
									}
                                ?>
                                </td>
						   </tr>
						   <tr>
								<td style="text-align:left; font-size:14px;width:35%"><?php 
								echo $fquali[1];
								?></td>
								<td style="text-align:left;font-size:14px; width:30%"><?php
								echo $fsubj[1];
								?> </td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
								if($fper[1]==0)
									{
										echo '';
									}
									else
									{
									echo $fper[1];
									}		
								?>
                                </td>
								<td style="text-align:left;font-size:14px; width:20%"><?php
								if($fpy[1]=="00-00-0000"||$fpy[1]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									   echo $fpy[1];
									}
                                ?>
                                </td>
						   </tr>
						    <tr>
								<td style="text-align:left; font-size:14px;width:35%"><?php 
								echo $fquali[2];
								?></td>
								<td style="text-align:left;font-size:14px; width:30%"><?php
								echo $fsubj[2];
								?> </td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
									if($fper[2]==0)
									{
										echo '';
									}
									else
									{
									echo $fper[2];
									}
								?>
                                </td>
								<td style="text-align:left;font-size:14px; width:20%"><?php
								if($fpy[2]=="00-00-0000"||$fpy[2]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $fpy[2];
									}
                                ?>
                                </td>
						   </tr>
							</table>
						</div>
                        </div>
						<!-- Table for Additional Education Details-->
						
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered'>
							<tr>
                                <td colspan="4" style="font-weight:bold; font-size:16px;">Additional Educational Details</td>
                           </tr>
							
						   <tr>
								<td style="text-align:left; font-weight:bold;font-size:15px;width:35%">Qualification</td>
								<td style="text-align:left; font-weight:bold;font-size:15px; width:30%">University / Institute Name </td>
								<td style="text-align:left; font-weight:bold; font-size:15px;width:15%">Percentage</td>
                                <td style="text-align:left; font-weight:bold; font-size:15px;width:20%">Passing Year</td>
						   </tr>
						   <tr>
								<td style="text-align:left; font-size:14px;width:35%"><?php 
								echo $faquali[0];
								?></td>
								<td style="text-align:left;font-size:14px; width:30%"><?php
								echo $fasubj[0];
								?> </td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
								    if($faper[0]==0)
									{
										echo '';
									}
									else
									{
									   echo $faper[0];
									}
								?>
                                </td>
								<td style="text-align:left;font-size:14px; width:20%"><?php
								    if($fapy[0]=="00-00-0000"||$fapy[0]=="01-01-1970"){
										echo '';
									}
									else{
									   echo $fapy[0];
									}
                                ?>
                                </td>
						   </tr>
						   <tr>
								<td style="text-align:left; font-size:14px;width:35%"><?php 
								echo $faquali[1];
								?></td>
								<td style="text-align:left;font-size:14px; width:30%"><?php
								echo $fasubj[1];
								?> </td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
								if($faper[1]==0)
									{
										echo '';
									}
									else
									{
									   echo $faper[1];
									}		
								?>
                                </td>
								<td style="text-align:left;font-size:14px; width:20%"><?php
								if($fapy[1]=="00-00-0000"||$fapy[1]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									   echo $fapy[1];
									}
                                ?>
                                </td>
						   </tr>
						    <tr>
								<td style="text-align:left; font-size:14px;width:35%"><?php 
								echo $faquali[2];
								?></td>
								<td style="text-align:left;font-size:14px; width:30%"><?php
								echo $fasubj[2];
								?> </td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
									if($faper[2]==0)
									{
										echo '';
									}
									else
									{
									echo $faper[2];
									}
								?>
                                </td>
								<td style="text-align:left;font-size:14px; width:20%"><?php
								if($fapy[2]=="00-00-0000"||$fapy[2]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $fapy[2];
									}
                                ?>
                                </td>
						   </tr>
							</table>
						</div>
                        </div>
						
                        <!-- Table for Work Experience Details-->
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered'>
							<tr>
                                <td colspan="5" style="font-weight:bold; font-size:16px;">Work Experience Details</td>
                           </tr>
						   <tr>
								<td style="text-align:left; font-weight:bold;font-size:15px;width:30%">Organisation</td>
								<td style="text-align:left; font-weight:bold;font-size:15px; width:20%">Designation </td>
								<td style="text-align:left; font-weight:bold;font-size:15px; width:20%">Nature Of Work </td>
								<td style="text-align:left; font-weight:bold; font-size:15px;width:15%">From</td>
								<td style="text-align:left; font-weight:bold;font-size:15px; width:15%">To</td>
						   </tr>
						   <tr>
								<td style="text-align:left;font-size:14x;width:30%"><?php 
								echo $forganisation[0];
								?></td>
								<td style="text-align:left; font-size:14px; width:20%">
                                <?php echo $fdesignation[0];
								?>
                                 </td>
								 <td style="text-align:left;font-size:14x;width:20%"><?php 
								echo $fnature[0];
								?></td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
									if($ffrom[0]=="00-00-0000"||$ffrom[0]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $ffrom[0];
									}
								?> </td>
								<td style="text-align:left; font-size:14px; width:15%"><?php 
									if($fto[0]=="00-00-0000"||$fto[0]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $fto[0];
									}
								?></td>
						   </tr>
						    <tr>
								<td style="text-align:left;font-size:14x;width:30%"><?php 
								echo $forganisation[1];
								?></td>
								<td style="text-align:left; font-size:14px; width:20%">
                                <?php echo $fdesignation[1];
								?>
                                 </td>
								 <td style="text-align:left;font-size:14x;width:20%"><?php 
								echo $fnature[1];
								?></td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
									if($ffrom[1]=="00-00-0000"||$ffrom[1]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $ffrom[1];
									}
								?> </td>
								<td style="text-align:left; font-size:14px; width:15%"><?php 
								if($fto[1]=="00-00-0000"||$fto[1]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $fto[1];
									}
								?></td>
						   </tr>
						    <tr>
								<td style="text-align:left;font-size:14x;width:30%"><?php 
								echo $forganisation[2];
								?></td>
								<td style="text-align:left; font-size:14px; width:20%">
                                <?php echo $fdesignation[2];
								?>
                                 </td>
								 <td style="text-align:left;font-size:14x;width:20%"><?php 
								echo $fnature[2];
								?></td>
								<td style="text-align:left;font-size:14px;width:15%"><?php
									if($ffrom[2]=="00-00-0000"||$ffrom[2]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $ffrom[2];
									}
								?> </td>
								<td style="text-align:left; font-size:14px; width:15%"><?php 
								if($fto[2]=="00-00-0000"||$fto[2]=="01-01-1970")
									{
										echo '';
									}
									else
									{
									echo $fto[2];
									}
								?></td>
						   </tr>
							</table>
						</div>
                        </div>                   
                        <!-- Table for Any Images-->
						
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered'>
							<tr>
                                <td colspan="2" style="font-weight:bold; font-size:16px;width:50%;">Your Image</td>
                                <td colspan="2" style="font-weight:bold; font-size:16px;width:50%;">
								<?php
								echo '<img style="width:130px;height:160px" src="data:image/jpeg;base64,'.base64_encode( $photo ).'"/>';
								?>
                                </td>
                           </tr>
						   
							</table>
						</div>
                        </div>
                        <!-- Declaration & Signature-->
						
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered'>
                            <tr>
                                <td colspan="4" style="font-weight:bold; font-size:16px;width:100%;">Declaration</td>
                           </tr>
						   <tr>
                                <td colspan="4" style="font-size:14px;width:100%;">I hereby declare that all the statement information furnished & papers attached are true to best of my knowledge and belief. I have not been prosecuted or punished by any Court of law for any offence or involved/named/charge sheeted in any criminal or like case. If any of the information furnished by the undersigned is formed to be false, my candidature be deemed void and be appropriately penalized.</td>
                           </tr>
                           <tr>
                                <td colspan="4" style="font-weight:bold;text-align:right;font-size:16px;width:100%;">
								 <?php
								echo '<img style="width:250px;height:50px" src="data:image/jpeg;base64,'.base64_encode( $sign ).'"/>';
								?>
                                 </td>
                           </tr>
							</table>						
                        </div>
                        </div>
						<div class="col-lg-offset-5 col-lg-5 ">
                                <div class="form-group input-group">
								<button type="submit" class="noprint btn btn-primary" style="outline:none;" name="btnclose" onClick="window.print()">
                                Print Application Form
                                </button>
								</div>
                        </div>
                        
                        
                    </form>