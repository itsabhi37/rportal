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
                    <h4 class="page-head-line"><span class="fa fa-retweet"></span> Application Verifier</h4>
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
																
																$_SESSION['srecid'] = $_POST['cmbRecruitmentId'];
																$_SESSION['spostid'] = $_POST['cmbpost'];
																
																$postid = $_POST['cmbpost'];		
																$postid = trim($postid);	
																
																$stmt = $auth_user->runQuery("SELECT applicantid,applicantname FROM registrationdetails WHERE recruitmentid=:RecruitmentId AND postid=:postid AND status=5");
																$stmt->execute(array(":RecruitmentId"=>$RecruitmentId,":postid"=>$postid));		
																if($stmt->rowCount()>0)
																{		
																
																?>
																<thead>
																<tr>
																	<th style="font-weight:bold;">#</th>
																	<th style="font-weight:bold;">Application Id</th>
																	<th style="font-weight:bold;">Applicant Name</th>
																	<th style="font-weight:bold;" align="center">Form</th>
																	<th style="font-weight:bold;" align="center">Documents</th>
																	<th style="font-weight:bold;" align="center">Document Verification</th>
																	<?php 
																			$pystmt = $auth_user->runQuery("SELECT paymentmode FROM masterrecruitment WHERE id=:RecruitmentId");
																			$pystmt->execute(array(":RecruitmentId"=>$RecruitmentId));
																			$pyRow = $pystmt->fetch(PDO::FETCH_ASSOC);
																			$paymentmode=$pyRow['paymentmode'];
																			
																			if($paymentmode!=2){
																				echo '<td style="font-weight:bold;" align="center">Payment Verification</td>';
																			}
																	?>
																	
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
																?>
																<tr>	
																	<td><?php echo $num_rows; ?></td>
																	<td><?php echo $applicantid; ?></td>
																	 <td><?php echo $applicantname; ?></td>
																	  <td align="center"><a href="printapplication.php?applicationid=<?php echo $applicantid;?>" target="_blank" style="outline:none;" class="btn btn-warning btn-xs"><span class="fa fa-file-pdf-o"></span> Show Form
																	</a>
																	</td>
																	  
																	  <!--Download Document-->
																	  <td align="center">
																	<!--Essential !-->
																	<a href="certificatedownloader.php?applicationid=<?php echo $applicantid;?>&&value=eedu" target="_blank" style="outline:none;" class="btn btn-primary btn-xs"><span class="fa fa-file-pdf-o"></span> Essential Edu.</a>
																	<!--Additional !-->
																	<a href="certificatedownloader.php?applicationid=<?php echo $applicantid;?>&&value=aedu" target="_blank" style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-file-pdf-o"></span> Additional Edu.</a>
																	<!--Identity !-->
																	<a href="certificatedownloader.php?applicationid=<?php echo $applicantid;?>&&value=ide" target="_blank" style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-file-pdf-o"></span> Identity</a>
																	<!--Local !-->
																	<a href="certificatedownloader.php?applicationid=<?php echo $applicantid;?>&&value=loc" target="_blank" style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-file-pdf-o"></span> Local</a>
																	<!--Caste !-->
																	<a href="certificatedownloader.php?applicationid=<?php echo $applicantid;?>&&value=cas" target="_blank" style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-file-pdf-o"></span> Caste</a>
																	<!--Other!-->
																	<a href="certificatedownloader.php?applicationid=<?php echo $applicantid;?>&&value=oth" target="_blank" style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-file-pdf-o"></span> Other</a>
																	</td>
																	
																	<!--Document Verification-->
																	<td align="center">
																	<!--Verify Button !-->
																	<a href="documentverifier.php?applicationid=<?php echo $applicantid;?>&&status=verify" target="_blank" style="outline:none;" class="btn btn-success btn-xs"><span class="fa fa-check-circle" ></span> Verify</a>
																	<!--Rejected Button !-->
																	<a href="documentverifier.php?applicationid=<?php echo $applicantid;?>&&status=reject" target="_blank" style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-times-circle "></span> Reject
																	</a>
																	</td>
																	
																	<!--Payment Verification-->
																	<?php
																	if($paymentmode!=2){
																	?>
																	<td align="center">
																	<!--Verify Button !-->
																	<a href="paymentverifier.php?applicationid=<?php echo $applicantid;?>&&status=verify" target="_blank" style="outline:none;" class="btn btn-success btn-xs"><span class="fa fa-check-circle" ></span> &nbsp;Verify</a>
																	<!--Rejected Button !-->
																	<a href="paymentverifier.php?applicationid=<?php echo $applicantid;?>&&status=reject" target="_blank"  style="outline:none;" class="btn btn-danger btn-xs"><span class="fa fa-times-circle "></span> &nbsp;Reject
																	</a>
																	</td>
																	<?php
																	}
																	?>
																	
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