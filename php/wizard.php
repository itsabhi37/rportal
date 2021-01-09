<ul>
                    <li ><span class="label">1</span> Registration / Login</li>
                    <?php
					
					$stmt = $auth_user->runQuery("SELECT status FROM registrationdetails where applicantid=:applicantid");
					$stmt->execute(array(":applicantid"=>$applicantid));
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$status = $row['status'];
					
					if($status==1)
					{
						echo '<li><a href="#tab1" data-toggle="tab" class=""><span class="label">2</span> Personal Details</a></li>';
						echo '<li><a href="#tab2" data-toggle="tab" class="disabled"><span class="label">3</span> Educational Details</a></li>';
						echo '<li><a href="#tab3" data-toggle="tab" class="disabled"><span class="label">4</span> Experience Details</a></li>';
						echo '<li><a href="#tab4" data-toggle="tab" class="disabled"><span class="label">5</span> Upload Images</a></li>';
						echo '<li><a href="#tab5" data-toggle="tab" class="disabled"><span class="label">6</span> Print Application</a></li>';
					}
					else if($status==2)
					{
						echo '<li><a href="#tab1" data-toggle="tab" class=""><span class="label">2</span> Personal Details</a></li>';
						echo '<li><a href="#tab2" data-toggle="tab" class=""><span class="label">3</span> Educational Details</a></li>';
						echo '<li><a href="#tab3" data-toggle="tab" class="disabled"><span class="label">4</span> Experience Details</a></li>';
						echo '<li><a href="#tab4" data-toggle="tab" class="disabled"><span class="label">5</span> Upload Images</a></li>';
						echo '<li><a href="#tab5" data-toggle="tab" class="disabled"><span class="label">6</span> Print Application</a></li>';
					}
					else if($status==3)
					{
						echo '<li><a href="#tab1" data-toggle="tab" class=""><span class="label">2</span> Personal Details</a></li>';
						echo '<li><a href="#tab2" data-toggle="tab" class=""><span class="label">3</span> Educational Details</a></li>';
						echo '<li><a href="#tab3" data-toggle="tab" class=""><span class="label">4</span> Experience Details</a></li>';
						echo '<li><a href="#tab4" data-toggle="tab" class="disabled"><span class="label">5</span> Upload Images</a></li>';
						echo '<li><a href="#tab5" data-toggle="tab" class="disabled"><span class="label">6</span> Print Application</a></li>';
					}
					else if($status==4 ||$status==5)
					{
						echo '<li><a href="#tab1" data-toggle="tab" class=""><span class="label">2</span> Personal Details</a></li>';
						echo '<li><a href="#tab2" data-toggle="tab" class=""><span class="label">3</span> Educational Details</a></li>';
						echo '<li><a href="#tab3" data-toggle="tab" class=""><span class="label">4</span> Experience Details</a></li>';
						echo '<li><a href="#tab4" data-toggle="tab" class=""><span class="label">5</span> Upload Images</a></li>';
						echo '<li><a href="#tab5" data-toggle="tab" class="disabled"><span class="label">6</span> Print Application</a></li>';
					}
					else if($status==6)
					{
						echo '<li ><span class="label">2</span> Personal Details</li>';
						echo '<li ><span class="label">3</span> Educational Details</li>';
						echo '<li ><span class="label">4</span> Experience Details</li>';
						echo '<li ><span class="label">5</span> Upload Images</li>';
						echo '<li><a href="#tab5" data-toggle="tab" class="disabled"><span class="label">6</span> Print Application</a></li>';
					}
                    ?>
</ul>