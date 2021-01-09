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
			// Recruitment is going on
			if($status!=5)
			{
			header("Location: form.php");
			}
		}	
		else{
			//Recruitment Date Closed
			header("Location: userdashboard.php");
		}
	}													
?>
<?php
		if(isset($_SESSION['paymentmode'])&&$_SESSION['paymentmode']!=0)
		{
		header("Location: userdashboard.php");
		}
?>
<?php
		$ddraft = $auth_user->runQuery("SELECT * FROM draftdetails WHERE applicantid=$applicantid");// Run your query	
		$ddraft->execute();
		$count = $ddraft->rowCount();
		$ddRow = $ddraft->fetch(PDO::FETCH_ASSOC);
		
		if($count== 1)
		{
			header("Location: userdashboard.php");				
		}
?>
<?php
	
	function uploadPhoto() {
	$auth_user = new USER();
	$msg="";
    $maxsize = 307200; //set to approx 300 KB

    //check associated error code
    if($_FILES['dd_upload']['error']==UPLOAD_ERR_OK) {

        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['dd_upload']['tmp_name'])) {    

            //checks size of uploaded image on server side
            if( $_FILES['dd_upload']['size'] < $maxsize) {  
  
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($finfo, $_FILES['dd_upload']['tmp_name']),"image")===0) {    

                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($_FILES['dd_upload']['tmp_name']));
                    // our sql query
					
					$appid=$_SESSION['applicantid'];
					
					$BankName = $_POST['txtBankName'];		
					$BankName = trim($BankName);
					
					$DDAmount = $_POST['txtDDAmount'];		
					$DDAmount = trim($DDAmount);
					
					$DDNo = $_POST['txtDDNo'];		
					$DDNo = trim($DDNo);
					
					$DDate = $_POST['txtDDDate'];		
					$DDate = trim($DDate);
					$DDDate = date("Y-m-d", strtotime($DDate)); //yy-mm-dd
										
					//Insert Data 
						$stmt = $auth_user->runQuery("INSERT into draftdetails (applicantid,bankname,ddamount,ddnumber,dddate,attachment)values('$appid','$BankName','$DDAmount','$DDNo','$DDDate','$imgData')");
						$stmt->execute();
						?>
						<script type="text/javascript">
						alert("Draft Details Inserted  Successfully!");
						window.location.href = "userdashboard.php";
						</script>
						<?php			
                }
                else
					echo "<script>alert('Uploaded file is not an image.')</script>";
            }
             else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['dd_upload']['name'].' is '.$_FILES['userfile']['size'].
                ' bytes</div><hr />';
                }
        }
        else
			echo "<script>alert('File not uploaded successfully.')</script>";

    }
    else {
        $msg= file_upload_error_message($_FILES['dd_upload']['error']);
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
	
	if(isset($_POST['btnSubmit']))
	{
			if(!isset($_FILES['dd_upload']))
			{
				echo "<script>alert('Please Upload jpg Or jpeg Image Only.')</script>";
			}
			else
			{
				try {					
				$msg= uploadPhoto();  //this will upload your image
				//echo $msg;  //Message showing success or failure.
				}
				catch(Exception $e) {
				echo $e->getMessage();
				echo "<script>alert('Sorry, could not upload file')</script>";
				echo '';
				}
			}
	}
	
?>
				<br/>
				<div class="col-lg-3">
                    		<div class="list-group">
                        	<a href="#" class="list-group-item active">Quick Links </a>
                            <a href="userdashboard.php" class="list-group-item">Application Status</a>
                        	<a href="printapplication.php" class="list-group-item">Print Application</a>                            
                        	<a href="#" class="list-group-item">Check Your Result</a>
							<a href="#" class="list-group-item">Change Password</a>
                            <a href="logout.php?logout=true" class="label label-danger">Logout</a>
                   			</div>
				</div>
				
				<div class="col-lg-9">
							<div class="panel panel-primary">
									<div class="panel-heading">
									 <label class="control-label">Draft Details</label>
									</div>       
									<div class="panel-body"> 
										<div class="table-responsive">
										<form method="POST" enctype="multipart/form-data">
											<table class="table table-bordered">
										<tbody>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Application Id :</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" name="txtApplicationId" class="form-control" value="<?php echo $applicantid;?>" disabled>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Bank Name :</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" name="txtBankName" class="form-control" required>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;"> DD Amount :</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" name="txtDDAmount" id="txtDDAmount" class="form-control" onkeypress="return IsNumeric(event,'ddamterror');" onpaste="return false;" ondrop = "return false;" required>
											<span id="ddamterror" style="color: Red; display: none">* Input digits (0 - 9)</span>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>	
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;"> DD Number :</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" name="txtDDNo" id="txtDDNo" class="form-control" onkeypress="return IsNumeric(event,'ddnoerror');" onpaste="return false;" ondrop = "return false;" required>
											<span id="ddnoerror" style="color: Red; display: none">* Input digits (0 - 9)</span>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>	
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;"> DD Date :</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" name="txtDDDate" class="cal form-control" required>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;"> Upload DD Image :</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="file" name="dd_upload" id="dd_upload" class="form-control" required>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>
										<?php	
												//Edit Mode Preview Section
												if(isset($msg)){
													echo '<font color="#ed3b55" ><b>'.$msg.'</b></font>';
												}												
											?>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">

											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="glyphicon glyphicon-plus"></span> Save Details</button>

											<!--Cancel Button !-->
											<a href="userdashboard.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>

											</td>
                                            <td width="30%" align="right" style="border-color:transparent;">

											</td>
										</tr>
											</table>
										</form>
										</div>
									</div>
							</div>
				</div>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
</br></br>
<?php
require_once("php/footer.php"); /*Header Section Include Here*/
?>
<script>
var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e,spanname) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById(spanname).style.display = ret ? "none" : "inline";
            return ret;
        }
</script>