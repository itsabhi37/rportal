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
	/* If Edit button choose then this part will be run. */
	if(isset($_GET['id']))
	{
		$examid=$_GET['id'];	
		
		$stmt = $auth_user->runQuery("SELECT * FROM masterexam WHERE id=:examid");
		$stmt->execute(array(":examid"=>$examid));
		while ($postRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$frecid = $postRow['recruitmentid'];
			$fpostname = $postRow['postid'];
			$fexamslotname = $postRow['examslotname'];
			$fcentername = $postRow['centername'];
			$fexamdate = date("d-m-Y", strtotime($postRow['examdate']));//dd-mm-yyyy		
			$freportingtime = $postRow['reportingtime'];
			$fstarttime = $postRow['starttime'];
			$fduration = $postRow['duration'];
		}
	}
	else /* If new, then this part will be run. */
	{
		$stmt = $auth_user->runQuery("SELECT MAX(id) id FROM masterexam");
		$stmt->execute();
		$count = $stmt->rowCount();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if($count== 1)
		{
			if($userRow['id']=="")
			{
				$exid=1;	
			}
			else 
			{
				$exid=$userRow['id']+1;	
			}
		}
	}
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
                    <h4 class="page-head-line"><span class="fa fa-graduation-cap"></span> Master Exam</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" >                                           
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> Exam Details List</a>
                                </li>
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="<?php if(isset($_GET['id'])){echo 'fa fa-edit';} else {echo 'fa fa-plus';}?>"></span><?php if(isset($_GET['id'])){echo ' Edit Exam Details';} else {echo ' Add Exam Details';}?> </a>
                                </li>                                
                            </ul>

                            <div class="tab-content">
								<!--Edit New Section-->
								<!--START !-->
                                <div class="tab-pane fade active in" id="list" style="margin-left:15px;margin-right:15px;">
									<br/>
                                    <form role="form" method="post">
										<!--Form for Edit / View Details !-->
										<!--START !-->
										<div class="tile">
										<div class="tile-body">
											<table class="table table-hover table-striped table-bordered" id="sampleTable">		
											<thead>
											<tr>
														<th>#</th>
														<th>Recruitment Name</th>
														<th>Post Name</th>
														<th>Exam Slot Name</th>
														<th>Center Details</th>
														<th>Exam Date</th>
														<th>Reporting Time</th>
														<th>Exam Start Time</th>
														<th>Duration</th>
														<th>Options</th>
													</tr>
											</thead>											
												<tbody>
													<?php
													if($admindist!=0)
													{
														// District Admin Login
														$Qury="SELECT me.id,mr.name as recruitmentname, mp.name as postname,me.examslotname,me.centername,me.examdate,me.reportingtime,me.starttime,me.duration FROM masterrecruitment mr,masterpost mp,masterexam me WHERE me.recruitmentid=mr.id AND me.postid=mp.id AND mr.distid=$admindist";
													}
													else{
														//Super Admin Login
														$Qury="SELECT me.id,mr.name as recruitmentname, mp.name as postname,me.examslotname,me.centername,me.examdate,me.reportingtime,me.starttime,me.duration FROM masterrecruitment mr,masterpost mp,masterexam me WHERE me.recruitmentid=mr.id AND me.postid=mp.id";
													} 
													$stmt = $auth_user->runQuery($Qury);
													$stmt->execute();
													$num_rows = 0;
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$num_rows++;
														$vexamid =$userRow['id'];
														$vrecruitmentname = $userRow['recruitmentname'];
														$vpostname = $userRow['postname'];	
														$vexamslotname = $userRow['examslotname'];
														$vcentername = $userRow['centername'];	
														$vexamdate = date("d-m-Y", strtotime($userRow['examdate']));//dd-mm-yyyy		
														$vreportingtime = $userRow['reportingtime'];	
														$vstarttime = $userRow['starttime'];	
														$vduration = $userRow['duration'];
													?>
													<tr>	
														<td><?php echo $num_rows; ?></td>
                                                        <td><?php echo $vrecruitmentname; ?></td>
                                                        <td><?php echo $vpostname; ?></td>
														<td><?php echo $vexamslotname; ?></td>
                                                        <td><?php $vcentername = str_replace(array("\\r","\\n"), array("\r","\n"), $vcentername); echo $vcentername; ?></td>
														<td><?php echo $vexamdate; ?></td>
                                                        <td><?php $vreportingtime=date("g:i a",strtotime($vreportingtime)); echo $vreportingtime; ?></td>
														<td><?php $vstarttime=date("g:i a",strtotime($vstarttime)); echo $vstarttime;?></td>
                                                        <td><?php echo $vduration; ?></td>
														<td align="center">
														<!--Edit Button !-->
														<a href="admin-exam.php?id=<?php echo $vexamid;?>" style="outline:none;" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-wrench changetabbutton" ></span> &nbsp;Edit</a>
														<!--Delete Button !-->
														<a href="#" data-href="delete.php?del_exam_id=<?php echo $vexamid;?>"  style="outline:none;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span> &nbsp;Delete
														</a>
														</td>
													</tr>   
                                                                                                    
													<?php
													}
													
													echo "</tbody>";
													echo "</table>";
													?> 		
												
										</div>	
										</div>
										<!--END !-->										
									</form>
								</div>
								<!--END !-->
								
								<!--Add New Section-->
								<!--START !-->
                                <div class="tab-pane fade" id="add" style="margin-left:15px;margin-right:15px;">								
									<br/>
                                    <form role="form" method="post">
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
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Exam Slot Name</td>						
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="text" class="form-control" name="txtExamSlotName" value="<?php if(isset($_GET['id'])){echo $fexamslotname;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Center Name & Address</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<textarea class="form-control" name="txtCenterName" required><?php 
											if(isset($_GET['id'])){	
												$fcentername = str_replace(array("\\r","\\n"), array("\r","\n"), $fcentername);
												echo $fcentername ;
											}
											?></textarea></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Exam Date</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="text" class="cal form-control" name="txtExamDate" value="<?php if(isset($_GET['id'])){echo $fexamdate ;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Exam Reporting Time</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="time" class="form-control" name="txtReportingTime" value="<?php if(isset($_GET['id'])){echo $freportingtime ;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Exam Start Time</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="time" class="form-control" name="txtStartTime" value="<?php if(isset($_GET['id'])){echo $fstarttime ;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Duration</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="text" class="form-control" name="txtDuration" value="<?php if(isset($_GET['id'])){echo $fduration ;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="<?php if(isset($_GET['id'])){echo 'glyphicon glyphicon-edit';} else {echo 'glyphicon glyphicon-plus';}?>"></span> &nbsp;<?php if(isset($_GET['id'])){echo 'Edit Details';} else {echo 'Add Details';}?></button>
											
											<!--Cancel Button !-->
											<a href="admin-exam.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
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
				
					<!-- Delete Modals-->                   
                            
                         <?php 
						 include_once "php/deletemodal.php";
						 ?> 
                        
                     <!-- End Delete Modals-->
				
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
			//window.location.href = 'admin-recruitment.php?id='+id;
		});
</script>

<!-- Code For Delete Data With the help of modal-->
<script>
        $('#myModal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));            
            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
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