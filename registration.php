<?php
session_start();
require_once("php/header.php");
require_once("php/class.user.php");
$auth_user = new USER();
if($auth_user->is_loggedin()!="")
{
	$auth_user->redirect('form.php');
}
?>
<?php

		$stmt = $auth_user->runQuery("SELECT MAX(applicantid) applicantid FROM registrationdetails");
		$stmt->execute();
		$count = $stmt->rowCount();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if($count== 1)
		{
			if($userRow['applicantid']=="")
			{
				$year= date("Y");
				$applicantid= $year.'1001';	
			}
			else 
			{
				$applicantid=$userRow['applicantid']+1;	
			}
		}

	if(isset($_POST['btnRegister'])) /* if press submit button in Add new mode then this part will work.*/
	{		
		$_SESSION['sappname'] = $_POST['txtApplicantName'];
		$_SESSION['sdob'] = $_POST['txtdob'];
		$_SESSION['smob'] = $_POST['txtMobile'];
		$_SESSION['semail'] = $_POST['txtEmail'];
		
		$RecruitmentId = $_POST['cmbRecruitmentId'];		
		$RecruitmentId = trim($RecruitmentId);
		if($RecruitmentId!=0)
		{
		$postname = $_POST['cmbpost'];		
		$postname = trim($postname);
		}
		$applicantName = $_POST['txtApplicantName'];		
		$applicantName = trim($applicantName);
		
		$dob = $_POST['txtdob'];		
		$dob = trim($dob);
		
		$fdob = date("Y-m-d", strtotime($dob));
		
		$mobile = $_POST['txtMobile'];		
		$mobile = trim($mobile);
		
		$email = $_POST['txtEmail'];		
		$email = trim($email);
		
		$status=1;
		
		$stmt = $auth_user->runQuery("SELECT ageondate FROM masterrecruitment WHERE id='$RecruitmentId'");
		$stmt->execute();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		$ondate=$userRow['ageondate'];
		$Password=str_replace("-","",$dob);//ddmmyyyy
			// Calculating Age on certain Date.
			$CheckAge=$fdob;
			$CheckAge=new DateTime($CheckAge);
			if(!empty($CheckAge))
			{
			$certaindate=new DateTime($ondate);
			$age=$certaindate->diff($CheckAge);
			$age= $age->y.' Year, '.$age->m.' Month, '.$age->d.' Day';
			}
		
		if($RecruitmentId==0)
		{
		?>
		<script type="text/javascript">
		alert('Please Select Recruitment');
		</script>
		<?php
		}
		else if($postname==0)
		{
		?>
		<script type="text/javascript">
		alert('Please Select Post Name');
		</script>
		<?php
		}		
		else if($applicantName=="--Select--")
		{	
			?>
			<script type="text/javascript">
			alert("Please fill Applicant Name.");
			</script>
			<?php
		}
		else if($dob=="")
		{
			?>
			<script type="text/javascript">
			alert("You Can't left blank Date of Birth.");
			</script>
			<?php
		}	
		else if(strlen($mobile)<10)
		{	
			?>
			<script type="text/javascript">
			alert("Please enter valid 10 Digit Mobile Number.");
			</script>
			<?php
		}
		else if($email=="")
		{	
			?>
			<script type="text/javascript">
			alert("You Can't left blank Email field.");
			</script>
			<?php
		}
		else
		{
			$stmt = $auth_user->runQuery("INSERT into registrationdetails (applicantid,recruitmentid,postid,applicantname,dob,ageondate,	mobileno,email,status)values(:applicantid,:recruitmentid,:postid,:applicantname,:dob,:ageondate,:mobileno,:email,:status)");
			$stmt->execute(array(":applicantid"=>$applicantid,":recruitmentid"=>$RecruitmentId,":postid"=>$postname,":applicantname"=>$applicantName,":dob"=>$fdob,":ageondate"=>$age,":mobileno"=>$mobile,":email"=>$email,":status"=>$status));
				
			$new_password = sha1($Password);			
			
			$stmt = $auth_user->runQuery("INSERT into applicantlogin (userid,password)values(:userid,:password)");
			$stmt->execute(array(":userid"=>$applicantid,":password"=>$new_password));
			
			$_SESSION['userid']=$applicantid;
			$_SESSION['userpassword'] = $Password;
			
			// Send Login Credentials on Given Email id
			/* $to = $email;
			$subject = "Login Credentials";
			$txt = "Registration Successfully Completed. Please note down this information for further use, This Application ID & Password is Mandatory for login. Application Id: '$applicantid' and Password: '$Password'";
			$headers = "From: dhn.nic@gmail.com" . "\r\n";
			mail($to,$subject,$txt,$headers); */
			
			?>
			<script type="text/javascript">
			alert("Registration Successfully Done...!!!");
			window.location.href = "information.php";
			</script>
			<?php			
		}
	}
	
?>
<?php
if(isset($_POST['btnlogin']))
{
	$ApplicantId = $_POST['txtApplicantId'];
	$ApplicantId = trim($ApplicantId);
	
	$Password = $_POST['txtPassword'];
	$Password = trim($Password);
	
	if($ApplicantId=="")	{
		$error = "Please provide Applicant Id !";	
	}
	else if($Password=="")	{
		$error = "Please provide Password!";	
	}
	else{
	
		if($auth_user->doLogin($ApplicantId,$Password))
		{
			$auth_user->redirect('form.php');
		}
		else
		{
			$error = "Incorrect Login Credentials, Please try again !";
		}	
	}
}
?>
<script>
/*function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;

        return true;
} */   

var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }

</script>
	<br/>
    <div class='container'>		
			<section id="wizard">

				<div id="rootwizard">
					<ul>
					  	<li ><a href="#tab1" data-toggle="tab" class="disabled"><span class="label">1</span> Registration / Login</a></li>
						<li><a href="#tab2" data-toggle="tab" class="disabled"><span class="label">2</span> Personal Details</a></li>
						<li><a href="#tab3" data-toggle="tab" class="disabled"><span class="label">3</span> Educational Details</a></li>
						<li><a href="#tab4" data-toggle="tab" class="disabled"><span class="label">4</span> Experience Details</a></li>
						<li><a href="#tab5" data-toggle="tab" class="disabled"><span class="label">5</span> Upload Images</a></li>
						<li><a href="#tab6" data-toggle="tab" class="disabled"><span class="label">6</span> Print Application</a></li>
					</ul>
					<div class="tab-content">
					    <div class="tab-pane" id="tab1">
						<br/>
												 <div class="row">
             
             
            <div class="col-md-5">
               <div>
                  		<div class="panel panel-success">
									<div class="panel-heading">
									 <label class="control-label"><span class="fa fa-sign-in"></span> Login</label>
									</div>       
									<div class="panel-body"> 
										<div class="table-responsive">
										<form method="POST" id="login">
											<table class='table table-striped table-bordered'>
												<tr>
												<td colspan="2" style="font-weight:bold;color:#02A67D;font-size:16px; text-align:center;"><label class="control-label">LOGIN</label></td>
												</tr>
											   <tr>
													<td style="text-align:right;color:#02A67D;font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Applicant Id :</label></td>
													<td>
													<input type="text" name="txtApplicantId" class="form-control" required>
													</td>
											   </tr>
											   <tr>
													<td style="text-align:right;color:#02A67D; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Password :</label></td>
													<td>
													<input type="password" name="txtPassword" class="form-control" required>
													</td>
											   </tr>											   
												<tr>
													<td colspan="2" style="font-weight:bold; font-size:16px; text-align:center;">
													<button type="submit" name="btnlogin" class="btn btn-success" style="outline:none;"><span class="fa fa-sign-in"></span> Login</button>
													<!--Error Message Section !-->
													<!--START !-->
													<div id="msg" style="color:#F00; text-align:center;">
														<?php
																if(isset($error) && $error!="")
																{
																	echo $error;
																}
														?>
													</div>
													<!--END !-->
													</td>
												</tr>
											</table>
										</form>
										<div style="color:#D61A14">
														Note:<br/>					
														(i) * are Required fields. <br/>
													</div>
										</div>
									</div>
				</div>
               </div>
            </div>
			<div class="col-md-7">
               <div>
                  		<div class="panel panel-success">
									<div class="panel-heading">
									 <label class="control-label"><span class="fa fa-user"></span> Registration </label>
									</div>       									
									<div class="panel-body"> 
										<div class="table-responsive">
                                        <form method="post">
											<table class='table table-striped table-bordered'>
												<tr>
												<td colspan="2" style="font-weight:bold;color:#D61A14; font-size:16px; text-align:center;"><label class="control-label">REGISTRATION</label></td>
												</tr>
												<tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Recruitment Name :</label></td>
													<td>
													
													<select id="recruitment" name="cmbRecruitmentId" class="selectpicker" data-live-search="true" title="Please Select Recruitment" onChange="getPost(this.value);getDistName(this.value);" required>
													<?php
													$stmt = $auth_user->runQuery("SELECT id,name,startdate,enddate FROM masterrecruitment ORDER BY name");// Run your query	
													$stmt->execute();
													
													// Loop through the query results, outputing the options one by one
														
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$vaccurrent_date=date('Y/m/d');	
														$startdate=date($userRow['startdate']);														
														$enddate=date($userRow['enddate']);
														if(strtotime($vaccurrent_date)<=strtotime($enddate)&&strtotime($vaccurrent_date)>=strtotime($startdate))
														{														
															echo '<option value="'.$userRow['id'].'">'.$userRow['name'].'</option>';	
														}													
													}													
													?>
													</select>
													</td>
											   </tr>
											   <tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Post Applied For :</label></td>
													<td>
													<select id="cmbpost" name="cmbpost" class="form-control" required>
																					
													</select>
													</td>
											   </tr>
											    <tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Applied For :</label></td>
													<td id="txtDistFor">
													
													</td>
											   </tr>
											
											   <tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Applicant Name :</label></td>
													<td>
													<input type="text" name="txtApplicantName" value="<?php if(isset($_SESSION['sappname'])){echo $_SESSION['sappname'];}?>" class="form-control" required>
													</td>
											   </tr>
											   <tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Date Of Birth :</label></td>
													<td>
													<input type="text" name="txtdob" class="cal form-control" value="<?php if(isset($_SESSION['sdob'])){echo $_SESSION['sdob'];}?>" style="background-color:#FFF;" required readonly>
													</td>
											   </tr>
											   <tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Mobile No. :</label></td>
													<td>
													<input type="text" name="txtMobile" class="form-control" id="text1" value="<?php if(isset($_SESSION['smob'])){echo $_SESSION['smob'];}?>" onkeypress="return IsNumeric(event);" onpaste="return false;" ondrop = "return false;" maxlength="10" required />
<span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
													</td>
											   </tr>
											   <tr>
													<td style="text-align:right;color:#D61A14; font-size:14px;width:40%"><label class="control-label"><font style="font-weight:bold; color:red; font-size:14px;">*</font> Email Id :</label></td>
													<td>
													<input type="Email" name="txtEmail" value="<?php if(isset($_SESSION['semail'])){echo $_SESSION['semail'];}?>" class="form-control" required>
													</td>
											   </tr>
												<tr>
													<td colspan="2" style="font-weight:bold; font-size:16px; text-align:center;">
													<button type="submit" name="btnRegister" class="btn btn-danger" style="outline:none;"><span class="fa fa-user"></span> Register</button>
													</td>
												</tr>
											</table>
                                            </form>
											<div style="color:#D61A14">
														Note:<br/>					
														(i) * are Required fields. <br/>
													</div>
										</div>
										</div>
									</div>
				</div>
               </div>
            </div>
        </div> 
		
					
					    </div>
					    <div class="tab-pane" id="tab2">
					    </div>
						<div class="tab-pane" id="tab3">
					    </div>
						<div class="tab-pane" id="tab4">
					    </div>
						<div class="tab-pane" id="tab5">
					    </div>
						<div class="tab-pane" id="tab6">
					    </div>
						<div class="tab-pane" id="tab7">
					    </div>
						<!--<ul class="pager wizard">
							<li class="previous first" style="display:none;"><a href="#">First</a></li>
							<li class="previous"><a href="#">Previous</a></li>
							<li class="next last" style="display:none;"><a href="#">Last</a></li>
						  	<li class="next"><a href="#">Next</a></li>
						</ul>-->
					</div>
				</div>
			</section>
	</div>
<?php  
include_once('php/footer.php'); /*Footer Section Include Here*/
?>
<script type="text/javascript">

function getPost(val) {
	$.ajax({
	type: "POST",
	url: "postfinder.php",
	data:'rect_id='+val,
	success: function(data){
		$("#cmbpost").html(data);
	}
	});
}
function getDistName(val) {
	$.ajax({
	type: "POST",
	url: "distfinder.php",
	data:'rect_id='+val,
	success: function(data){
		$("#txtDistFor").html(data);
	}
	});
}
</script>
