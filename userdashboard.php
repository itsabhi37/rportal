<?php
require_once("php/session.php");
require_once("php/class.user.php");/*Database Connection Include Here*/
require_once("php/header.php"); /*Header Section Include Here*/
$auth_user = new USER();
$applicantid=$_SESSION['applicantid'];
?>

<div class="content-wrapper">
            <br/>
				<div class="col-lg-3">
                    		<div class="list-group">
                        	<a href="#" class="list-group-item active">Quick Links </a>
                            <a href="userdashboard.php" class="list-group-item"><span class="fa fa-home"></span> Dashboard</a>
                        	<a href="printapplication.php" class="list-group-item"><span class="fa fa-print"></span> Print Application</a>
                            <?php 
							$adstmt = $auth_user->runQuery("SELECT applicantid FROM exammapdetails WHERE applicantid='$applicantid'");
							$adstmt->execute();
							$adcount = $adstmt->rowCount();
								if($adcount== 1)
								{
									echo '<a href="admitcard.php" class="list-group-item"><span class="fa fa-download"></span> Download Admit Card <font style=" color:#F00; font-size:10px; font-weight:bold" class="animated fadeIn infinite">New</font></a>';
								}
							?>
                        	<!--<a href="#" class="list-group-item"><span class="fa fa-trophy"></span> Check Your Result</a>-->
							<a href="#" class="list-group-item"><span class="fa fa-key"></span> Change Password</a>
                            <a href="logout.php?logout=true" class="label label-danger"><span class="fa fa-sign-out"></span> Logout</a>
                   			</div>
				</div>
				<div class="col-lg-9">
							
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
												if($status==5)
												{
														//Check Is Particular Recruitment Have Payment Option
														$stmt = $auth_user->runQuery("SELECT recruitmentid FROM registrationdetails WHERE applicantid=:applicantid");
														$stmt->execute(array(":applicantid"=>$applicantid));
														$row = $stmt->fetch(PDO::FETCH_ASSOC);
														$recrid = $row['recruitmentid'];
														
														//Fetch Payment Details
														$rstmt = $auth_user->runQuery("SELECT paymentmode,paymenturl FROM masterrecruitment WHERE id=:recrid");
														$rstmt->execute(array(":recrid"=>$recrid));
														$recrow = $rstmt->fetch(PDO::FETCH_ASSOC);
														$paymode = $recrow['paymentmode'];
														$purl = $recrow['paymenturl'];
														
														$_SESSION['paymentmode']=$paymode;
														
														if($paymode==0)//If Recruitment accept Draft Payment Mode 
														{
															$ddraft = $auth_user->runQuery("SELECT * FROM draftdetails WHERE applicantid=$applicantid");// Run your query	
															$ddraft->execute();
															$count = $ddraft->rowCount();
															$ddRow = $ddraft->fetch(PDO::FETCH_ASSOC);
															
															if($count== 1)
															{
																echo '<br/><font style=" color:#08aa5c; font-size:15px; font-weight:bold">Application submitted Successfully.</font><br/><br/>';
																echo '<font style=" color:#08aa5c; font-size:15px; font-weight:bold">Payment submitted Successfully.</font><br/><br/>';	
															}
															else{	
																echo '<br/><font style=" color:#08aa5c; font-size:15px; font-weight:bold">Application submitted Successfully.</font><br/><br/>';
																?>
																<a href="<?php echo 'draftdetail.php';?>" class="btn btn-danger"><span class="fa fa-inr"></span> Click Here To Pay Fee (Draft Mode) </a><br><br>
																<?php
																
															}
														}
														else if($paymode==1)//If Recruitment accept Online Payment Mode 
														{		
															echo '<br/><font style=" color:#08aa5c; font-size:15px; font-weight:bold">Application submitted Successfully.</font><br/><br/>';
															?>
															<a href="<?php echo $purl;?>" class="btn btn-danger"><span class="fa fa-inr"></span> Click Here To Pay Fee (Online Mode) </a><br><br>
															<?php							
														
														}
														else //If No Payment Option
														{
															echo '<br/><font style=" color:#08aa5c; font-size:15px; font-weight:bold">Application submitted Successfully.</font><br/><br/>';
														}
												}
												else
												{
													//If Form not filled Properly / Not Completed
													header("Location: form.php");
												}
											}	
											else
											{
												//Recruitment Date Closed
												//Show verification(Payment/dcoument) status
												if($status!=5)//Date Closed but Application Not Filled Properly
												{
													echo '<br/><font style=" color:red; font-size:15px; font-weight:bold">You are not Submitted Application properly.</font><br/><br/>';
												}
												else //Show verification(Payment/document) status
												{
												?>
												<div class="bs-example">
														<div class="panel-group" id="accordion">
															<div class="panel panel-success">
																<div class="panel-heading">
																	<h4 class="panel-title">
																		<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Verification Status</a>
																	</h4>
																</div>
																<div id="collapseOne" class="panel-collapse collapse in">
																	<div class="panel-body">
																	<!-- Document Verification Status-->
																	<?php
																		$dstmt = $auth_user->runQuery("SELECT status,remarks FROM documentverification WHERE applicantid=:applicantid");
																		$dstmt->execute(array(":applicantid"=>$applicantid));
																		$drow = $dstmt->fetch(PDO::FETCH_ASSOC);																		
																			if($dstmt->rowCount()>0)
																			{
																				$dstatus = $drow['status'];
																				$dremarks = $drow['remarks'];
																				if($dstatus==1){
																					echo '<font style=" color:#128c33; font-size:15px; font-weight:bold">>> '.$dremarks.'</font>';
																				}
																				if($dstatus==2){
																					echo '<font style=" color:#F00; font-size:15px; font-weight:bold">>> '.$dremarks.'</font>';
																				}
																			}

																	?>
																	<br/>
																	<!-- Payment Verification Status-->
																	<?php
																			//Fetch Applicant Payment Details
																			$pstmt = $auth_user->runQuery("SELECT status,remarks FROM paymentverification WHERE applicantid=:applicantid");
																			$pstmt->execute(array(":applicantid"=>$applicantid));
																			$pyrow = $pstmt->fetch(PDO::FETCH_ASSOC);																			
																			if($pstmt->rowCount()>0)
																			{
																				$pystatus = $pyrow['status'];
																				$pyremarks = $pyrow['remarks'];
																				
																				if($pystatus==1){
																					echo '<font style=" color:#128c33; font-size:15px; font-weight:bold">>> '.$pyremarks.'</font>';
																				}
																				if($pystatus==2){
																					echo '<font style=" color:#F00; font-size:15px; font-weight:bold">>> '.$pyremarks.'</font>';
																				}																						
																			}
																	?>
																	</div>
																</div>
															</div>
														</div>
													<p><strong>Note:</strong> Click on the linked heading text to expand or collapse details.</p>
												</div>
											<?php
												}
											}
										}													
								?>

							
				</div>
				
</div>
<?php
require_once("php/footer.php"); /*Footer Section Include Here*/
?>