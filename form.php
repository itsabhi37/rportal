<?php
require_once("php/session.php");
require_once("php/class.user.php");/*Database Connection Include Here*/
require_once("php/header.php"); /*Header Section Include Here*/
$auth_user = new USER();
$applicantid=$_SESSION['applicantid'];
?>
<?php
	$stmt = $auth_user->runQuery("SELECT mr.startdate,mr.enddate FROM masterrecruitment mr,registrationdetails rd WHERE rd.recruitmentid=mr.id AND rd.applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
	
	// Loop through the query results, outputing the options one by one
		
	while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$vaccurrent_date=date('Y/m/d');	
		$startdate=date($userRow['startdate']);														
		$enddate=date($userRow['enddate']);
		if(strtotime($vaccurrent_date)<=strtotime($enddate)&&strtotime($vaccurrent_date)>=strtotime($startdate))
		{														
			// Work Properly
		}	
		else
		{
			header("Location: userdashboard.php");
		}			
	}													
?>
<?php
	$stmt = $auth_user->runQuery("SELECT status FROM registrationdetails WHERE applicantid=:applicantid");
	$stmt->execute(array(":applicantid"=>$applicantid));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$status = $row['status'];

	if($status==5)//form Submited Successfully
	{
		header("Location: userdashboard.php");
	}
?>
<?php
	
/*Previous Next Button Code Starts Here*/
function prevnext($val)
{
	$applicantid=$_SESSION['applicantid'];
	$auth_user = new USER();
	$stmt = $auth_user->runQuery("SELECT status FROM registrationdetails WHERE applicantid=:applicantid");
	$stmt->execute(array(":applicantid"=>$applicantid));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$status = $row['status'];

	echo '<li class="previous"><img src="assets/img/prevbtn.png" align="left" class="button button2"></li>';
	if($status>=$val)
	{                                                  
	echo '<li class="next"><img src="assets/img/nextbtn.png" align="right" class="button button2"></li>';					
	}
}
/*Previous Next Button Code Ends Here*/		
function findstatus()
{	
	$applicantid=$_SESSION['applicantid'];
	$auth_user = new USER();
	$stmt = $auth_user->runQuery("SELECT status FROM registrationdetails WHERE applicantid=:applicantid");
	$stmt->execute(array(":applicantid"=>$applicantid));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$status = $row['status'];

	return $status;
}
?>
<?php
	// Find Basic Details For Edit Mode
 	$stmt = $auth_user->runQuery("SELECT *FROM registrationdetails WHERE applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
		
	while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$fapplicantname=$userRow['applicantname'];
		$fdob = date("d-m-Y", strtotime($userRow['dob']));//dd-mm-yyyy			
		$fmobileno=$userRow['mobileno'];
		$femail=$userRow['email'];
		
		$ffathername=$userRow['fathername'];	
		$fgender=$userRow['gender'];	
		$fmarital=$userRow['marital'];
		$fdocumenttype=$userRow['documenttype'];		
		$fcategory=$userRow['category'];
		$fph=$userRow['phhandicaped'];
		$fdocumentno=$userRow['documentno'];
		$fidentification1=$userRow['identification1'];
		$fidentification2=$userRow['identification2'];
		
		// Present Address
		$fpreaddress=$userRow['presentaddress'];	
		$fpredist=$userRow['presentdistrict'];	
		$fprestate=$userRow['presentstate'];
		$fprepin=$userRow['presentpin'];
		
		$fissame=$userRow['issame'];
		
		// Permanent Address
		$fperaddress=$userRow['permanentaddress'];	
		$fperdist=$userRow['permanentdistrict'];	
		$fperstate=$userRow['permanentstate'];
		$fperpin=$userRow['permanentpin'];
	}
?>

<?php
// Basic Details Section
if(isset($_POST['btnSubmitBasic']))
{
	
	$fathername = $_POST['txtFatherName'];		
	$fathername = trim($fathername);
	
	$gender = $_POST['cmbGender'];		
	$gender = trim($gender);
	
	$marital = $_POST['cmbMarital'];		
	$marital = trim($marital);
	
	$category = $_POST['cmbCategory'];		
	$category = trim($category);
	
	$ph = $_POST['cmbPH'];		
	$ph = trim($ph);
	
	$documenttype = $_POST['cmbDocumentType'];		
	$documenttype = trim($documenttype);
	
	$documentno = $_POST['txtDocumentNo'];		
	$documentno = trim($documentno);
	
	$identification1 = $_POST['txtIdentification1'];		
	$identification1 = trim($identification1);
		
	$identification2 = $_POST['txtIdentification2'];		
	$identification2 = trim($identification2);
	
	
	// Present Address
	$preaddress = $_POST['txtPresentAddress'];		
	$preaddress = trim($preaddress);
	
	$predist = $_POST['txtPresentDistrict'];		
	$predist = trim($predist);
	
	$prestate = $_POST['txtPresentState'];		
	$prestate = trim($prestate);
	
	$prepin = $_POST['txtPresentPin'];		
	$prepin = trim($prepin);
		
	//Permanent Address	
	if($_POST['comFill']=='Checked')
	{
	$peraddress =$preaddress;
	$perdist = $predist;	
	$perstate = $prestate;		
	$perpin = $prepin;
	$issame="Yes";
	}
	else
	{
	$issame="No";
	$peraddress = $_POST['txtPermanentAddress'];		
	$peraddress = trim($peraddress);
	
	$perdist = $_POST['txtPermanentDistrict'];		
	$perdist = trim($perdist);
	
	$perstate = $_POST['txtPermanentState'];		
	$perstate = trim($perstate);
	
	$perpin = $_POST['txtPermanentPin'];		
	$perpin = trim($perpin);		
	}
	
	//Update Registration Details 
		$stmt = $auth_user->runQuery("UPDATE registrationdetails SET fathername=:fathername,gender=:gender,marital=:marital,category=:category,phhandicaped=:phhandicaped,documenttype=:documenttype,documentno=:documentno,identification1=:identification1,identification2=:identification2,presentaddress=:presentaddress,presentdistrict=:presentdistrict,presentstate=:presentstate,presentpin=:presentpin,issame=:issame,permanentaddress=:permanentaddress,permanentdistrict=:permanentdistrict,permanentstate=:permanentstate,permanentpin=:permanentpin WHERE applicantid=:applicantid");
		
		$stmt->execute(array(":fathername"=>$fathername,":gender"=>$gender,":marital"=>$marital,":category"=>$category,":phhandicaped"=>$ph,":documenttype"=>$documenttype,":documentno"=>$documentno,":identification1"=>$identification1,":identification2"=>$identification2,":presentaddress"=>$preaddress,":presentdistrict"=>$predist,":presentstate"=>$prestate,":presentpin"=>$prepin,":issame"=>$issame,":permanentaddress"=>$peraddress,":permanentdistrict"=>$perdist,":permanentstate"=>$perstate,":permanentpin"=>$perpin,":applicantid"=>$applicantid));
		if($status==1)
		{
		$updtstmt = $auth_user->runQuery("UPDATE registrationdetails SET status=2 WHERE applicantid=:applicantid");		
		$updtstmt->execute(array(":applicantid"=>$applicantid));
		}
			?>
			<script type="text/javascript">
			alert("Personal Details Updated Successfully...!!!");
			window.location.href = "form.php";
			</script>
			<?php
	
} 
?>
<?php
	// Find Educational Details For Edit Mode
 	$stmt = $auth_user->runQuery("SELECT *FROM educationdetails WHERE applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));

	while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		// Education Qualification Details
		$fid[]=$userRow['id'];
		$fquali[]=$userRow['quali'];			
		$fsubj[]=$userRow['subj'];
		$fper[]=$userRow['per'];	
		$fpy[]= date("d-m-Y", strtotime($userRow['py'])); //dd-mm-yyyy
		
	}

    // Find Additional Qualification Details For Edit Mode
 	$stmt = $auth_user->runQuery("SELECT *FROM additionalqualification WHERE applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));

	while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		// Additional Qualification Details
		$faid[]=$userRow['id'];
		$faquali[]=$userRow['quali'];			
		$fasubj[]=$userRow['subj'];
		$faper[]=$userRow['per'];		
		$fapy[] = date("d-m-Y", strtotime($userRow['py'])); //dd-mm-yyyy
	}
    
?>

<?php
// Educational Details Section
if(isset($_POST['btnSubmitEducation']))
{
	
    // Educational Details 1
	$quali[0] = trim($_POST['txtQualification1']);	
	$sub[0] = trim($_POST['txtSubject1']);
	$mark[0] = trim($_POST['txtMarks1']);
	$passy0 = trim($_POST['txtPassing1']);		
	$passing[0] = date("Y-m-d", strtotime($passy0)); //yy-mm-dd
    
    // Educational Details 2
    $quali[1] = trim($_POST['txtQualification2']);	
	$sub[1] = trim($_POST['txtSubject2']);
	$mark[1] = trim($_POST['txtMarks2']);
	$passy1 = trim($_POST['txtPassing2']);		
	$passing[1] = date("Y-m-d", strtotime($passy1)); //yy-mm-dd
    
    // Educational Details 3
    $quali[2] = trim($_POST['txtQualification3']);	
	$sub[2] = trim($_POST['txtSubject3']);
	$mark[2] = trim($_POST['txtMarks3']);
	$passy2 = trim($_POST['txtPassing3']);		
	$passing[2] = date("Y-m-d", strtotime($passy2)); //yy-mm-dd
	    
	// Additional Educational Details 1
	$aquali[0] = trim($_POST['txtAQualification1']);	
	$asub[0] = trim($_POST['txtASubject1']);
	$amark[0] = trim($_POST['txtAMarks1']);
	$apassy0 = trim($_POST['txtAPassing1']);		
	$apassing[0] = date("Y-m-d", strtotime($apassy0)); //yy-mm-dd
    
    // Additional Educational Details 2
	$aquali[1] = trim($_POST['txtAQualification2']);	
	$asub[1] = trim($_POST['txtASubject2']);
	$amark[1] = trim($_POST['txtAMarks2']);
	$apassy1 = trim($_POST['txtAPassing2']);		
	$apassing[1] = date("Y-m-d", strtotime($apassy1)); //yy-mm-dd
    
    // Additional Educational Details 3
	$aquali[2] = trim($_POST['txtAQualification3']);	
	$asub[2] = trim($_POST['txtASubject3']);
	$amark[2] = trim($_POST['txtAMarks3']);
	$apassy2 = trim($_POST['txtAPassing3']);		
	$apassing[2] = date("Y-m-d", strtotime($apassy2)); //yy-mm-dd

		if($passing[0]=="")
		{
			?>
			<script type="text/javascript">
			alert("You Can't left blank Passing Date.");
			</script>
			<?php
		}
        else if(trim($quali[0])=="" || trim($sub[0])==""){
            ?>
			<script type="text/javascript">
			alert("You Can't left blank required fields.");
			</script>
			<?php
        }
		else{
		if($status==2)
		{ 
            for($i=0; $i<=2; $i++){  
                    //Insert Educational Details
                    $stmt = $auth_user->runQuery("INSERT INTO educationdetails (applicantid,quali,subj,per,py)VALUES(:applicantid,:quali,:subj,:per,:py)");
                    $stmt->execute(array(":applicantid"=>$applicantid,":quali"=>$quali[$i],":subj"=>$sub[$i],":per"=>$mark[$i],":py"=>$passing[$i]));
                    //Insert Additional Qualification Details
                    $stmt = $auth_user->runQuery("INSERT INTO additionalqualification (applicantid,quali,subj,per,py)VALUES(:applicantid,:aquali,:asubj,:aper,:apy)");
                    $stmt->execute(array(":applicantid"=>$applicantid,":aquali"=>$aquali[$i],":asubj"=>$asub[$i],":aper"=>$amark[$i],":apy"=>$apassing[$i]));
            }
			$updtstmt = $auth_user->runQuery("UPDATE registrationdetails SET status=3 WHERE applicantid=:applicantid");		
			$updtstmt->execute(array(":applicantid"=>$applicantid));
			?>
			<script type="text/javascript">
			alert("Educational Details Updated Successfully...!!!");
			window.location.href = "form.php";
			</script>
			<?php
		}
		else{            
            for($i=0; $i<=2; $i++){
                    //Update Educational Details
                    $stmt = $auth_user->runQuery("UPDATE educationdetails SET quali=:quali,subj=:subj,per=:per,py=:py WHERE id=:id");
                    $stmt->execute(array(":quali"=>$quali[$i],":subj"=>$sub[$i],":per"=>$mark[$i],":py"=>$passing[$i],":id"=>$fid[$i]));
               
                    //Update Additional Qualification Details
                    $adstmt = $auth_user->runQuery("UPDATE additionalqualification SET quali=:aquali,subj=:asubj,per=:aper,py=:apy WHERE id=:id");
                    $adstmt->execute(array(":aquali"=>$aquali[$i],":asubj"=>$asub[$i],":aper"=>$amark[$i],":apy"=>$apassing[$i],":id"=>$faid[$i]));
                
            }
		?>
		<script type="text/javascript">
		alert("Educational Details Updated Successfully...!!!");
		window.location.href = "form.php";
		</script>
		<?php
		}
		}
}

?>

<?php
	// Find Experience Details For Edit Mode
 	$stmt = $auth_user->runQuery("SELECT *FROM experiencedetails WHERE applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
	while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
        $feid[]=$userRow['id'];	
		$forganisation[]=$userRow['organisation'];	
		$fdesignation[]=$userRow['designation'];	
		$fnature[]=$userRow['nature'];
		$ffrom[] = date("d-m-Y", strtotime($userRow['wfrom'])); //dd-mm-yyyy
		$fto[] = date("d-m-Y", strtotime($userRow['wto'])); //dd-mm-yyyy	
	}
?>

<?php
// Experience Details Section
if(isset($_POST['btnSubmitExperience']))
{
	// Experience Details 1
	$organisation[0] = trim($_POST['txtOrganisation1']);		
	$designation[0] = trim($_POST['txtDesignation1']);
	$nature[0] = trim($_POST['txtNature1']);
	$wfm0 = trim($_POST['txtFrom1']);
	$wfrom[0] = date("Y-m-d", strtotime($wfm0)); //yy-mm-dd	
	$wto0 = trim($_POST['txtTo1']);		
	$wto[0] = date("Y-m-d", strtotime($wto0)); //yy-mm-dd
	
	// Experience Details 2
    $organisation[1] = trim($_POST['txtOrganisation2']);		
	$designation[1] = trim($_POST['txtDesignation2']);
	$nature[1] = trim($_POST['txtNature2']);
	$wfm1 = trim($_POST['txtFrom2']);
	$wfrom[1] = date("Y-m-d", strtotime($wfm1)); //yy-mm-dd	
	$wto1 = trim($_POST['txtTo2']);		
	$wto[1] = date("Y-m-d", strtotime($wto1)); //yy-mm-dd
    
	// Experience Details 3
    $organisation[2] = trim($_POST['txtOrganisation3']);		
	$designation[2] = trim($_POST['txtDesignation3']);
	$nature[2] = trim($_POST['txtNature3']);
	$wfm2 = trim($_POST['txtFrom3']);
	$wfrom[2] = date("Y-m-d", strtotime($wfm2)); //yy-mm-dd	
	$wto2 = trim($_POST['txtTo3']);		
	$wto[2] = date("Y-m-d", strtotime($wto2)); //yy-mm-dd
    
		//if($fm1==""||$tof1=="")  
		//{
			?>
			<!--<script type="text/javascript">
			alert("You Can't left blank Date Fields.");
			</script>-->
			<?php
		//}	
		//else
		//{
		if($status==3)
		{
            for($i=0; $i<=2; $i++){  
                   //Insert Experience Details 
                    $stmt = $auth_user->runQuery("INSERT INTO experiencedetails (applicantid,organisation,designation,nature,wfrom,wto)VALUES(:applicantid,:organisation,:designation,:nature,:from,:to)");
                    $stmt->execute(array(":applicantid"=>$applicantid,":organisation"=>$organisation[$i],":designation"=>$designation[$i],":nature"=>$nature[$i],":from"=>$wfrom[$i],":to"=>$wto[$i]));
            }
			$updtstmt = $auth_user->runQuery("UPDATE registrationdetails SET status=4 WHERE applicantid=:applicantid");		
			$updtstmt->execute(array(":applicantid"=>$applicantid));
			?>
			<script type="text/javascript">
			alert("Experience Details Updated Successfully...!!!");
			window.location.href = "form.php";
			</script>
			<?php
		}
		else{
			//Update Experience Details
            for($i=0; $i<=2; $i++){
			     $stmt = $auth_user->runQuery("UPDATE experiencedetails SET organisation=:organisation,designation=:designation,nature=:nature,wfrom=:from,wto=:to WHERE id=:id");
			     $stmt->execute(array(":organisation"=>$organisation[$i],":designation"=>$designation[$i],":nature"=>$nature[$i],":from"=>$wfrom[$i],":to"=>$wto[$i],":id"=>$feid[$i]));
            }
        ?>
		<script type="text/javascript">
		alert("Experience Details Updated Successfully...!!!");
		window.location.href = "form.php";
		</script>
		<?php
		}
		//}
}

?>
<?php


function uploadPhoto() {
	$applcntid=$_SESSION['applicantid'];
    $auth_user = new USER();
    $msg="";
    $maxsize = 153600; //set to approx 150 KB
    $imgData="";
	$signature="";	
	$essentialeducation="";
	$additionaleducation="";
	$localresidential="";
	$identity="";
	$caste="";
	$others="";
    //image
    if($_FILES['file_1']['error']==UPLOAD_ERR_OK) {

        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_1']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_1']['size'] < $maxsize) {
                $imginfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($imginfo, $_FILES['file_1']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($_FILES['file_1']['tmp_name']));
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_1']['name'].' is '.$_FILES['file_1']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }
	else {
        $msg= file_upload_error_message($_FILES['file_1']['error']);
    }
    //Signature
    if($_FILES['file_2']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_2']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_2']['size'] < $maxsize) {
                $signinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($signinfo, $_FILES['file_2']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $signature =addslashes (file_get_contents($_FILES['file_2']['tmp_name']));
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_2']['name'].' is '.$_FILES['file_2']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }

    else {
        $msg= file_upload_error_message($_FILES['file_2']['error']);
    }
	
	 //Essential Education
    if($_FILES['file_3']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_3']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_3']['size'] < $maxsize) {
                $esseduinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($esseduinfo, $_FILES['file_3']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $essentialeducation =addslashes (file_get_contents($_FILES['file_3']['tmp_name']));
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_3']['name'].' is '.$_FILES['file_3']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }

    else {
        $msg= file_upload_error_message($_FILES['file_3']['error']);
    }
	 //Additional Education
    if($_FILES['file_4']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_4']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_4']['size'] < $maxsize) {
                $addeduinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($addeduinfo, $_FILES['file_4']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $additionaleducation =addslashes (file_get_contents($_FILES['file_4']['tmp_name']));                   
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_4']['name'].' is '.$_FILES['file_4']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }

    else {
        $msg= file_upload_error_message($_FILES['file_4']['error']);
    }
	
	//Local Certificates
    if($_FILES['file_5']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_5']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_5']['size'] < $maxsize) {
                $locinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($locinfo, $_FILES['file_5']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $localresidential =addslashes (file_get_contents($_FILES['file_5']['tmp_name']));                   
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_5']['name'].' is '.$_FILES['file_5']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";
    }

    else {
        $msg= file_upload_error_message($_FILES['file_5']['error']);
    }
	
	 //Identity Certificates
    if($_FILES['file_6']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_6']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_6']['size'] < $maxsize) {
                $ideinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($ideinfo, $_FILES['file_6']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $identity =addslashes (file_get_contents($_FILES['file_6']['tmp_name']));                   
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_6']['name'].' is '.$_FILES['file_6']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }

    else {
        $msg= file_upload_error_message($_FILES['file_6']['error']);
    }
	
	 //Caste Certificates
    if($_FILES['file_7']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_7']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_7']['size'] < $maxsize) {
                $casteinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($casteinfo, $_FILES['file_7']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $caste =addslashes (file_get_contents($_FILES['file_7']['tmp_name']));                   
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_7']['name'].' is '.$_FILES['file_7']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }

    else {
        $msg= file_upload_error_message($_FILES['file_7']['error']);
    }
	
	 //Other Certificates
    if($_FILES['file_8']['error']==UPLOAD_ERR_OK) {
        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['file_8']['tmp_name'])) {

            //checks size of uploaded image on server side
            if( $_FILES['file_8']['size'] < $maxsize) {
                $othinfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($othinfo, $_FILES['file_8']['tmp_name']),"image")===0) {
                    // prepare the image for insertion
                    $others =addslashes (file_get_contents($_FILES['file_8']['tmp_name']));                   
                }
                else
                    echo "<script>alert('Uploaded file is not an image.')</script>";
            }
            else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file_8']['name'].' is '.$_FILES['file_8']['size'].
                    ' bytes</div><hr />';
            }
        }
        else
            echo "<script>alert('File not uploaded successfully.')</script>";

    }

    else {
        $msg= file_upload_error_message($_FILES['file_8']['error']);
    }
	
	if($imgData!="" && $signature!="" && $essentialeducation!="" && $localresidential!="" && $identity!="")
	{
					$stmt = $auth_user->runQuery("INSERT into imagedetails (applicantid,photo,sign,eeducation,aeducation,local,identity,caste,other)values('$applcntid','$imgData','$signature','$essentialeducation','$additionaleducation','$localresidential','$identity','$caste','$others')");
                    $stmt->execute();
					$stmt = $auth_user->runQuery("UPDATE registrationdetails SET status=5 WHERE applicantid='$applcntid'");
                    $stmt->execute();
                    ?>
                    <script type="text/javascript">
                        alert("Image Inserted  Successfully!");
                        window.location.href = "form.php";
                    </script>
                    <?php
		
	}
    return $msg;
}

function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}

if(isset($_POST['btnFinalSubmit']))
	{
			
		if(!isset($_FILES['file_1']) || !isset($_FILES['file_2']) || !isset($_FILES['file_3']) || !isset($_FILES['file_5']) || !isset($_FILES['file_6']))
		{
			echo "<script>alert('Please Upload jpg Or jpeg Image Only.')</script>";
		}
		else
		{
			if(!isset($_POST['declaration']))
			{
				echo "<script>alert('You have to accept declaration.')</script>";
			}
			else
			{
				try {
					$msg= uploadPhoto();  //this will upload your image
				}
				catch(Exception $e) {
					echo $e->getMessage();
					echo "<script>alert('Sorry, could not upload file')</script>";
					echo '';
				}
			}
		}
	}
?>
<script type="text/javascript">
    function validateFileType(idname,input,imgname){
        var fileName = document.getElementById(""+idname).value;
		const fi = document.getElementById(""+idname); 
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" ){ // Is Selected File is Image Or Not
            //TO DO
			if(fi.files.length > 0){
				for (const i = 0; i <= fi.files.length - 1; i++) { 
	  
					const fsize = fi.files.item(i).size;
					//alert('File Size: '+fsize);	
					//const file = Math.round((fsize / 1024)); 
					// The size of the file. 
					if (fsize >= 153600) {  // Is Selected File Size is less than 150kb or not
						alert("File too Big, please select a file less than 150kb"); 
					}else{
						// Image Preview
						if (input.files && input.files[0]) {
							var reader = new FileReader();

							reader.onload = function (e) {
								$('#'+imgname)
									.attr('src', e.target.result)
									.width(150)
									.height(200);
							};

							reader.readAsDataURL(input.files[0]);
						}
					}
				} 
			}
        }else{
            alert("Only jpg/jpeg files are allowed!");
        }					
    }	
</script>

<script>

	/*function readURL(input,imgname) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+imgname)
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }*/
		
//Function for Accepting Only Integer Value
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e,spanname) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById(spanname).style.display = ret ? "none" : "inline";
            return ret;
        }
		
//Function for Accepting Only Float Value
$(function () {
	$('.filterme').keypress(function(eve) {
	  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
		eve.preventDefault();
	  }
		 
	// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
	 $('.filterme').keyup(function(eve) {
	  if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
	  }
	 });
	});
});
function fillBox()
{
		/*Present Address Details TextBoxes Value*/
		var PresentAddress = document.getElementById('txtPresentAddress');
		var PresentDistrict = document.getElementById('txtPresentDistrict');
		var PresentState = document.getElementById('txtPresentState');
		var PresentPin = document.getElementById('txtPresentPin');
		
		/*Permanent Address Details TextBoxes Value*/
		var PermanentAddress = document.getElementById('txtPermanentAddress');
		var PermanentDistrict = document.getElementById('txtPermanentDistrict');
		var PermanentState = document.getElementById('txtPermanentState');
		var PermanentPin = document.getElementById('txtPermanentPin');
		
		if(document.getElementById("comFill").checked == true)	/*If Check Box is Checked*/
		{
			/*Copy Present Address TextBoxes Value To Permanent Address TextBoxes*/
			PermanentAddress.value = PresentAddress.value;
			PermanentDistrict.value = PresentDistrict.value;
			PermanentState.value = PresentState.value;
			PermanentPin.value = PresentPin.value;
			
			PermanentAddress.disabled=true;
			PermanentDistrict.disabled=true;
			PermanentState.disabled=true;
			PermanentPin.disabled=true;
		}
		else	/*If Check Box is Not Checked*/
		{
			/* Set Blank Permanent Address TextBoxes */
			PermanentAddress.value = "";
			PermanentDistrict.value ="";
			PermanentState.value = "";
			PermanentPin.value = "";
	
			PermanentAddress.disabled=false;
			PermanentDistrict.disabled=false;
			PermanentState.disabled=false;
			PermanentPin.disabled=false;
		}
}
</script>
    <style>
	/*Next / Prev Button Style */
	.button {
    display: inline-block;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
	}
	.button2:hover {
    /*box-shadow: 0 12px 16px 0 rgba(0,0,0,0),0 17px 50px 0 rgba(0,0,0,0.10);*/
       filter: box-shadow(5px 5px 5px #222); 
	}	
	</style>
    
	<br/>
    <div class='container'>		
	<div align="right"><a href="logout.php?logout=true" class="label label-danger" ><span class="glyphicon glyphicon-log-out"></span> Logout</a></div><br/>
			<section id="wizard">

				<div id="rootwizard">
					<?php
						include_once('php/wizard.php'); /*Database Connection Include Here*/
					?>
					
					<div class="tab-content">
					    <div class="tab-pane" id="tab1">
						<br/>
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-success">
											<div class="panel-heading">
												<label class="control-label">Personal Details</label>
											</div>       
											<div class="panel-body"> 
												<div class="table-responsive">
													<form method="post" id="Basic">
														<table class='table table-striped table-bordered'>
															<tr>
															<td colspan="2" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">PERSONAL INFORMATION</label></td>
															</tr>
														   <tr>
																<td style="text-align:right;font-size:14px;width:40%"><label class="control-label">Applicant Name :</label></td>
																<td>
																<input type="text" name="txtApplicantName" class="form-control" value="<?php if($status>0){echo $fapplicantname;}?>" disabled>
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Father / Husband Name :</label></td>
																<td>
																<input type="text" name="txtFatherName" class="form-control" value="<?php if($status>1){echo $ffathername;}?>" placeholder="Enter Father Name" required>
																</td>
														   </tr>
                                                            <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label">Date Of Birth :</label></td>
																<td>
																<input type="text" name="txtDOB" class="cal form-control" value="<?php if($status>0){echo $fdob;}?>" disabled>
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Gender :</label></td>
																<td>
																		<select class="form-control" name="cmbGender" required>
																				<option value="">--Please Select--</option>
																				<option value="Female" <?php if($fgender=="Female"){echo 'selected="selected"';} ?>>Female</option>
																				<option value="Male" <?php if($fgender=="Male"){echo 'selected="selected"';} ?>>Male</option>
																				<option value="Others" <?php if($fgender=="Others"){echo 'selected="selected"';} ?>>Others</option>
																		</select>	
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Marital Status :</label></td>
																<td>
																		<select class="form-control" name="cmbMarital" required>
																				<option value="">--Please Select--</option>
																				<option value="Single" <?php if($fmarital=="Single"){echo 'selected="selected"';} ?>>Single</option>
																				<option value="Married" <?php if($fmarital=="Married"){echo 'selected="selected"';} ?>>Married</option>
																		</select>	
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Category :</label></td>
																<td>
																		<select class="form-control" name="cmbCategory" required>
																				<option value="">--Please Select--</option>
																				<option value="BC-I" <?php if($fcategory=="BC-I"){echo 'selected="selected"';} ?>>BC-I</option>
																				<option value="BC-II" <?php if($fcategory=="BC-II"){echo 'selected="selected"';} ?>>BC-II</option>
																				<option value="GEN" <?php if($fcategory=="GEN"){echo 'selected="selected"';} ?>>GEN</option>
																				<option value="SC" <?php if($fcategory=="SC"){echo 'selected="selected"';} ?>>SC</option>
																				<option value="ST" <?php if($fcategory=="ST"){echo 'selected="selected"';} ?>>ST</option>
																				<option value="EWS" <?php if($fcategory=="EWS"){echo 'selected="selected"';} ?>>EWS</option>
																		</select>	
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> PH Handicaped :</label></td>
																<td>
																		<select class="form-control" name="cmbPH" required>
																				<option value="">--Please Select--</option>
																				<option value="No" <?php if($fph=="No"){echo 'selected="selected"';} ?>>No</option>
																				<option value="Yes" <?php if($fph=="Yes"){echo 'selected="selected"';} ?>>Yes</option>
																		</select>	
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Document Type :</label></td>
																<td>	
																<select class="form-control" name="cmbDocumentType" required>
																				<option value="">--Please Select--</option>
																				<option value="Aadhar" <?php if($fdocumenttype=="Aadhar"){echo 'selected="selected"';} ?>>Aadhar</option>
																				<option value="Voter Id" <?php if($fdocumenttype=="Voter Id"){echo 'selected="selected"';} ?>>Voter Id</option>
																				<option value="PAN" <?php if($fdocumenttype=="PAN"){echo 'selected="selected"';} ?>>PAN</option>
																				<option value="Driving Licence" <?php if($fdocumenttype=="Driving Licence"){echo 'selected="selected"';} ?>>Driving Licence</option>
																				<option value="Others" <?php if($fdocumenttype=="Others"){echo 'selected="selected"';} ?>>Others</option>
																</select>
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Document No.  :</label></td>
																<td>
																<input type="text" name="txtDocumentNo" class="form-control" maxlength="20" value="<?php if($status>1){echo $fdocumentno;}?>" placeholder="Enter Document No." required>
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Identification Marks :</label></td>
																<td>
																<input type="text" name="txtIdentification1" class="form-control" maxlength="70" value="<?php if($status>1){echo $fidentification1;}?>" placeholder="Enter Identification Marks I" required><br/>
																<input type="text" name="txtIdentification2" class="form-control" maxlength="70" value="<?php if($status>1){echo $fidentification2;}?>" placeholder="Enter Identification Marks II" required>
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label">Mobile No.  :</label></td>
																<td>
																<input type="text" name="txtMobile" class="form-control" value="<?php if($status>0){echo $fmobileno;}?>" maxlength="10" disabled>
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label">Email Id  :</label></td>
																<td>
																<input type="Email" name="txtEmail" class="form-control" value="<?php if($status>0){echo $femail;}?>" disabled>
																</td>
														   </tr>
                                                           <tr>
															<td colspan="2" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">PRESENT ADDRESS</label></td>
															</tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Address :</label></td>
																<td>
																<input type="text" name="txtPresentAddress" id="txtPresentAddress" class="form-control" value="<?php if($status>1){echo $fpreaddress;}?>" placeholder="Enter Address Here..." required>
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> District :</label></td>
																<td>
																<input type="text" name="txtPresentDistrict" id="txtPresentDistrict" value="<?php if($status>1){echo $fpredist;}?>" class="form-control" placeholder="Enter District Here..." required>
																</td>
														   </tr>
                                                           <tr >
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> State :</label></td>
																<td>
																<input type="text" name="txtPresentState" value="<?php if($status>1){echo $fprestate;}?>" id="txtPresentState"  class="form-control" placeholder="Enter State Here..." required >
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Pin Code :</label></td>
																<td>
																<input type="text" id="txtPresentPin" onkeypress="return IsNumeric(event,'prepin');" onpaste="return false;" ondrop = "return false;" name="txtPresentPin" value="<?php if($status>1){echo $fprepin;}?>" id="txtPresentPin" class="form-control" maxlength="6" placeholder="Enter PIN Code Here..." required>
																<span id="prepin" style="color: Red; display: none">* Input digits (0 - 9)</span>
																</td>
														   </tr>
                                                        	<tr>
															<td colspan="2" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">PERMANENT ADDRESS</label></td>
															</tr>
															<tr>
															<td colspan="2" style="color:#02A67D; font-size:14px; text-align:center;">
																<div class="checkbox">
																  <label><input type="checkbox" name="comFill" onChange="fillBox();" value="Checked" id="comFill" <?php if($fissame=="Yes"){echo 'checked';}?>>Click Here If Permanent Address Is Same As Present Address</label>
																</div>
															</td>
															</tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Address :</label></td>
																<td>
																<input type="text" name="txtPermanentAddress" id="txtPermanentAddress" value="<?php if($status>1){echo $fperaddress;}?>" class="form-control" <?php if($fissame=="Yes"){echo 'disabled';}?> placeholder="Enter Address Here..." required>
																</td>
														   </tr>
														   <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> District :</label></td>
																<td>
																<input type="text" name="txtPermanentDistrict"  value="<?php if($status>1){echo $fperdist;}?>"  id="txtPermanentDistrict" class="form-control" <?php if($fissame=="Yes"){echo 'disabled';}?> placeholder="Enter District Here..." required>
																</td>
														   </tr>
                                                           <tr >
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> State :</label></td>
																<td>
																<input type="text" name="txtPermanentState" id="txtPermanentState" value="<?php if($status>1){echo $fperstate;}?>"  class="form-control" <?php if($fissame=="Yes"){echo 'disabled';}?>  placeholder="Enter State Here..." required>
																</td>
														   </tr>
                                                           <tr>
																<td style="text-align:right; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Pin Code :</label></td>
																<td>
																<input type="text" id="txtPermanentPin" onkeypress="return IsNumeric(event,'perpin');" onpaste="return false;" ondrop = "return false;" name="txtPermanentPin" id="txtPermanentPin"  value="<?php if($status>1){echo $fperpin;}?>" class="form-control" maxlength="6" <?php if($fissame=="Yes"){echo 'disabled';}?> placeholder="Enter PIN Code Here..." required>
																<span id="perpin" style="color: Red; display: none">* Input digits (0 - 9)</span>
																</td>
														   </tr>
                                                           <tr>
																<td colspan="2" style="text-align:center;">
                                                                <ul class="pager wizard">
                                                                <button type="submit" name="btnSubmitBasic" class="btn btn-success" style="outline:none;">Submit</button>
                                                                
             <?php
					$value=findstatus();
					if($value>=2)
					{                                                  
					echo '<li class="next"><img src="assets/img/nextbtn.png" align="right" class="button button2"></li>';
					}
					?>
                    </ul>
																</td>
															</tr>
														</table>
													</form>
													<div style="color:#D61A14">
														Note:<br/>					
														(i) * Are Required fields. <br/>
													</div>
												</div>
											</div>
									</div>
								</div>
							</div>  
					    </div>
					    <div class="tab-pane" id="tab2">
							<br/>				
											<div class="row">
								<div class="col-md-12">
									<div class="panel panel-success">
											<div class="panel-heading">
												<label class="control-label">Educational Details</label>
											</div>       
											<div class="panel-body"> 
												<div class="table-responsive">
													<form method="post" id="education">
														<table class='table table-striped table-bordered'>
															<tr>
															<td colspan="4" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">ESSENTIAL EDUCATIONAL INFORMATION</label></td>
															</tr>
															<tr>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">Qualification Name </label></td>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">University / Institute Name </label></td>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">Percentage Of Marks </label></td>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">Passing Date </label></td>	
															</tr>
														   <tr>
																<td>
																<input type="text" name="txtQualification1" value="<?php if($status>2 && isset($fquali[0])){echo $fquali[0];}?>" class="form-control" required>
																</td>
																<td>
																<input type="text" name="txtSubject1" value="<?php if($status>2 && isset($fsubj[0])){echo $fsubj[0];}?>" class="form-control" required>
																</td>
																<td>
																<input type="text" name="txtMarks1" class="filterme form-control" value="<?php if($status>2 && isset($fper[0])){if($fper[0]!="0"){echo $fper[0];}else{echo '';}}?>" placeholder="00.00" required>
																</td>
																<td>
																<input type="text" name="txtPassing1" class="cal form-control" value="<?php if($status>2 && isset($fpy[0])){if($fpy[0]!="01-01-1970"){echo $fpy[0];}else {echo '';}}?>" style="background-color:#FFF;" required readonly>
																</td>
														   </tr>
														   <tr>
																<td>
																<input type="text" name="txtQualification2" value="<?php if($status>2 && isset($fquali[1])){echo $fquali[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtSubject2" value="<?php if($status>2 && isset($fsubj[1])){echo $fsubj[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtMarks2" class="filterme form-control" value="<?php if($status>2 && isset($fper[1])){if($fper[1]!="0"){echo $fper[1];}else{echo '';}}?>" placeholder="00.00">
																<td>
																<input type="text" name="txtPassing2" class="cal form-control" value="<?php if($status>2 && isset($fpy[1])){if($fpy[1]!="01-01-1970"){echo $fpy[1];}else {echo '';}}?>" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   <tr>
														        <td>
																<input type="text" name="txtQualification3" value="<?php if($status>2 && isset($fquali[2])){echo $fquali[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtSubject3" value="<?php if($status>2 && isset($fsubj[2])){echo $fsubj[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtMarks3" class="filterme form-control" value="<?php if($status>2 && isset($fper[2])){if($fper[2]!="0"){echo $fper[2];}else{echo '';}}?>" placeholder="00.00">
																<td>
																<input type="text" name="txtPassing3" class="cal form-control" value="<?php if($status>2 && isset($fpy[2])){if($fpy[2]!="01-01-1970"){echo $fpy[2];}else {echo '';}}?>" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   
														   <tr>
															<td colspan="4" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">ADDITIONAL EDUCATIONAL INFORMATION</label></td>
															</tr>
															<tr>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">Qualification Name </label></td>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">University / Institute Name </label></td>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">Percentage Of Marks </label></td>
															<td style="text-align:left;font-size:14px;width:25%"><label class="control-label">Passing Date </label></td>	
															</tr>
														   <tr>
																<td>
																<input type="text" name="txtAQualification1" value="<?php if($status>2 && isset($faquali[0])){echo $faquali[0];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtASubject1" value="<?php if($status>2 && isset($fasubj[0])){echo $fasubj[0];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtAMarks1" class="filterme form-control" value="<?php if($status>2 && isset($faper[0])){if($faper[0]!="0"){echo $faper[0];}else{echo '';}}?>" placeholder="00.00">
																</td>
																<td>
																<input type="text" name="txtAPassing1" class="cal form-control" value="<?php if($status>2 && isset($fapy[0])){if($fapy[0]!="01-01-1970"){echo $fapy[0];}else {echo '';}}?>" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   <tr>
														       <td>
																<input type="text" name="txtAQualification2" value="<?php if($status>2 && isset($faquali[1])){echo $faquali[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtASubject2" value="<?php if($status>2 && isset($fasubj[1])){echo $fasubj[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtAMarks2" class="filterme form-control" value="<?php if($status>2 && isset($faper[1])){if($faper[1]!="0"){echo $faper[1];}else{echo '';}}?>" placeholder="00.00">
																</td>
																<td>
																<input type="text" name="txtAPassing2" class="cal form-control" value="<?php if($status>2 && isset($fapy[1])){if($fapy[1]!="01-01-1970"){echo $fapy[1];}else {echo '';}}?>" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   <tr>
														       <td>
																<input type="text" name="txtAQualification3" value="<?php if($status>2 && isset($faquali[2])){echo $faquali[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtASubject3" value="<?php if($status>2 && isset($fasubj[2])){echo $fasubj[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtAMarks3" class="filterme form-control" value="<?php if($status>2 && isset($faper[2])){if($faper[2]!="0"){echo $faper[2];}else{echo '';}}?>" placeholder="00.00">
																</td>
																<td>
																<input type="text" name="txtAPassing3" class="cal form-control" value="<?php if($status>2 && isset($fapy[2])){if($fapy[2]!="01-01-1970"){echo $fapy[2];}else {echo '';}}?>" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
                                                           <tr>
																<td colspan="4" style="text-align:center;">
                                                                <ul class="pager wizard">
                                                                <button type="submit" name="btnSubmitEducation" class="btn btn-success" style="outline:none;">Submit</button>        
             		<?php
					prevnext(3);
					?>
                    </ul>
																</td>
															</tr>
														</table>
													</form>
												</div>
											</div>
									</div>
								</div>
							</div>
					    </div>
						<div class="tab-pane" id="tab3">
                        <br/>				
											<div class="row">
								<div class="col-md-12">
									<div class="panel panel-success">
											<div class="panel-heading">
												<label class="control-label">Experience Details</label>
											</div>       
											<div class="panel-body"> 
												<div class="table-responsive">
													<form method="post" id="commentForm">
														<table class='table table-striped table-bordered'>
															<tr>
															<td colspan="5" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">EXPERIENCE INFORMATION</label></td>
															</tr>
															<tr>
															<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">Name Of Organisation :</label></td>
															<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">Designation :</label></td>
															<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">Nature Of Duty(ies) :</label></td>
															<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">From :</label></td>
															<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">To :</label></td>																
															</tr>
														   <tr>
																<td>
																<input type="text" name="txtOrganisation1" value="<?php if($status>3 && isset($forganisation[0])){echo $forganisation[0];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtDesignation1" value="<?php if($status>3  && isset($fdesignation[0])){echo $fdesignation[0];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtNature1" value="<?php if($status>3 && isset($fnature[0])){echo $fnature[0];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtFrom1" value="<?php if($status>3 && isset($ffrom[0])){if($ffrom[0]!="01-01-1970"){echo $ffrom[0];}else {echo '';}}?>" class="cal form-control" style="background-color:#FFF;" readonly>
																</td>
																<td>
																<input type="text" name="txtTo1" value="<?php if($status>3 && isset($fto[0])){if($fto[0]!="01-01-1970"){echo $fto[0];}else {echo '';}}?>" class="cal form-control" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   <tr>
																<td>
																<input type="text" name="txtOrganisation2" value="<?php if($status>3 && isset($forganisation[1])){echo $forganisation[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtDesignation2" value="<?php if($status>3  && isset($fdesignation[1])){echo $fdesignation[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtNature2" value="<?php if($status>3 && isset($fnature[1])){echo $fnature[1];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtFrom2" value="<?php if($status>3 && isset($ffrom[1])){if($ffrom[1]!="01-01-1970"){echo $ffrom[1];}else {echo '';}}?>" class="cal form-control" style="background-color:#FFF;" readonly>
																</td>
																<td>
																<input type="text" name="txtTo2" value="<?php if($status>3 && isset($fto[1])){if($fto[1]!="01-01-1970"){echo $fto[1];}else {echo '';}}?>" class="cal form-control" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   <tr>
																<td>
																<input type="text" name="txtOrganisation3" value="<?php if($status>3 && isset($forganisation[2])){echo $forganisation[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtDesignation3" value="<?php if($status>3  && isset($fdesignation[2])){echo $fdesignation[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtNature3" value="<?php if($status>3 && isset($fnature[2])){echo $fnature[2];}?>" class="form-control">
																</td>
																<td>
																<input type="text" name="txtFrom3" value="<?php if($status>3 && isset($ffrom[2])){if($ffrom[2]!="01-01-1970"){echo $ffrom[2];}else {echo '';}}?>" class="cal form-control" style="background-color:#FFF;" readonly>
																</td>
																<td>
																<input type="text" name="txtTo3" value="<?php if($status>3 && isset($fto[2])){if($fto[2]!="01-01-1970"){echo $fto[2];}else {echo '';}}?>" class="cal form-control" style="background-color:#FFF;" readonly>
																</td>
														   </tr>
														   <tr>
														   <td colspan="3">
														   <?php	
																//If Error Occurs.
																if(isset($msg)){
																	echo '<font color="#ed3b55" ><b>'.$msg.'</b></font>';
																}
															?>
														   </td>
														   </tr>
                                                           <tr>
																<td colspan="5" style="text-align:center;">
                                                                <ul class="pager wizard">
                                                                <button type="submit" name="btnSubmitExperience" class="btn btn-success" style="outline:none;">Submit</button>        
             		<?php
					prevnext(4);
					?>
                    </ul>
																</td>
															</tr>
														</table>
													</form>
													
												</div>
											</div>
									</div>
								</div>
							</div>
					    </div>
						<div class="tab-pane" id="tab4">
                         <br/>				
											<div class="row">
								<div class="col-md-12">
									<div class="panel panel-success">
											<div class="panel-heading">
												<label class="control-label">Upload Images</label>
											</div>       
											<div class="panel-body"> 
												<div class="table-responsive">
													<form method="post" id="commentForm" enctype="multipart/form-data">
														<table class='table table-striped table-bordered'>
															<tr>
															<td colspan="4" style="font-weight:bold;color:#02A67D; font-size:16px; text-align:center;"><label class="control-label">UPLOAD IMAGES & DOCUMENTS</label></td>
															</tr>
															<tr>
															<td style="text-align:left;font-size:14px;width:20%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">* </font> Photograph :</label></td>
															<td style="text-align:left;font-size:14px;width:20%">
															<span class="btn btn-success btn-file" style="margin-top:30px;">
																<input type="file" name="file_1" onchange="validateFileType('file_1',this,'photo');" id="file_1" accept=".jpg, .jpeg">
															</span>
															</td>
															<td>
															<img  style="width:150px;height:120px" id="photo" src="assets/img/0000.jpg" alt="your image" />
															</td>
															</tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">* </font> Signature :</label></td>
																<td style="text-align:left;font-size:14px;width:20%">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_2" onchange="validateFileType('file_2',this,'sign');" id="file_2" accept=".jpg, .jpeg">
																</span>
																</td>																
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px" id="sign" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">* </font> Essential Educational Certificates :</label></td>
																<td style="text-align:left;font-size:14px;width:20%">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_3"  onchange="validateFileType('file_3',this,'essential');" id="file_3" accept=".jpg, .jpeg">
																</span>
																</td>
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px"  id="essential" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label"> Additional Educational Certificates :</label></td>
																<td style="text-align:left;font-size:14px;width:20%;">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_4" onchange="validateFileType('file_4',this,'additional');" id="file_4" accept=".jpg, .jpeg">					
																</span>
																</td>
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px" id="additional" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">* </font> Local Residential Certificates :</label></td>
																<td style="text-align:left;font-size:14px;width:20%;">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_5" onchange="validateFileType('file_5',this,'local');" id="file_5" accept=".jpg, .jpeg">					
																</span>
																</td>
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px" id="local" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">* </font> Identity Document Certificates :</label></td>
																<td style="text-align:left;font-size:14px;width:20%;">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_6" onchange="validateFileType('file_6',this,'identity');" id="file_6" accept=".jpg, .jpeg">					
																</span>
																</td>
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px" id="identity" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">Caste Certificates :</label></td>
																<td style="text-align:left;font-size:14px;width:20%;">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_7" onchange="validateFileType('file_7',this,'caste');" id="file_7" accept=".jpg, .jpeg">					
																</span>
																</td>
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px" id="caste" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td style="text-align:left;font-size:14px;width:20%"><label class="control-label">Other Certificates :</label></td>
																<td style="text-align:left;font-size:14px;width:20%;">
																<span class="btn btn-success btn-file" style="margin-top:30px;">
																	<input type="file" name="file_8" onchange="validateFileType('file_8',this,'other');" id="file_8" accept=".jpg, .jpeg">					
																</span>
																</td>
																<td style="text-align:left;font-size:14px;width:20%">
																<img  style="width:150px;height:120px" id="other" src="assets/img/0000.jpg" alt="your image" />
																</td>
														   </tr>
														   <tr>
																<td colspan="3">
																<div class="checkbox-inline" style="font-size:16px; color:#02A67D;">
																<input type="checkbox" name="declaration" value="1" required>I hereby declare that all the statement information furnished & papers attached are true to best of my knowledge and belief. I have not been prosecuted or punished by any Court of law for any offence or involved/named/charge sheeted in any criminal or like case. If any of the information furnished by the undersigned is formed to be false, my candidature be deemed void and be appropriately penalized.
																</div>
																</td>
															</tr>
														   <tr>
																<td colspan="3">
																 <?php
																	//If Error Occurs.
																	if(isset($msg)){
																		echo '<font color="#ed3b55" ><b>'.$msg.'</b></font>';
																	}
																	?>
																</td>
														   </tr>
                                                           <tr>
																<td colspan="5" style="text-align:center;">
                                                                <ul class="pager wizard">
                                                                <button type="submit" name="btnFinalSubmit" class="btn btn-danger" style="outline:none;">Final Submit</button>
                                                                
             <?php
					$value=findstatus();
					if($value>=4)
					{                                                  
					echo '<li class="previous"><img src="assets/img/prevbtn.png" align="left" style="width:120px; height:35px" class="button button2"></li>';
					}
					?>
                    </ul>
																</td>
															</tr>
														</table>
													</form>
													<div style="color:#D61A14">
														Note:<br/>					
														(i) Each image size must be less than 150kb. <br/>
														(ii) Upload files in Jpeg / Jpg format only. <br/>
														(iii) * Are Required Images. <br/>
														(iv) Please check your given details before Final Submit, Because after final submit, you won't make any changes. <br/>
													</div>
												</div>
											</div>
									</div>
								</div>
							</div>
					    </div>
						<div class="tab-pane" id="tab5">
                        5.
					    </div>
						
					</div>
				</div>
			</section>
	</div>
<?php  
include_once('php/footer.php'); /*Footer Section Include Here*/
?>