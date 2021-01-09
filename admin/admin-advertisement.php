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
	$advrid=$_GET['id'];

	$stmt = $auth_user->runQuery("SELECT * FROM advertisementdetails WHERE id=:advrid");
	$stmt->execute(array(":advrid"=>$advrid));
	while ($advrRow = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$frecid = $advrRow['recruitmentid'];
		$ffilename = $advrRow['filename'];
	}
}
else /* If new, then this part will be run. */
{
	$stmt = $auth_user->runQuery("SELECT MAX(id) id FROM advertisementdetails");
	$stmt->execute();
	$count = $stmt->rowCount();
	$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	if($count== 1)
	{
		if($userRow['id']=="")
		{
			$adid=1;
		}
		else
		{
			$adid=$userRow['id']+1;
		}
	}
}
?>
<?php
if(isset($_POST['btnSubmit'])) /* if press submit button in Add new mode then this part will work.*/
{
	/* Checking in both mode(Add New / Edit), whether the fields are properly filled or not.*/
	$RecruitmentId = $_POST['cmbRecruitmentId'];
	$RecruitmentId = trim($RecruitmentId);
    
   

   if(is_uploaded_file($_FILES['advrpdf']['tmp_name'])){
      $errors= array();
      $file_name = $_FILES['advrpdf']['name'];
      $file_size =$_FILES['advrpdf']['size'];
      $file_tmp =$_FILES['advrpdf']['tmp_name'];
      $file_type=$_FILES['advrpdf']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['advrpdf']['name'])));

      $expensions= array("pdf");

      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a PDF file.";
      }

      if($file_size > 2097152){
         $errors[]='File size must be less than 2 MB';
      }

      if(empty($errors)==true){
       move_uploaded_file($file_tmp,"advertisements/".$file_name);
          
       if(isset($_GET['id'])) /* if press submit button in Edit mode then this part will work.*/
        {
            /* In edit mode run update command*/
            try{
                $stmt = $auth_user->runQuery("UPDATE advertisementdetails SET filename=:file_name,recruitmentid=:rid WHERE id=:advr_id");
                $stmt->execute(array(":file_name"=>$file_name,":rid"=>$RecruitmentId,":advr_id"=>$advrid));		
            }
           catch(PDOException $e)
            {
                echo $e->getMessage();
            }	
                ?>
                <script type="text/javascript">
                alert("Advertisement Updated Successfully...!");
                window.location.href = "admin-advertisement.php";
                </script>
                <?php			
        }
        else
        {
                /* In Add New mode run insert command*/
            try{
                    $stmt = $auth_user->runQuery("INSERT into advertisementdetails (id,recruitmentid,filename)values(:advr_id,:rid,:file_name)");
                    $stmt->execute(array(":advr_id"=>$adid,":rid"=>$RecruitmentId,":file_name"=>$file_name));
                }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
            ?>
            <script type="text/javascript">
            alert("Advertisement Added Successfully...!");
            window.location.href = "admin-advertisement.php";
            </script>
            <?php					
        }
      }
   }
   else{
       ?>
	       <script type="text/javascript">
            alert("Something went wrong, Please Upload Advertisement");
            window.location.href = "admin-advertisement.php";
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
                    <h4 class="page-head-line"><span class="fa fa-file-pdf-o"></span> Manage Advertisement</h4>
                </div>
            </div>

			<div class="row" >
				<div class="col-md-12 col-sm-12" >
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> Advertisement List</a>
                                </li>
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="<?php if(isset($_GET['id'])){echo 'fa fa-edit';} else {echo 'fa fa-plus';}?>"></span><?php if(isset($_GET['id'])){echo ' Edit Advertisement';} else {echo ' Add Advertisement';}?> </a>
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
														<th>File Name</th>
														<th>Options</th>
													</tr>
												</thead>
												<tbody>
													
													<?php
													if($admindist!=0)
													{
														// District Admin Login
														$Qury="SELECT a.id,r.name as recruitmentname, a.filename FROM masterrecruitment r,advertisementdetails a WHERE a.recruitmentid=r.id AND r.distid=$admindist";
													}
													else{
														//Super Admin Login
														$Qury="SELECT a.id,r.name as recruitmentname, a.filename FROM masterrecruitment r,advertisementdetails a WHERE a.recruitmentid=r.id";
													} 
													
													$stmt = $auth_user->runQuery($Qury);
													$stmt->execute();
													$num_rows = 0;
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$num_rows++;
														$vadvrid =$userRow['id'];
														$vrecruitmentname = $userRow['recruitmentname'];
														$vfilename = $userRow['filename'];
													?>
													<tr>
														<td><?php echo $num_rows; ?></td>
                                                        <td><?php echo $vrecruitmentname; ?></td>
                                                        <td><?php echo $vfilename; ?></td>
														<td align="center">
														<!--Edit Button !-->
														<a href="admin-advertisement.php?id=<?php echo $vadvrid;?>" style="outline:none;" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-wrench changetabbutton" ></span> &nbsp;Edit</a>
														<!--Delete Button !-->
														<a href="#" data-href="delete.php?del_advrtsmnt_id=<?php echo $vadvrid;?>"  style="outline:none;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span> &nbsp;Delete
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
                                    <form role="form" method="post" enctype="multipart/form-data">
										<!--Form for Accept Input !-->
										<!--START !-->
										<table class="table table-bordered">
										<tbody>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Recruitment Name</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
											<select id="recruitment" name="cmbRecruitmentId" class="selectpicker" data-live-search="true" title="Please Select Recruitment" required>
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
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;">Advertisement</td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
												<input type="file" name="advrpdf" class="form-control" id="advrpdf">
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>
										<tr>
											<td width="30%" align="right" style="padding-top:15px;font-weight:bold;font-size:15px;border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">
												<font color="#ed3b55" ><b>Note :- <br/>
												(i) Upload Advertisement in PDF Format Only <br/>
												(ii) Advertisement Size must be less than 3mb 
												</b></font>
											</td>
                                            <td width="30%" align="right" style="border-color:transparent;"></td>
										</tr>
                                        <tr>
											
                                                <?php
                                                //If Error Occurs.
                                                if(isset($errors)){
                                                    echo '<font color="#ed3b55" ><b>'; 
                                                    print_r($errors);
                                                    echo '</b></font>';
                                                }
                                                ?>
											
										</tr>
										<tr>
											<td width="30%" align="right" style="border-color:transparent;"></td>
											<td width="40%" align="left" style="font-size:13px;border-color:transparent;">

											<!--Submit Button !-->
											<button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="<?php if(isset($_GET['id'])){echo 'glyphicon glyphicon-edit';} else {echo 'glyphicon glyphicon-plus';}?>"></span> &nbsp;<?php if(isset($_GET['id'])){echo 'Edit Advertisement';} else {echo 'Add Advertisement';}?></button>

											<!--Cancel Button !-->
											<a href="admin-advertisement.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>

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
