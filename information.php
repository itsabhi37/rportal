<?php
session_start();
require_once("php/class.user.php"); /*Database Connection Include Here*/
require_once('php/header.php'); /*Header Section Include Here*/
if(!isset($_SESSION['userid']))
{
	header("Location: registration.php");
}
			$applicantid=$_SESSION['userid'];
			$password=$_SESSION['userpassword'];
?>
<?php
if(isset($_POST['btnClose']))
{
	session_destroy();
	unset($_SESSION['userid']);
	unset($_SESSION['userpassword']);
	?>
			<script type="text/javascript">
			window.location.href = "registration.php";
			</script>
			<?php
} 
?>
	<br/>
    <div class='container'>		
			    <div class="panel panel-success">
									<div class="panel-heading">
									 <label class="control-label">Login Information</label>
									</div>       
									<div class="panel-body"> 
										<div class="table-responsive">
                                        <form method="post" id="info">
												<table class='table table-striped table-bordered'>												
												<tr>
												<td colspan="2" style="font-weight:bold; color:#02A67D; font-size:17px;text-align:center;">Please note down this information for further use this Application ID & Password is Mandatory for login.</td>
												</tr>
												<tr>
													<td style="text-align:right; font-weight:bold; font-size:16px; width:50%">Application ID :</td>
													<td style="text-align:left; font-weight:bold; font-size:16px;"><?php 
														echo $applicantid;
													?></td>
											   </tr>
											   <tr>
													<td style="text-align:right; font-weight:bold; font-size:16px;width:50%">Password :</td>
													<td style="text-align:left; font-weight:bold; font-size:16px;"><?php 
													echo $password;
													?></td>
											   </tr>
											   <tr>
												<td colspan="2" style="font-weight:bold; font-size:17px;text-align:center;"><button type="submit" class="btn btn-danger" style="outline:none;" name="btnClose">
													Close
													</button>
												</td>
												</tr>
												</table>
												
											
                                            </form>										
										
										</div>
									</div>
				</div>
	</div>
				
<?php  
include_once('php/footer.php'); /*Footer Section Include Here*/
?>