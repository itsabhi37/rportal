<?php
require_once("php/class.user.php");
include_once('php/header.php'); /*Header Section Include Here*/
$show_rec = new USER();
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">All Notifications / Advertisement Details</h4>

                </div>

            </div>
            <div class="row text-center ">

                <?php
					$stmt = $show_rec->runQuery("SELECT id,name,recruitmentinfo FROM masterrecruitment ORDER by enddate ASC");// Run your query	
					$stmt->execute();
					$num_rows = 0;
					while ($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						$num_rows++;
						$recruitmentid = $userRow['id'];
						$recruitmentname = $userRow['name'];
						$recruitmentinfo = $userRow['recruitmentinfo'];	
						$classmsg="";
						
						// For Advertisement
						$adver = $show_rec->runQuery("SELECT filename FROM advertisementdetails WHERE recruitmentid=$recruitmentid");// Run your query	
						$adver->execute();
						$count = $adver->rowCount();
						$adverRow = $adver->fetch(PDO::FETCH_ASSOC);
						
						if($count== 1)
						{
							$rfilename='admin/advertisements/'.$adverRow['filename'];							
						}
						else{
							$rfilename='index.php';
						}
						
						// For Result
						$reslt = $show_rec->runQuery("SELECT filename FROM resultdetails WHERE recruitmentid=$recruitmentid");// Run your query	
						$reslt->execute();
						$count = $reslt->rowCount();
						$adverRow = $reslt->fetch(PDO::FETCH_ASSOC);
						
						if($count== 1)
						{
							$rsltfilename='Admin/results/'.$adverRow['filename'];							
						}
						else{
							$rsltfilename='';
						}
						
						?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="<?php
								if($num_rows%2==0)
								{
									 echo 'alert alert-info text-center';
									 $classmsg='btn btn-info';
								}
								else if($num_rows%3==0)
								{
									
									echo 'alert alert-danger text-center';
									$classmsg='btn btn-danger';
								}
								else
								{
									echo 'alert alert-success text-center';
									$classmsg='btn btn-success';
								}
							 ?>">
                            <h4>
                                <?php echo $recruitmentname;?> </h4>
                            <hr />

                            <p>
                                <?php echo $recruitmentinfo;?>
                            </p>
                            <hr />

                            <a href="<?php echo $rfilename;?>" target="_blank" class="<?php echo $classmsg;?>"><span class="fa fa-download"></span> Download Advertisement</a>
                            <a href="registration.php" class="<?php echo $classmsg;?>"><span class="fa fa-sign-in"></span> Apply Now</a>
							<?php 
							if($rsltfilename!=''){
								echo '<a href="'.$rsltfilename.'" target="_blank" class="'.$classmsg.'"><span class="fa fa-download"></span> Download Result</a>';
							}
							?>
                        </div>
                    </div>
                    <?php
					}
				?>


            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php  
include_once('php/footer.php'); /*Footer Section Include Here*/
?>