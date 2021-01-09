<?php

require_once("php/header.php");
require_once("php/session.php");
require_once("php/class.user.php");/*Database Connection Include Here*/
$auth_user = new USER();

if(isset($_GET['applicationid'])&& $session->is_loggedin()&&$_GET['status'])
{
	$applicantid=$_GET['applicationid'];
	$docstatus=$_GET['status'];		
	
	$stmt = $auth_user->runQuery("SELECT applicantid,remarks FROM paymentverification WHERE applicantid=:applicantid");// Run your query	
	$stmt->execute(array(":applicantid"=>$applicantid));
		if($stmt->rowCount()>0)
		{
			$erow = $stmt->fetch(PDO::FETCH_ASSOC);
			$fremarks=$erow['remarks'];
		}
}
?>

<?php
	if(isset($_POST['btnSetRemarks'])) /* if press submit button in Add new mode then this part will work.*/
	{	
		// 1- Select
		// 2- Reject 
		
		$recid=$_SESSION['srecid'];
		$posid=$_SESSION['spostid'];
		$remarks = $_POST['txtRemarks'];		
		$remarks = trim($remarks);
		
		if($docstatus=="verify"){
			
			$dstatus=1;
		}
		else if($docstatus=="reject"){
			$dstatus=2;
			
		}
		else{
			header("Location: admin-applicationfinder.php");
			break;
		}
		$stmt = $auth_user->runQuery("SELECT applicantid,remarks FROM paymentverification WHERE applicantid=:applicantid");// Run your query	
		$stmt->execute(array(":applicantid"=>$applicantid));
		if($stmt->rowCount()==0)
		{
			// Insert Payment verification Remarks
			$stmt = $auth_user->runQuery("INSERT into paymentverification(applicantid,recruitmentid,postid,status,remarks)values(:applicantid,:recruitmentid,:postid,:status,:remarks)");
			$stmt->execute(array(":applicantid"=>$applicantid,":recruitmentid"=>$recid,":postid"=>$posid,":status"=>$dstatus,":remarks"=>$remarks));
			?>
			<script type="text/javascript">
			alert("Payment Verification Remarks Inserted Successfully...!");
			window.location.href = "admin-applicationfinder.php";
			</script>
			<?php
		}
		else
		{
			// Update document verification Remarks			
			$stmt = $auth_user->runQuery("UPDATE paymentverification SET recruitmentid=:recid,postid=:postid,status=:status,remarks=:remarks WHERE applicantid=:applicantid");
			$stmt->execute(array(":recid"=>$recid,":postid"=>$posid,":status"=>$dstatus,":remarks"=>$remarks,":applicantid"=>$applicantid));
			?>
			<script type="text/javascript">
			alert("Payment Verification Remarks Updated Successfully...!");
			window.location.href = "admin-applicationfinder.php";
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
                    <h4 class="page-head-line"><span class="fa fa-money"></span> Payment Verifier</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" > 
						<!--If Payment is in Draft Mode Then show details here-->
						<?php
						$drstmt = $auth_user->runQuery("SELECT *FROM draftdetails WHERE applicantid=:applicantid");// Run your query	
						$drstmt->execute(array(":applicantid"=>$applicantid));
							if($drstmt->rowCount()>0)
							{
								$drfrow = $drstmt->fetch(PDO::FETCH_ASSOC);
								$drftbankname=$drfrow['bankname'];
								$drftddamount=$drfrow['ddamount'];
								$drftddnumber=$drfrow['ddnumber'];
								$drftdddate = date("d-m-Y", strtotime($drfrow['dddate']));//dd-mm-yyyy		
								$drftattachment=$drfrow['attachment'];
								?>
								<div class="bs-example">
											<div class="panel-group" id="accordion">
												<div class="panel panel-primary">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Draft Deatils</a>
														</h4>
													</div>
													<div id="collapseOne" class="panel-collapse collapse in">
														<div class="panel-body">
														<div class="table-responsive">
														<table class="table table-striped table-bordered">												
														<tbody>
															<tr>
																<td align="right"><font style=" color:#F00; font-size:15px; font-weight:bold">Bank Name : </font></td>
																<td colspan="2"><?php echo $drftbankname;?></td>
																<td rowspan="4"><a href="<?php echo 'data:image/jpeg;base64,'.base64_encode( $drftattachment ).'';?>" target="_blank"><?php echo '<img style="width:450px;height:150px" src="data:image/jpeg;base64,'.base64_encode( $drftattachment ).'"/>';?></a></td>
															</tr>
															<tr>
																<td align="right"><font style=" color:#F00; font-size:15px; font-weight:bold">Amount : </font></td>
																<td colspan="2"><?php echo $drftddamount;?></td>
															</tr>
															<tr>
																<td align="right"><font style=" color:#F00; font-size:15px; font-weight:bold">DD Number : </font></td>
																<td colspan="2"><?php echo $drftddnumber;?></td>
															</tr>
															<tr>
																<td align="right"><font style=" color:#F00; font-size:15px; font-weight:bold">DD Date : </font></td>
																<td colspan="2"><?php echo $drftdddate;?></td>
															</tr>
														</tbody>
														</table>
														</div>
														</div>
													</div>
												</div>
											</div>
								</div>
								<?php
							}
						?>
						
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-floppy-o"></span> Set Details</a>
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
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Application Id</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" class="form-control" value="<?php 
											echo $applicantid;
											?>" disabled>
											
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Remarks</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<textarea class="form-control" name="txtRemarks" required><?php 
											if(isset($fremarks))
											{
											echo $fremarks;
											}
											?></textarea>
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>										
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSetRemarks"><span class="fa fa-floppy-o"></span> &nbsp;Set Remarks</button>
											
											<!--Cancel Button !-->
											<a href="admin-applicationfinder.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;">
											
											</td>
										</tr>	
										</tbody>
										</table>
										</div>	
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