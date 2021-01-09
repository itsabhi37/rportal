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
		$postid=$_GET['id'];	
		
		$stmt = $auth_user->runQuery("SELECT * FROM masterpost WHERE id=:postid");
		$stmt->execute(array(":postid"=>$postid));
		while ($postRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$frecid = $postRow['recruitmentid'];
			$fpostname = $postRow['name'];
		}
	}
	else /* If new, then this part will be run. */
	{
		$stmt = $auth_user->runQuery("SELECT MAX(id) id FROM masterpost");
		$stmt->execute();
		$count = $stmt->rowCount();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if($count== 1)
		{
			if($userRow['id']=="")
			{
				$pid=1;	
			}
			else 
			{
				$pid=$userRow['id']+1;	
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
		
			$PostName = $_POST['txtPostName'];		
			$PostName = trim($PostName);	
					
			if(isset($_GET['id'])) /* if press submit button in Edit mode then this part will work.*/
			{
				/* In edit mode run update command*/
					$stmt = $auth_user->runQuery("UPDATE masterpost SET name=:post_name,recruitmentid=:rid WHERE id=:post_id");
					$stmt->execute(array(":post_name"=>$PostName,":rid"=>$RecruitmentId,":post_id"=>$postid));				
					?>
					<script type="text/javascript">
					alert("Post Updated Successfully...!");
					window.location.href = "admin-post.php";
					</script>
					<?php			
			}
			else
			{
				/* In Add New mode run insert command*/
					$stmt = $auth_user->runQuery("INSERT into masterpost (id,recruitmentid,name)values(:post_id,:rid,:postname)");
					$stmt->execute(array(":post_id"=>$pid,":rid"=>$RecruitmentId,":postname"=>$PostName));
			?>
			<script type="text/javascript">
			alert("Post Added Successfully...!");
			window.location.href = "admin-post.php";
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
                    <h4 class="page-head-line"><span class="fa fa-bookmark"></span> Manage Post</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" >                                           
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> Post List</a>
                                </li>
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="<?php if(isset($_GET['id'])){echo 'fa fa-edit';} else {echo 'fa fa-plus';}?>"></span><?php if(isset($_GET['id'])){echo ' Edit Post';} else {echo ' Add Post';}?> </a>
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
														<th>Options</th>
													</tr>
											</thead>
											
												<tbody>
													
													
													<?php
													if($admindist!=0)
													{
														// District Admin Login
														$Qury="SELECT p.id,r.name as recruitmentname, p.name FROM masterrecruitment r,masterpost p WHERE p.recruitmentid=r.id AND r.distid=$admindist";
													}
													else{
														//Super Admin Login
														$Qury="SELECT p.id,r.name as recruitmentname, p.name FROM masterrecruitment r,masterpost p WHERE p.recruitmentid=r.id";
													} 
													
													$stmt = $auth_user->runQuery($Qury);
													$stmt->execute();
													$num_rows = 0;
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$num_rows++;
														$vpostid =$userRow['id'];
														$vrecruitmentname = $userRow['recruitmentname'];
														$vpostname = $userRow['name'];	
													?>
													<tr>	
														<td><?php echo $num_rows; ?></td>
                                                        <td><?php echo $vrecruitmentname; ?></td>
                                                        <td><?php echo $vpostname; ?></td>
														<td align="center">
														<!--Edit Button !-->
														<a href="admin-post.php?id=<?php echo $vpostid;?>" style="outline:none;" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-wrench changetabbutton" ></span> &nbsp;Edit</a>
														<!--Delete Button !-->
														<a href="#" data-href="delete.php?del_post_id=<?php echo $vpostid;?>"  style="outline:none;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span> &nbsp;Delete
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
											<select id="recruitment" name="cmbRecruitmentId" class="selectpicker" data-live-search="true" title="Please Select Recruitment">
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
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;"><input type="text" class="form-control" name="txtPostName" value="<?php if(isset($_GET['id'])){echo $fpostname;}?>" required /></td>								
                                            <td width="30%" align="right" style="border-color:transparent;"></td>			
										</tr>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											
											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="<?php if(isset($_GET['id'])){echo 'glyphicon glyphicon-edit';} else {echo 'glyphicon glyphicon-plus';}?>"></span> &nbsp;<?php if(isset($_GET['id'])){echo 'Edit Post';} else {echo 'Add Post';}?></button>
											
											<!--Cancel Button !-->
											<a href="admin-post.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
											
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
