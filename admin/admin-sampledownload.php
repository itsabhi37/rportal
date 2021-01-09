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
	if(isset($_POST['btnSubmit'])) /* if press submit button in Add new mode then this part will work.*/
	{		
		
		/* Checking in both mode(Add New / Edit), whether the fields are properly filled or not.*/
		$RecruitmentId = $_POST['cmbRecruitmentId'];		
		$RecruitmentId = trim($RecruitmentId);	
		if($RecruitmentId!=0)
		{		
            $stmt = $auth_user->runQuery("SELECT * FROM masterrecruitment WHERE id=:recruitment_id");
            $stmt->execute(array(":recruitment_id"=>$RecruitmentId));
		      while ($recRow = $stmt->fetch(PDO::FETCH_ASSOC))
		      {			
                $paymentmode = $recRow['paymentmode'];
		      }
            if($paymentmode==0){
                // Draft Mode Payment
                ?>
                <script type="text/javascript">
                    window.open('sample/rportal_sample.xlsx', '_blank');
                </script>
            <?php
            }else{
                // Payment Mode None
                ?>
                <script type="text/javascript">
                    window.open('sample/rportal_sample_wd.xlsx', '_blank');
                    /*location.href="sample/rportal_sample_wd.xlsx";*/
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
                            <h4 class="page-head-line"><span class="fa fa-download"></span> Sample Downloader</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div style="border:1px solid #02A67D;">
                                <ul id="mytabs" class="nav nav-tabs">
                                    <li class=""><a id="#add" href="#add" data-toggle="tab"><span class="fa fa-download"></span> Sample Download</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!--Download Sample Download-->
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
                                                        <td width="30%" align="right" style="border-color:transparent;"></td>
                                                        <td width="40%" align="left" style="font-size:13px;border-color:transparent;">

                                                            <!--Submit Button !-->
                                                            <button type="submit" style="outline:none;" class="btn btn-danger" name="btnSubmit"><span class="glyphicon glyphicon-download"></span> Download </button>

                                                            <!--Cancel Button !-->
                                                            <a href="admin-sampledownload.php" style="outline:none;" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> &nbsp;Cancel</a>

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
                    </div>
                </div>
            </div>
            <!-- CONTENT-WRAPPER SECTION END-->
            <?php
include_once "php/footer.php";
?>
                <script>
                    $(document).ready(function() {
                        $('.nav-tabs a[href="#add"]').tab('show');
                    });
                </script>