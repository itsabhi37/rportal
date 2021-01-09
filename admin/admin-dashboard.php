<?php
//Include Commnon Header Part
require_once("php/header.php");
require_once("php/session.php");	
require_once("php/class.user.php");
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
                    <h4 class="page-head-line"><span class="fa fa-desktop"></span> Admin Dashboard</h4>
                </div>
            </div>            
            <div class="row">
                 <div class="col-md-2 col-sm-2 col-xs-6">
				 <a href="admin-dashboard.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-desktop dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
  </div>
                           
</div>
                         <h5>Dashboard</h5>
                    </div>
				</a>
                </div>
						<?php
							if($admin_type=="Super Admin")
							{
						?>
							
                 <div class="col-md-2 col-sm-2 col-xs-6">
				 <a href="admin-dist.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-map-marker dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>Master District</h5>
                    </div>
				</a>
                </div>
				<?php } ?>
				
				<div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-advertisement.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-file-pdf-o dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>File Uploader</h5>
                    </div>
				</a>
                </div>
				
                 <div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-recruitment.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-briefcase dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
  </div>
                           
</div>
                         <h5>Master Recruitment</h5>
                    </div>
				</a>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-post.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-bookmark dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>Master Post</h5>
                    </div>
				</a>
                </div>
				 <div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-exam.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-graduation-cap dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>Manage Exam</h5>
                    </div>
				</a>
                </div>
				 <div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-exam-map.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-exchange dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>Examination Mapper</h5>
                    </div>
				</a>
                </div>
				
				<div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-result.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-trophy dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>Result Uploader</h5>
                    </div>
				</a>
                </div>
				<div class="col-md-2 col-sm-2 col-xs-6">
				<a href="admin-accountmanager.php" style=" text-decoration:none;">
                    <div class="dashboard-div-wrapper bk-clr-one">
                        <i  class="fa fa-cogs dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
						  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
												   
						</div>
                         <h5>Account Manager</h5>
                    </div>
				</a>
                </div>
            </div>
			
			<!--<div class="row">
				
				<div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-three">
                        <i  class="fa fa-question dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
  </div>
                           
</div>
                         <h5>Question</h5>
                    </div>
                </div>
                 <div class="col-md-2 col-sm-2 col-xs-6">
                    <div class="dashboard-div-wrapper bk-clr-three">
                        <i  class="fa fa-graduation-cap dashboard-div-icon" ></i>
                        <div class="progress progress-striped active">
  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
  </div>
                           
</div>
                         <h5>Result</h5>
                    </div>
                </div>                 
            </div> -->
           <!--Start here if want to show something!-->
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
<?php
include_once "php/footer.php";
?>