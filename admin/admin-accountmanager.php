<?php
//Include Commnon Header Part
require_once("php/header.php");
require_once("php/session.php");	
require_once("php/class.user.php");
$auth_user = new USER();
//This page Only For Super Admin's
	if($_SESSION['admin_type']!="Super Admin")
	{
		$session->redirect('index.php');
	}
		
?>
<?php
	if(isset($_GET['id']))
	{
		$admin_id=$_GET['id'];	
		$stmt = $auth_user->runQuery("SELECT * FROM adminlogin WHERE adminid=:admin_id");
		$stmt->execute(array(":admin_id"=>$admin_id));
		while ($distRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{			
			$fdistid = $distRow['dist'];
			$fadmintype = $distRow['admintype'];
		}
	}
	
	if(isset($_POST['btnSubmit'])) /* if press submit button in Add new mode then this part will work.*/
	{		
		/* Checking in both mode(Add New / Edit), whether the fields are properly filled or not.*/
		
		$Distid = $_POST['cmbDistid'];		
		
		$AdminId = $_POST['txtAdminId'];		
		$AdminId = trim($AdminId);	
		
		$Password = $_POST['txtPassword'];		
		$Password = trim($Password);
		
		$ConfirmPassword = $_POST['txtConfirmPassword'];		
		$ConfirmPassword = trim($ConfirmPassword);
		
		if($Distid==0)
		{
			$AdminType ='Super Admin';		
		}
		else
		{
			$AdminType ='Admin';					
		}
				
		if($Password==$ConfirmPassword)
		{	
			$Password=sha1($Password);
			try{
				if(isset($_GET['id'])) /* if press submit button in Edit mode then this part will work.*/
				{
					/* In edit mode run update command*/
					
						$stmt = $auth_user->runQuery("UPDATE adminlogin SET password=:pass,dist=:dist_id,admintype=:admin_type WHERE adminid=:adminid");
						$stmt->execute(array(":pass"=>$Password,":dist_id"=>$Distid,":admin_type"=>$AdminType,":adminid"=>$admin_id));				
						?>
						<script type="text/javascript">
						alert("Account Updated Successfully...!");
						window.location.href = "admin-accountmanager.php";
						</script>
						<?php
				}
				else
				{
					/* In Add New mode run insert command*/
						$stmt = $auth_user->runQuery("INSERT into adminlogin (adminid,password,dist,admintype)values(:adminid,:password,:dist,:admintype)");
						$stmt->execute(array(":adminid"=>$AdminId,":password"=>$Password,":dist"=>$Distid,":admintype"=>$AdminType));
				?>
				<script type="text/javascript">
				alert("Account Added Successfully...!");
				window.location.href = "admin-accountmanager.php";
				</script>
				<?php
				}
			}
			catch(Exception $e)
			{
				$expmsg='Message: ' .$e->getMessage();
			}

		}
		else{
			?>
			<script type="text/javascript">
			alert("Password & Confirm Password must be same.");
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
                    <h4 class="page-head-line"><span class="fa fa-cogs"></span> Manage Account</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" >                                           
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> Account List</a>
                                </li>
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="<?php if(isset($_GET['id'])){echo 'fa fa-edit';} else {echo 'fa fa-plus';}?>"></span><?php if(isset($_GET['id'])){echo ' Edit Account';} else {echo ' Add Account';}?> </a>
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
														<th>Admin Id</th>
														<th>District</th>
														<th>Admin Type</th>
														<th>Options</th>
													</tr>
													</thead>										
												<tbody>
													<?php
													$stmt = $auth_user->runQuery("SELECT adminid,dist,admintype FROM adminlogin");
													$stmt->execute();
													$num_rows = 0;
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$num_rows++;
														$adminid = $userRow['adminid'];
														$distid = $userRow['dist'];
														$admintype = $userRow['admintype'];
														
														$distq = $auth_user->runQuery("SELECT name FROM masterdist WHERE id=$distid");// Run your query	
														$distq->execute();
														$distcount = $distq->rowCount();
														$distRow = $distq->fetch(PDO::FETCH_ASSOC);
														
														if($distcount== 1)
														{
															$distname=$distRow['name'];						
														}
														else{
															$distname='All District';
														}
													?>
													<tr>	
                                                        <td><?php echo $num_rows; ?></td>
                                                        <td><?php echo $adminid; ?></td>
														 <td><?php echo $distname; ?></td>
														<td><?php echo $admintype; ?></td>
														<td align="center">
														<!--Edit Button !-->
														<a href="admin-accountmanager.php?id=<?php echo $adminid;?>" style="outline:none;" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-wrench changetabbutton" ></span> &nbsp;Edit</a>
														<!--Delete Button !-->
														<a href="#" data-href="delete.php?del_acnt_id=<?php echo $adminid;?>"  style="outline:none;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span> &nbsp;Delete
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
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">District Name</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<select id="cmbDistid"  onchange="show_admin_type(this.value)" name="cmbDistid" class="selectpicker" data-live-search="true" title="Please Select District" required>
                                                            <?php
                                                                $stmt = $auth_user->runQuery("SELECT id,name FROM masterdist ORDER BY name");// Run your query		
                                                                $stmt->execute();
                                                                while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
                                                                {
                                                                    // If in edit mode
                                                                    if($fdistid==$userRow['id'])
                                                                    {
                                                                        $selected = 'selected="selected"';
                                                                    }
                                                                    else{
                                                                        $selected = '';
                                                                    }
                                                                    echo '<option value="'.$userRow['id'].'" '.$selected.'>'.$userRow['name'].'</option>';	
                                                                }													
                                                            ?> 	
															<option value="0" <?php if(isset($_GET['id'])&& $fdistid==0){echo 'selected';}?>>All Districts</option>
											</select>
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Admin Id</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="text" class="form-control" name="txtAdminId" value="<?php if(isset($_GET['id'])){echo $admin_id;}?>" <?php if(isset($_GET['id'])){echo 'readonly';}?> required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Password</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="password" class="form-control" name="txtPassword" value="<?php if(isset($_GET['id'])){echo '';}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Confirm Password</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="password" class="form-control" name="txtConfirmPassword" value="<?php if(isset($_GET['id'])){echo '';}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Admin Type</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<input type="text" class="form-control" id="AdminType" name="txtAdminType" value="<?php if(isset($_GET['id'])){echo $fadmintype;}?>" disabled />
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="<?php if(isset($_GET['id'])){echo 'glyphicon glyphicon-edit';} else {echo 'glyphicon glyphicon-plus';}?>"></span> &nbsp;<?php if(isset($_GET['id'])){echo 'Edit Account';} else {echo 'Add Account';}?></button>
											
											<!--Cancel Button !-->
											<a href="admin-accountmanager.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
											</td>								
                                            <td width="30%" align="right" style="border-color:transparent;">
											
											</td>
										</tr>	
										<?php
											if(isset($expmsg))
												{
													echo '<font style=" color:red; font-size:15px; font-weight:bold">'.$expmsg.'</font>';
												}
										?>
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
		
		/*Payment URL Function*/
		function show_admin_type(value)
		{
			if(value == 0)
			{
				$("#AdminType").val("Super Admin");
			}
			else
			{
				$("#AdminType").val("Admin");
			}
		}
</script>
<!-- Code For Delete Data With the help of modal-->
<script>
        $('#myModal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));            
            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
</script>