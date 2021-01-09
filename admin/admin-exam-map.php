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
                    <h4 class="page-head-line"><span class="fa fa-exchange"></span> Applicant Exam Mapper</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" > 
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> Application List</a>
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
										<div class="table-responsive">
											<table class="table">												
												<tbody>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Recruitment Name</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<select id="recruitment" name="cmbRecruitmentId" class="selectpicker" data-live-search="true" title="Please Select Recruitment"  onChange="getPost(this.value);">
												<?php
												if($admindist!=0)
												{
													$stmt = $auth_user->runQuery("SELECT id,name FROM masterrecruitment WHERE distid='$admindist' ORDER BY name");// Run your query		
													$stmt->execute();
												}
												else
												{
													$stmt = $auth_user->runQuery("SELECT id,name FROM masterrecruitment ORDER BY name");// Run your query		
													$stmt->execute();	
												}
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														echo '<option value="'.$userRow['id'].'">'.$userRow['name'].'</option>';
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
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnFind"><span class="glyphicon glyphicon-search"></span> &nbsp;Find Applications</button>
											
											<!--Cancel Button !-->
											<a href="admin-post.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;">
											
											</td>
										</tr>	
										</tbody>
										</table>
										</div>
										</form>
										<hr/>
										<form name="frmUser" method="post" action="">
										
										<table class="table table-striped table-bordered">									
												<tbody>
													<?php
	
															if(isset($_POST['btnFind'])) /* if press submit button in Add new mode then this part will work.*/
															{		
																$RecruitmentId = $_POST['cmbRecruitmentId'];		
																$RecruitmentId = trim($RecruitmentId);	
																
																$postid = $_POST['cmbpost'];		
																$postid = trim($postid);
																
																$_SESSION['srecid'] = $_POST['cmbRecruitmentId'];
																$_SESSION['spostid'] = $_POST['cmbpost'];
																
																
																$pystmt = $auth_user->runQuery("SELECT paymentmode FROM masterrecruitment WHERE id=:RecruitmentId");
																$pystmt->execute(array(":RecruitmentId"=>$RecruitmentId));
																$pyRow = $pystmt->fetch(PDO::FETCH_ASSOC);
																$paymentmode=$pyRow['paymentmode'];
																
																if($paymentmode!=2){ // Payment Mode is in Draft/Online
																	$Qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,documentverification dv,paymentverification pv WHERE rd.applicantid=dv.applicantid AND rd.applicantid=pv.applicantid AND dv.status='1' AND pv.status='1' AND rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.applicantid not in(select applicantid from exammapdetails)";
																}
																if($paymentmode==2){ // No Payment is appicable for the recruitment
																	$Qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,documentverification dv WHERE rd.applicantid=dv.applicantid AND dv.status='1' AND rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.applicantid not in(select applicantid from exammapdetails)";	
																}
																$stmt = $auth_user->runQuery($Qury);
																$stmt->execute(array(":recruitmentId"=>$RecruitmentId,":postid"=>$postid));		
																if($stmt->rowCount()>0)
																{
																?>
																<tr>
																	<td></td>
																	<td style="font-weight:bold;">#</td>
																	<td style="font-weight:bold;">Application Id</td>
																	<td style="font-weight:bold;">Applicant Name</td>
																	<td style="font-weight:bold;">Date Of Birth</td>
																	<td style="font-weight:bold;">Father Name</td>
																	<td style="font-weight:bold;">Gender</td>				
																</tr>	
																<?php
																$num_rows=0;
																while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
																{
																	$num_rows++;
																	$applicantid=$userRow['applicantid'];	
																	$applicantname=$userRow['applicantname'];	
																	$dob = date("d-m-Y", strtotime($userRow['dob']));//dd-mm-yyyy
																	$fathername=$userRow['fathername'];	
																	$gender=$userRow['gender'];	
																?>
																<tr>	
																	<td><input type="checkbox" id="applicantvalue" name="applicants[]" value="<?php echo $userRow["applicantid"]; ?>" ></td>
																	<td><?php echo $num_rows; ?></td>
																	<td><?php echo $applicantid; ?></td>
																	<td><?php echo $applicantname; ?></td>
																	<td><?php echo $dob; ?></td>
																	<td><?php echo $fathername; ?></td>
																	<td><?php echo $gender; ?></td>
																</tr> 
																															
																<?php
																}
																
																?>
																<tr>
																	<td colspan="3" width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;color:red;">Examination Slot Name : </td>
																	<td colspan="3" width="40%" align="left" style="font-size:13px;border-color:transparent;">
																		<?php
																		if(isset($_SESSION['srecid']) && isset($_SESSION['spostid'])){
																			$recrtid= $_SESSION['srecid'];
																			$postid=$_SESSION['spostid'];
																			//$rowCount = count($_POST["applicants"]);
																			//echo $rowCount;
																		}
																			
																		?>
																		
																		<select id="examslot" name="cmbExamSlotName" class="selectpicker" data-live-search="true" title="Please Select Exam Slot">
																			<?php
																				$mdstmt = $auth_user->runQuery("SELECT id,examslotname FROM masterexam WHERE recruitmentid='$recrtid' AND postid='$postid' ORDER BY id");// Run your query		
																				$mdstmt->execute();
																			while ($mduserRow = $mdstmt->fetch(PDO::FETCH_ASSOC))
																			{
																				echo '<option value="'.$mduserRow['id'].'">'.$mduserRow['examslotname'].'</option>';
																			}													
																			?> 										
																		</select>
																		<input type="button" class="btn btn-success" name="delete" value="Map Students"  onClick="setDeleteAction();" />
																	</td>
																	<td colspan="1" width="30%" align="left" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">
																	
																	</td>																																		
																</tr>
																<?php
																}
																else 
																{
																	$msg='No Record Found';
																	echo $msg;
																}																
															}
															
													echo "</tbody>";
													echo "</table>";
													?> 		
													<br/>		
												<?php
												if(isset($_POST['btnMap'])) /* if press Map button .*/
												{
																$rowCount = count($_POST["applicants"]);
																for($i=0;$i<$rowCount;$i++) {
																	echo $_POST["applicants"][$i];
																	//mysql_query("DELETE FROM users WHERE userId='" . $_POST["users"][$i] . "'");
																}
												}
												?>
										
										</form>
										<!--END !-->										
									
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
function setDeleteAction() {
if(confirm("Are you sure want to map selected Applicants on this Examination Slot?")) {
document.frmUser.action = "std_exam_updater.php";
document.frmUser.submit();
}
}
</script>