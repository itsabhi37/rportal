<ul class="pager wizard">
             <?php
					$res=mysql_query("SELECT status FROM status");
					$row=mysql_fetch_array($res);
					
					$status = $row['status'];
					if($status==2)
					{                                                  
					echo '<li class="next"><img src="assets/img/nextbtn.png" align="right" style="width:120px; height:35px" class="button button2"></li>';
					}
					else if($status==3)
					{
					echo '<li class="next"><img src="assets/img/nextbtn.png" align="right" style="width:120px; height:35px" class="button button2"></li>';
					echo '<li class="previous"><img src="assets/img/prevbtn.png" align="left" style="width:120px; height:35px" class="button button2"></li>';
					}
					else if($status==4)
					{
						
					}
					else if($status==4 ||$status==5)
					{
					}
					else if($status==6)
					{
						
					}
                    ?>
</ul>