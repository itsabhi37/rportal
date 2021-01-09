<?php
//Include Commnon Header Part
require_once("php/header.php");
require_once("php/session.php");	
require_once("php/class.user.php");
$auth_user = new USER();
$admindist=$_SESSION['admin_dist'];
//This page Only For Super Admin's
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
                    <h4 class="page-head-line"><span class="fa fa-search"></span> Application Finder</h4>
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
										<!--START !-->
										<div class="table-responsive">
											<!--Form for Edit / View Details !-->
											<form role="form" method="post">
												<table class="table">												
													<tbody>
														<tr>
															<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Recruitment Name</td>
															<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
															<select id="recruitment" name="cmbRecruitmentId" class="selectpicker" data-live-search="true" title="Please Select Recruitment"  onChange="getPost(this.value);" required>
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
															<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Status Type</td>
															<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
															<select id="cmbStatus" name="cmbStatus" class="form-control" required>
																<option value="">Please select Status</option>
																<option value="1">Document Verified</option>
																<option value="2">Payment Verified</option>
																<option value="3">Document & Payment Both Verified</option>
																<option value="4">Document Rejected</option>
																<option value="5">Payment Rejected</option>
																<option value="6">Document & Payment Both Rejected</option>									
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
															<a href="admin-applicationfinder.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
															
															</td>								
															<td width="30%" align="right" style="border-color:transparent;">
															
															</td>
														</tr>	
													</tbody>
												</table>
											<!--END !-->										
											</form>
										</div>
										<hr/>
										<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">												
												
													<?php
	
															if(isset($_POST['btnFind'])) /* if press submit button in Add new mode then this part will work.*/
															{		
																$RecruitmentId = $_POST['cmbRecruitmentId'];		
																$RecruitmentId = trim($RecruitmentId);	
																
																$postid = $_POST['cmbpost'];		
																$postid = trim($postid);	
																
																$statusval = $_POST['cmbStatus'];		
																$statusval = trim($statusval);	
																switch($statusval){
																	case 1:
																		$qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,documentverification dv WHERE rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.status=5 AND rd.applicantid=dv.applicantid AND dv.status=1";
																		$searchby="<span class='label label-success'>Document Verified</span>";
																		break;
																	case 2:
																		$qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,paymentverification pv WHERE rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.status=5 AND rd.applicantid=pv.applicantid AND pv.status=1";
																		$searchby="<span class='label label-success'>Payment Verified</span>";
																		break;
																	case 3:
																		$qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,documentverification dv,paymentverification pv WHERE rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.status=5 AND rd.applicantid=dv.applicantid AND rd.applicantid=pv.applicantid AND dv.status=1 AND pv.status=1";
																		$searchby="<span class='label label-success'>Document & Payment Both Verified</span>";
																		break;
																	case 4:
																		$qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,documentverification dv WHERE rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.status=5 AND rd.applicantid=dv.applicantid AND dv.status=2";
																		$searchby="<span class='label label-danger'>Document Rejected</span>";
																		break;
																	case 5:
																		$qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,paymentverification pv WHERE rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.status=5 AND rd.applicantid=pv.applicantid AND pv.status=2";
																		$searchby="<span class='label label-danger'>Payment Rejected</span>";
																		break;
																	case 6:
																		$qury="SELECT rd.applicantid,rd.applicantname,rd.fathername,rd.dob,rd.gender FROM registrationdetails rd,documentverification dv,paymentverification pv WHERE rd.recruitmentid=:recruitmentId AND rd.postid=:postid AND rd.status=5 AND rd.applicantid=dv.applicantid AND rd.applicantid=pv.applicantid AND dv.status=2 AND pv.status=2";
																		$searchby="<span class='label label-danger'>Document & Payment Both Rejected</span>";
																		break;
																}																
																$stmt = $auth_user->runQuery($qury);
																$stmt->execute(array(":recruitmentId"=>$RecruitmentId,":postid"=>$postid));		
																if($stmt->rowCount()>0)
																{		
																?>
																<thead>
																<tr>
																	<th style="font-weight:bold;">#</th>
																	<th style="font-weight:bold;">Application Id</th>
																	<th style="font-weight:bold;">Applicant Name</th>
																	<th style="font-weight:bold;" align="center">Father Name</th>
																	<th style="font-weight:bold;" align="center">Gender</th>
																	<th style="font-weight:bold;" align="center">Date of Birth</th>
																	<th style="font-weight:bold;" align="center">Status</th>
																</tr>
																</thead>
																<tbody>																
																<?php
																$num_rows=0;
																while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
																{
																	$num_rows++;
																	$applicantid=$userRow['applicantid'];	
																	$applicantname=$userRow['applicantname'];	
																	$fathername=$userRow['fathername'];	
																	$gender=$userRow['gender'];	
																	$dob=$userRow['dob'];	
																	$dob = date("d-m-Y", strtotime($userRow['dob']));//dd-mm-yyyy
																	
																?>
																<tr>	
																	<td><?php echo $num_rows; ?></td>
																	<td><?php echo $applicantid; ?></td>
																	<td><?php echo $applicantname; ?></td>
																	<td><?php echo $fathername; ?></td>
																	<td><?php echo $gender; ?></td>
																	<td><?php echo $dob; ?></td>
																	<td><?php echo $searchby; ?></td> 
																</tr>   
																<?php
																}
																}
																else 
																{
																	$msg='No Record Found';
																	echo $msg;
																}
															}
															
													?>
													
                                                                                                    
													<?php
													echo "</tbody>";
													echo "</table>";
													?> 		
												
										</div>	
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