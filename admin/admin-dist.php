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
		$dist_id=$_GET['id'];	
		
		$stmt = $auth_user->runQuery("SELECT * FROM masterdist WHERE id=:dist_id");
		$stmt->execute(array(":dist_id"=>$dist_id));
		while ($distRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{			
			$fdist = $distRow['name'];
		}
	}
	else /* If new, then this part will be run. */
	{
		$stmt = $auth_user->runQuery("SELECT MAX(id) id FROM masterdist");
		$stmt->execute();
		$count = $stmt->rowCount();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if($count== 1)
		{
			if($userRow['id']=="")
			{
				$did=1;	
			}
			else 
			{
				$did=$userRow['id']+1;	
			}
		}
	}
	
	if(isset($_POST['btnSubmit'])) /* if press submit button in Add new mode then this part will work.*/
	{		
		/* Checking in both mode(Add New / Edit), whether the fields are properly filled or not.*/
		$DistName = $_POST['txtDistName'];		
		$DistName = trim($DistName);	
				
		if(isset($_GET['id'])) /* if press submit button in Edit mode then this part will work.*/
		{
			/* In edit mode run update command*/
			
				$stmt = $auth_user->runQuery("UPDATE masterdist SET name=:dist_name WHERE id=:dist_id");
				$stmt->execute(array(":dist_name"=>$DistName,":dist_id"=>$dist_id));				
				?>
				<script type="text/javascript">
				alert("District Updated Successfully...!");
				window.location.href = "admin-dist.php";
				</script>
				<?php
		}
		else
		{
			/* In Add New mode run insert command*/
				$stmt = $auth_user->runQuery("INSERT into masterdist (id,name)values(:dist_id,:dist_name)");
				$stmt->execute(array(":dist_id"=>$did,":dist_name"=>$DistName));
		?>
		<script type="text/javascript">
		alert("District Added Successfully...!");
		window.location.href = "admin-dist.php";
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
                    <h4 class="page-head-line"><span class="fa fa-map-marker"></span> Manage District</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" >                                           
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> District List</a>
                                </li>
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="<?php if(isset($_GET['id'])){echo 'fa fa-edit';} else {echo 'fa fa-plus';}?>"></span><?php if(isset($_GET['id'])){echo ' Edit District';} else {echo ' Add District';}?> </a>
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
												<th>District Name</th>
												<th>Options</th>
											  </tr>
											</thead>									
												<tbody>
													<!--<tr>
														<td style="font-weight:bold;"></td>
														<td style="font-weight:bold;"></td>
														<td ></td>
													</tr>-->
													<?php
													$stmt = $auth_user->runQuery("SELECT id,name FROM masterdist");
													$stmt->execute();
													$num_rows = 0;
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$num_rows++;
														$id = $userRow['id'];
														$name = $userRow['name'];
													?>
													<tr>	
                                                        <td><?php echo $num_rows; ?></td>
                                                        <td><?php echo $name; ?></td>
														<td>
														<!--Edit Button !-->
														<a href="admin-dist.php?id=<?php echo $id;?>" style="outline:none;" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-wrench changetabbutton" ></span> &nbsp;Edit</a>
														<!--Delete Button !-->
														<a href="#" data-href="delete.php?del_dist_id=<?php echo $id;?>"  style="outline:none;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span> &nbsp;Delete
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
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="text" class="form-control" name="txtDistName" value="<?php if(isset($_GET['id'])){echo $fdist;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="<?php if(isset($_GET['id'])){echo 'glyphicon glyphicon-edit';} else {echo 'glyphicon glyphicon-plus';}?>"></span> &nbsp;<?php if(isset($_GET['id'])){echo 'Edit District';} else {echo 'Add District';}?></button>
											
											<!--Cancel Button !-->
											<a href="admin-dist.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
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