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
	$stmt = $auth_user->runQuery("SELECT rd.applicantid,mr.name as recruitmentname,mp.name as postname,rd.applicantname,rd.fathername,rd.dob,rd.category,rd.presentaddress,rd.presentdistrict,rd.presentstate,rd.presentpin,imd.photo,imd.sign,me.centername,me.examdate,me.reportingtime,me.starttime,me.duration FROM registrationdetails rd,masterrecruitment mr,masterpost mp,imagedetails imd,masterexam me,exammapdetails emd WHERE rd.recruitmentid=mr.id AND rd.postid=mp.id AND imd.applicantid=rd.applicantid AND me.id=emd.slotid AND emd.applicantid=rd.applicantid AND rd.applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
		while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$applicantid = $userRow['applicantid'];
			$applicantname = $userRow['applicantname'];
			$recruitmentname = $userRow['recruitmentname'];
			$postname = $userRow['postname'];
			$fathername = $userRow['fathername'];
			$dob = date("d-m-Y", strtotime($userRow['dob']));//dd-mm-yy
			$category = $userRow['category'];			
			
			$presentaddress = $userRow['presentaddress'];
			$presentdistrict = $userRow['presentdistrict'];
			$presentstate = $userRow['presentstate'];
			$presentpin = $userRow['presentpin'];
			
			$photo=$userRow['photo'];
			$sign=$userRow['sign'];
			
			$centername = $userRow['centername'];
			$centername = str_replace(array("\\r","\\n"), array("\r","\n"), $centername);// Remove /r/n 
			$examdate = $userRow['examdate'];
			$examdate = date("d-m-Y", strtotime($userRow['examdate']));//dd-mm-yy
			$reportingtime = $userRow['reportingtime'];
			$reportingtime=date("g:i a",strtotime($reportingtime)); //AM/PM Format
			$starttime = $userRow['starttime'];
			$starttime=date("g:i a",strtotime($starttime));//AM/PM Format
			$duration = $userRow['duration'];
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
<div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
			
            			<form  method="POST">
                        <!-- Table for Education Details-->
						<div class="row">
                        <div class="col-lg-offset-1 col-lg-10 col-lg-offset-1">
						<div class="table-responsive">
							<table class='table table-striped table-bordered table-hover'>
                            <tr>
                                <td colspan="4" style="text-align:center;font-weight:bold; font-size:20px;"><?php echo $recruitmentname; ?></td>
                           </tr>
							<tr>
                                <td colspan="4" style="text-align:center;font-weight:bold; font-size:17px;">ADMIT CARD</td>
                           </tr>
							
						   <tr>
								<td style="text-align:left; font-weight:bold;font-size:15px;width:25%">Applicant ID :</td>
								<td style="text-align:left;font-size:15px; width:25%"><?php 
								echo $applicantid;
								?></td>
								<td style="text-align:left; font-weight:bold; font-size:15px;width:25%"> Post :</td>
								<td style="text-align:left; font-size:15x; width:25%"><?php echo $postname; ?></td>
								
						   </tr>
						  <tr>
								<td style="text-align:left; font-weight:bold; font-size:15px;width:25%">Applicant Name :</td>
								<td style="text-align:left; font-size:15x; width:25%"><?php 
								echo $applicantname;
								?></td>
								<td style="text-align:left; font-weight:bold;font-size:15px;width:25%"> Father Name :</td>
								<td style="text-align:left;font-size:15px;width:25%"><?php echo $fathername; ?></td>
								
						   </tr>
                           <tr>
                           		<td style="text-align:left; font-weight:bold;font-size:15px;width:25%">Date Of Birth :</td>
								<td style="text-align:left; font-size:15px; width:25%"><?php 
								echo $dob;
								?></td>
								<td style="text-align:left; font-weight:bold; font-size:15px;width:25%"> Category :</td>
								<td style="text-align:left; font-size:15x; width:25%"><?php 
								echo $category;
								?></td>
						   </tr>
                           <tr>
                                 <td colspan="2" ><font style="text-align:left; font-weight:bold; font-size:15x;">Address : </font> <br>								<?php 
                                    echo $presentaddress.', '; 
									echo $presentdistrict.',<br>'; 
									echo $presentstate.',<br>';  
									echo $presentpin;        
                                	?>
                                </td>
                                <td style="text-align:center;font-size:12px; width:20%">Paste here recent passport size (45 mm X 30 mm) colour photograph (similar to that uploaded in online application) and then self-attest.Do not sign on the face.
                                </td>
								<td style="text-align:center; font-weight:bold; font-size:15x; width:20%">
                                <img style="width:130;height:160px" src='data:image/jpeg;base64,<?php echo base64_encode($photo); ?>'>
                                </td>
						   </tr>
						   <tr>
                                 <td colspan="2" ><font style="text-align:left; font-weight:bold; font-size:15x;">Signature of Invigilator : </font>
                                </td>
                                <td style="text-align:left; font-weight:bold; font-size:15x; width:20%"><font style="text-align:left; font-weight:bold; font-size:15x;">Candidate Signature : </font>
                                </td>
								<td style="text-align:center; font-weight:bold; font-size:15x; width:20%">
                                <img style="width:120;height:80px" src='data:image/jpeg;base64,<?php echo base64_encode($sign); ?>'>
                                </td>
						   </tr>
                           <tr>
								<td colspan="2" ><font style="text-align:left; font-weight:bold; font-size:15x;">Examination Date : </font><?php echo $examdate;?><br>								
                                <font style="text-align:left; font-weight:bold; font-size:15x;">Reporting Time : </font><?php echo $reportingtime;?> <br>
                                <font style="text-align:left; font-weight:bold; font-size:15x;">Examination Start Time : </font><?php echo $starttime;?> <br>
								<font style="text-align:left; font-weight:bold; font-size:15x;">Duration : </font><?php echo $duration;?> <br>
                                </td>
                                <td colspan="2"><font style="text-align:left; font-weight:bold; font-size:15x;">Examination Venue :</font><br><?php echo $centername;?>
                                
                                </td>
						   </tr>
							</table>
							
							<table  style="page-break-before:always;" class='table table-striped table-bordered table-hover'>
                            <tr>
                                <td colspan="4" style="text-align:center;font-weight:bold; font-size:17px;">Important Instructions to the Candidates</td>
                           </tr>
							<tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">1. Candidates should bring this Admit card with one recent passport size color photograph firmly pasted on it(similar to uploaded photograph) and self-attested. Admit card is to be handed over to the Test Administrator/Invigilator in the examination hall.</td>
                           </tr>
                           <tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">2. Candidates should keep a photocopy of this admit card affixed with recent coloured photographs for further reference.</td>
                           </tr>
                           <tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">3. Candidates should bring Valid & Original Photo Identity Proof <b>such as voter ID/Aadhar Card/Bank passbook with photograph/Passport/Driving License OR any other Govt. recognized photo ID proof.</b> Candidate should bring one photocopy of the Original ID.</td>
                           </tr>
                           <tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">4. <b>Candidate without photograph pasted on the Admit card and Photo ID proof will not be permitted to appear for the examination. Name on Admit card and ID Proof should match with each other.</b></td>
                           </tr>
                           <tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">5.  Candidates must bring stationary such as pencils and ballpoint pen with you. <b>No Candidate will be allowed to leave the examination hall until full examination time is over.</b></td>
                           </tr>
                           <tr>
                               <td colspan="4" style="text-align:justify;font-size:14px;">6.  Candidates are advised to report at the examination venue at the Reporting time mentioned on the Admit card. <b>Candidate will not be allowed to Enter Examination venue once examination will started.</b></td>
                           </tr>
                           <tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">7.  Use  of  books,  notebooks,  calculators,  watch  calculators,  pagers,  cell  phones  and  ring  with  built  in calculator/memory, digital diary etc. or any other electronic gadgets or recording devices are not permitted in this examination area. Any candidate found resorting to any unfair means or malpractice or any misconduct during the examination, including giving/receiving help to/from any candidate during the test will be disqualified. Request for change of Test center/venue/date/time of examination will not be entertained.</td>
                           </tr>
                           <tr>
                                <td colspan="4" style="text-align:justify;font-size:14px;">8. You should put your signature on the admit card in the presence of the Invigilator.</td>
                           </tr>
							</table>
						</div>
                        </div>
                        </div>
                       
						<div class="row">
						<div class="col-lg-offset-5 col-lg-5 ">
                                <div class="form-group input-group">
								<button type="submit" class="noprint btn btn-primary" style="outline:none;" name="btnclose" onClick="window.print()">
                                Print Admit Card
                                </button>
								</div>
                        </div>
						</div>
                    </form>
					
                                
            </div>