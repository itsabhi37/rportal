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
	if(isset($_GET['id']))
	{
		$recruitment_id=$_GET['id'];	
		
		$stmt = $auth_user->runQuery("SELECT * FROM masterrecruitment WHERE id=:recruitment_id");
		$stmt->execute(array(":recruitment_id"=>$recruitment_id));
		while ($recrRow = $stmt->fetch(PDO::FETCH_ASSOC))
		{			
			$fdistid = $recrRow['distid'];	
			$frecruitmentname = $recrRow['name'];	
			
			$fstartdate = date("d-m-Y", strtotime($recrRow['startdate']));//dd-mm-yyyy			
			$fenddate = date("d-m-Y", strtotime($recrRow['enddate']));//dd-mm-yyyy			
			$fageondate = date("d-m-Y", strtotime($recrRow['ageondate']));//dd-mm-yyyy			
			
			$fpaymentmode = $recrRow['paymentmode'];
			$fpaymenturl = $recrRow['paymenturl'];
			$frecruitmentinfo = $recrRow['recruitmentinfo'];
		}
	}
	else /* If new, then this part will be run. */
	{
		$stmt = $auth_user->runQuery("SELECT MAX(id) id FROM masterrecruitment");
		$stmt->execute();
		$count = $stmt->rowCount();
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if($count== 1)
		{
			if($userRow['id']=="")
			{
				$rid=1;	
			}
			else 
			{
				$rid=$userRow['id']+1;	
			}
		}
	}
	
	
	if(isset($_POST['btnSubmit'])) 
	{						
		/* Checking in both mode(Add New / Edit), whether the fields are properly filled or not.*/
		$DistId = $_POST['cmbDistId'];		
		
		$RecruitmentName = $_POST['txtRecruitmentName'];		
		$RecruitmentName = trim($RecruitmentName);	
		
		$SDate = $_POST['txtStartDate'];		
		$SDate = trim($SDate);		
		$StartDate = date("Y-m-d", strtotime($SDate)); //yy-mm-dd
		
		$EDate = $_POST['txtEndDate'];		
		$EDate = trim($EDate);
		$EndDate = date("Y-m-d", strtotime($EDate)); //yy-mm-dd
		
		$AODate = $_POST['txtAgeonDate'];		
		$AODate = trim($AODate);
		$AgeonDate = date("Y-m-d", strtotime($AODate)); //yy-mm-dd
				
		$PaymentMode = $_POST['payMode'];	
		
		$PaymentUrl= $_POST['txtPaymentUrl'];
		
		$RecruitmentInfo=  $_POST['txtRecruitmentInfo'];	
		$RecruitmentInfo = trim($RecruitmentInfo);
		
		if($DistId==0)
		{
		?>
		<script type="text/javascript">
		alert('Please Select District');
		</script>
		<?php
		}
		else if($StartDate=="")
		{
		?>
		<script type="text/javascript">
		alert('Please enter Start Date of Recruitment');
		</script>
		<?php
		}
		else if($EndDate=="")
		{
		?>
		<script type="text/javascript">
		alert('Please enter End Date of Recruitment');
		</script>
		<?php
		}
		
		else
		{		
			if(isset($_GET['id'])) /* if press submit button in Edit mode then this part will work.*/
			{
				/* In edit mode run update command*/
					$stmt = $auth_user->runQuery("UPDATE masterrecruitment SET name=:recruitment_name,distid=:did,startdate=:sdate,enddate=:edate,ageondate=:ageondate,paymentmode=:paymentmode,paymenturl=:purl,recruitmentinfo=:recruitmentinfo WHERE id=:recruitment_id");
					$stmt->execute(array(":recruitment_name"=>$RecruitmentName,":did"=>$DistId,":sdate"=>$StartDate,":edate"=>$EndDate,":ageondate"=>$AgeonDate,":paymentmode"=>$PaymentMode,":purl"=>$PaymentUrl,":recruitmentinfo"=>$RecruitmentInfo,":recruitment_id"=>$recruitment_id));				
					?>
					<script type="text/javascript">
					alert("Recruitment Updated Successfully...!");
					window.location.href = "admin-recruitment.php";
					</script>
					<?php
					
			}
			else
			{
				/* In Add New mode run insert command*/
				$stmt = $auth_user->runQuery("INSERT into masterrecruitment (id,name,distid,startdate,enddate,ageondate,paymentmode,paymenturl,recruitmentinfo)values(:rec_id,:name,:did,:sdate,:edate,:ageondate,:paymentmode,:purl,:recruitmentinfo)");
				$stmt->execute(array(":rec_id"=>$rid,":name"=>$RecruitmentName,":did"=>$DistId,":sdate"=>$StartDate,":edate"=>$EndDate,":ageondate"=>$AgeonDate,":paymentmode"=>$PaymentMode,":purl"=>$PaymentUrl,":recruitmentinfo"=>$RecruitmentInfo));
				?>
				<script type="text/javascript">
				alert("Recruitment Added Successfully...!");
				window.location.href = "admin-recruitment.php";
				</script>
				<?php
			}
			
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
                    <h4 class="page-head-line"><span class="fa fa-briefcase"></span> Manage Recruitment</h4>
                </div>
            </div>
            
			<div class="row" >
				<div class="col-md-12 col-sm-12" >                                           
						<div style="border:1px solid #02A67D;">
                            <ul id="mytabs" class="nav nav-tabs">
                                <li class="active"><a href="#list" data-toggle="tab"><span class="fa fa-reorder"></span> Recruitment List</a>
                                </li>
                                <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="<?php if(isset($_GET['id'])){echo 'fa fa-edit';} else {echo 'fa fa-plus';}?>"></span><?php if(isset($_GET['id'])){echo ' Edit Recruitment';} else {echo ' Add Recruitment';}?> </a>
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
											<table class="table table-hover table-striped table-bordered" id="sampleTable">			<thead>		
												<th>#</th>
												<th>Recruitment Name</th>
												<th>District</th>
												<th>Recruitment Start Date</th>
												<th>Recruitment End Date</th>
												<th>Age on Date</th>
												<th>Payment Mode</th>
												<th>Payment URL</th>
												<th>Recruitment Info</th>
												<th>Options</th>
											</thead>											
												<tbody>
													<?php
													if($admindist!=0)
													{
														// District Admin Login
														$Qury="SELECT mr.id,mr.name,mr.startdate,mr.enddate,mr.ageondate,mr.paymentmode,mr.paymenturl,mr.recruitmentinfo,md.name as distname FROM masterrecruitment mr,masterdist md WHERE mr.distid=$admindist AND md.id=mr.distid";
													}
													else{
														//Super Admin Login
														$Qury="SELECT mr.id,mr.name,mr.startdate,mr.enddate,mr.ageondate,mr.paymentmode,mr.paymenturl,mr.recruitmentinfo,md.name as distname FROM masterrecruitment mr,masterdist md WHERE md.id=mr.distid";
													}
													$stmt = $auth_user->runQuery($Qury);
													$stmt->execute();
													$num_rows = 0;
													while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
													{
														$num_rows++;
														$vrecruitmentid =$userRow['id'];
														$vrecruitmentname = $userRow['name'];
														$vdistname = $userRow['distname'];
														$vstartdate = date("d-m-Y", strtotime($userRow['startdate']));//dd-mm-yyyy			
														$venddate = date("d-m-Y", strtotime($userRow['enddate']));//dd-mm-yyyy			
														$vageondate = date("d-m-Y", strtotime($userRow['ageondate']));//dd-mm-yyyy			
														$vpaymentmode = $userRow['paymentmode'];	
														$vpaymenturl = $userRow['paymenturl'];		
														$vrecruitmentinfo = $userRow['recruitmentinfo'];	
													?>
													<tr>	
														<td><?php echo $num_rows; ?></td>
                                                        <td><?php echo $vrecruitmentname; ?></td>
                                                        <td><?php echo $vdistname; ?></td>
														<td><?php echo $vstartdate; ?></td>
                                                        <td><?php echo $venddate; ?></td>
														<td><?php echo $vageondate; ?></td>
														<td><?php if($vpaymentmode==0){echo  'Draft';}else if($vpaymentmode==1){echo 'Online';}else{echo '<a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-remove" ></span></a>';} ?></td>
                                                        <td><?php echo $vpaymenturl; ?></td>
														<td><?php echo $vrecruitmentinfo; ?></td>
														<td align="center">
														<!--Edit Button !-->
														<a href="admin-recruitment.php?id=<?php echo $vrecruitmentid;?>" style="outline:none;" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-wrench changetabbutton" ></span> &nbsp;Edit</a>
														<!--Delete Button !-->
														<a href="#" data-href="delete.php?del_rec_id=<?php echo $vrecruitmentid;?>"  style="outline:none;" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash"></span> &nbsp;Delete
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
                                <div class="tab-pane fade" id="add" style="margin-left:15px;margin-right:15px;"><br/>				
                                    <div class="row">
                                        <div class="col-lg-offset-2 col-lg-8">
                                            <form  role="form" method="post">														
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         District Name
                                                     </div>
                                                     <div class="col-lg-9">
                                                         <select id="cmbDistId" name="cmbDistId" class="selectpicker" data-live-search="true" title="Please Select District" required>
                                                            <?php
																if($admindist!=0)
																{
																	// District Admin Login
																	$DistQury="SELECT id,name FROM masterdist WHERE id=$admindist ORDER BY name";
																}
																else{
																	//Super Admin Login
																	$DistQury="SELECT id,name FROM masterdist ORDER BY name";
																}
                                                                $stmt = $auth_user->runQuery($DistQury);// Run your query		
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

                                                        </select>
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         Recruitment Name
                                                     </div>
                                                     <div class="col-lg-9">
                                                         <input type="text" class="form-control" name="txtRecruitmentName" value="<?php if(isset($_GET['id'])){echo $frecruitmentname;}?>" required />
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         Recruitment Start Date
                                                     </div>
                                                     <div class="col-lg-9">
                                                        <input type="text" class="cal form-control" style="background-color:#FFF;" name="txtStartDate" value="<?php if(isset($_GET['id'])){echo $fstartdate ;}?>" required readonly /> 
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         Recruitment End Date
                                                     </div>
                                                     <div class="col-lg-9">
                                                        <input type="text" class="cal form-control" style="background-color:#FFF;" name="txtEndDate" value="<?php if(isset($_GET['id'])){echo $fenddate  ;}?>"  required readonly />
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         Age On Date
                                                     </div>
                                                     <div class="col-lg-9">
                                                        <input type="text" class="cal form-control" style="background-color:#FFF;" name="txtAgeonDate" value="<?php if(isset($_GET['id'])){echo $fageondate  ;}?>"  required readonly />
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         Payment Mode
                                                     </div>
                                                     <div class="col-lg-9">
                                                        <?php
                                                            if(isset($_GET['id'])){
                                                            ?>
                                                            <select onchange="show_hide_url(this.value)" class="form-control" id="payMode" name="payMode">
                                                            <option <?php if($fpaymentmode== 0){ echo 'selected="selected"'; }else{ echo ''; } ?> value="0">Draft</option>
                                                            <option <?php if($fpaymentmode== 1){ echo 'selected="selected"'; }else{ echo ''; } ?> value="1">Online</option>
                                                            <option <?php if($fpaymentmode== 2){ echo 'selected="selected"'; }else{ echo ''; } ?> value="2">None</option>
                                                           </select>
                                                            <?php

                                                            }
                                                            else{
                                                        ?>
                                                         <select onchange="show_hide_url(this.value)" class="form-control" id="payMode" name="payMode" required>
                                                            <option value="">Choose Payment Mode</option>
                                                            <option value="0">Draft</option>
                                                            <option value="1">Online</option>
                                                            <option value="2">None</option>
                                                        </select>
                                                        <?php
                                                            }
                                                        ?>
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;<?php if(isset($_GET['id'])&& $fpaymentmode== 1){ echo 'display:block;'; }else{ echo ''; } ?> ;" id="url-div">
                                                     <div class="col-lg-3" style="text-align:right;font-weight:bold;font-size:15px;">
                                                         Payment URL
                                                     </div>
                                                     <div class="col-lg-9">
                                                         <input placeholder="Enter URL" type="url" id="txtPaymentUrl" class="form-control" style="background-color:#FFF;" name="txtPaymentUrl" value="<?php if(isset($_GET['id'])){echo $fpaymenturl ;}?>"/>
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3" style="padding-top:10px;text-align:right;font-weight:bold;font-size:15px;">
                                                         Recruitment Info
                                                     </div>
                                                     <div class="col-lg-9">
                                                        <textarea class="cal form-control" name="txtRecruitmentInfo" required><?php if(isset($_GET['id'])){echo $frecruitmentinfo ;}?></textarea> 
                                                     </div>
                                                 </div>
                                                 <div class="row" style="margin:7px auto;">
                                                     <div class="col-lg-3">
                                                     
                                                     </div>
                                                     <div class="col-lg-9">
                                                        <!--Submit Button !-->
                                                    <button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="<?php if(isset($_GET['id'])){echo 'glyphicon glyphicon-edit';} else {echo 'glyphicon glyphicon-plus';}?>"></span> &nbsp;<?php if(isset($_GET['id'])){echo 'Edit Recruitment';} else {echo 'Add Recruitment';}?></button>

                                                    <!--Cancel Button !-->
                                                    <a href="admin-recruitment.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>
                                                     </div>
                                                 </div>	
                                            </form>
                                        </div>
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
    /*--Tab Control Jquery Section--*/
    /*--Start Tab Control Section--*/
     $(document).ready(function(){			
            $('.nav-tabs a[href="#add"]').tab('show');
        
        /*--Add New Recruitment Form Submit--*/
           /*  $('#add-form').on('submit', function(e){
                e.preventDefault();
                var dist_id = $('#cmbDistId').val();
                var name = $.trim($('#txtRecruitmentName').val());
                var s_date = $.trim($('#txtStartDate').val());
                var e_date = $.trim($('#txtEndDate').val());
                var a_o_date = $.trim($('#txtAgeonDate').val());
                var pay_mode = $('#payMode').val();
                var url = $.trim($('#txtPaymentUrl').val());
                var info = $.trim($('#txtRecruitmentInfo').val());
                if(dist_id == "")
                {
                   alert('Oops! select district name to proceed.');
                   return false;
                }
                else if(name == "")
                {
                   alert('Oops! enter name to proceed.');
                   return false;
                }
                else if(s_date == "")
                {
                   alert('Oops! enter start date to proceed.');
                   return false;
                }
                else if(e_date == "")
                {
                   alert('Oops! enter end date to proceed.');
                   return false;
                }
                else if(a_o_date == "")
                {
                   alert('Oops! enter age on date to proceed.');
                   return false;
                }
                else if(pay_mode == "")
                {
                   alert('Oops! select payment mode to proceed.');
                   return false;
                }
                else
                {
                    if(pay_mode == 1)
                    {
                        if(url == "")
                        {
                           alert('Oops! enter url.');
                           return false;
                        }
                        else
                        {
                            if(info == "")
                            {
                               alert('Oops! enter info.');
                               return false;
                            }
                        }
                    }
                    else
                    {
                        if(info == "")
                        {
                           alert('Oops! enter info.');
                           return false;
                        }
                    }
                    /* After successful form validation this part will be executed */
                   /* $.ajax({
                        type:"POST",
                        url:"post-data/data.php",
                        cache:false,
                        contentType:false,
                        processData:false,
                        data:new FormData(this),
                        success:function(d){
                            alert(d);
                        }
                    });
                }
            }); */
        /*--Add New Recruitment Form Submit--*/
         
    });
    
    /*Payment URL Function*/
    function show_hide_url(value)
    {
        if(value == 1)
        {
			 document.getElementById('url-div').style.display="block";
        }
        else
        {
			document.getElementById('url-div').style.display="none";
            document.getElementById('txtPaymentUrl').value="";
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