<?php
//Include Commnon Header Part
require_once("php/header.php");
require_once("php/session.php");	
require_once("php/class.user.php");
$auth_user = new USER();
$admindist=$_SESSION['admin_dist'];
	//This page Only For Admin's & Super Admin
	if($_SESSION['admin_type']!="Super Admin"&&$_SESSION['admin_type']!="Admin")
	{
		$session->redirect('index.php');
	}
		
?>
<?php
	
	if(isset($_POST['btnSubmit'])) /* if press submit button in Add new mode then this part will work.*/
	{		
		
		/* Checking in both mode(Add New / Edit), whether the fields are properly filled or not.*/
		$RecruitmentId = $_POST['cmbRecruitmentId'];		
		$RecruitmentId = trim($RecruitmentId);	
		
		if($RecruitmentId!=0)
		{		
			$PostId = $_POST['cmbpost'];		
			$PostId = trim($PostId);	
			
			$ExamSlotName = $_POST['txtExamSlotName'];		
			$ExamSlotName = trim($ExamSlotName);	
			
			$CenterName = $_POST['txtCenterName'];		
			$CenterName = trim($CenterName);	
			
			$ExamDate = $_POST['txtExamDate'];		
			$ExamDate = trim($ExamDate);
			$ExamDate = date("Y-m-d", strtotime($ExamDate)); //yy-mm-dd
			
			$ReportingTime = $_POST['txtReportingTime'];		
			$ReportingTime = trim($ReportingTime);

			$StartTime = $_POST['txtStartTime'];		
			$StartTime = trim($StartTime);
			
			$Duration = $_POST['txtDuration'];		
			$Duration = trim($Duration);
					
			if(isset($_GET['id'])) /* if press submit button in Edit mode then this part will work.*/
			{
				/* In edit mode run update command*/
					$examid=$_GET['id'];
					$stmt = $auth_user->runQuery("UPDATE masterexam SET recruitmentid=:rid,postid=:postid,examslotname=:slotname,centername=:centername,examdate=:examdate,reportingtime=:rtime,starttime=:stime,duration=:duration WHERE id=:examid");
					$stmt->execute(array(":rid"=>$RecruitmentId,":postid"=>$PostId,":slotname"=>$ExamSlotName,":centername"=>$CenterName,":examdate"=>$ExamDate,":rtime"=>$ReportingTime,":stime"=>$StartTime,":duration"=>$Duration,":examid"=>$examid));				
					?>
					<script type="text/javascript">
					alert("Examination Details Updated Successfully...!");
					window.location.href = "admin-exam.php";
					</script>
					<?php			
			}
			else
			{
				/* In Add New mode run insert command*/
					$stmt = $auth_user->runQuery("INSERT into masterexam (id,recruitmentid,postid,examslotname,centername,examdate,reportingtime,starttime,duration)values(:exam_id,:rid,:postid,:slotname,:centername,:examdate,:rtime,:stime,:duration)");
					$stmt->execute(array(":exam_id"=>$exid,":rid"=>$RecruitmentId,":postid"=>$PostId,":slotname"=>$ExamSlotName,":centername"=>$CenterName,":examdate"=>$ExamDate,":rtime"=>$ReportingTime,":stime"=>$StartTime,":duration"=>$Duration));
			?>
			<script type="text/javascript">
			alert("Examination Details Added Successfully...!");
			window.location.href = "admin-exam.php";
			</script>
			<?php					
			}
		}
		else
		{		
			?>
			<script type="text/javascript">
			alert('Please Select Recruitment');
			</script>
			<?php
		}
	}
?>

                <?php
		//Include Admin Menu Part
		include_once "php/adminmenu.php";
		?>
        </div>
    </div>
	</header>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line"><span class="fa fa-upload"></span> Upload Data</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" >                                           
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">                                
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="fa fa-upload"></span> Uplaod Excel Data</a>
                                </li>                                
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade" id="add" style="margin-left:15px;margin-right:15px;">								
									<br/>
                                    <form role="form" method="post" id="uploaddata">
										<!--Form for Accept Input !-->
										<!--START !-->											
										<table class="table table-bordered">										
										<tbody>										
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Recruitment Name</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<select id="recruitment" name="cmbRecruitmentId" class="selectpicker" data-live-search="true" title="Please Select Recruitment" onChange="getPost(this.value);">
												<?php
													if($admindist!=0)
													{
														// District Admin Login
														$DistQury="SELECT id,name FROM masterrecruitment WHERE distid=$admindist ORDER BY name";
													}
													else{
														//Super Admin Login
														$DistQury="SELECT id,name FROM masterrecruitment ORDER BY name";
													}
													$stmt = $auth_user->runQuery($DistQury);// Run your query		
													$stmt->execute();
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														// If in edit mode
														if($frecid==$userRow['id'])
														{
															$selected = 'selected="selected"';
														}
														else{
															$selected = '';
														}
														echo '<option value="'.$userRow['id'].'" '.$selected.'>'.$userRow['name'].'</option>';	
													}													
												?> 										
											</select>
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
													<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Post Name</td>
													<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
													<select id="cmbpost" name="cmbpost" class="form-control" required>
																					
													</select>
													</td>								
													<td width="30%" align="right" style="border-color:transparent;"></td>	
													
										</tr>										
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Upload Excel</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input id="FilUploader" type="file" class="form-control" name="txtUploadExcel" required/></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="glyphicon glyphicon-upload"></span> Upload Data </button>
											
											<!--Cancel Button !-->
											<a href="admin-sampleupload.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;">
											
											</td>
										</tr>	
										</tbody>
										</table>	
										<!--END !-->										
									</form>
                                </div> 
								<!--END !-->								
                            </div>
                        </div>                    
                </div>
				
            </div>          
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
<?php
include_once "php/footer.php";
?>
<script>    
		 $(document).ready(function(){			
			$('.nav-tabs a[href="#add"]').tab('show');
		});
</script>

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
</script>

<script type="text/javascript">
$("#FilUploader").change(function () {
        var fileExtension = ['xls', 'xlsx'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            document.getElementById("FilUploader").value = null;
            alert("Only formats are allowed : "+fileExtension.join(', '));
        }
    });
</script>