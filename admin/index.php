<?php
session_start();
require_once("php/headerlg.php");
require_once("php/class.user.php");

$login = new USER();
if($login->is_loggedin()!="")
{
	$login->redirect('admin-dashboard.php');
}
if(isset($_POST['btnLogin']))
{
	$aname = $_POST['txtAdminId'];		
	$aname = trim($aname);
	
	$apass = $_POST['txtPassword'];		
	$apass = trim($apass);
	
	if($aname=="")	{
		$error = "Please provide username !";	
	}
	else if($apass=="")	{
		$error = "Please provide Password!";	
	}
	else{
	
		if($login->doLogin($aname,$apass))
		{
			$login->redirect('admin-dashboard.php');
		}
		else
		{
			$error = "Incorrect Login Credentials, Please try again !";
		}	
	}
}
?>
    <!-- LOGO HEADER END-->
   
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Login To Online Recruitment Portal (Admin Panel) </h4>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
					<form role="form" method="post">
						<!--Form for accept input !-->
						<!--START !-->
						
						<label>Enter Admin Username : </label>
                        <input type="text" placeholder="Admin Username" class="form-control" name="txtAdminId" required />
                        <label>Enter Password :  </label>
                        <input type="password" placeholder="Password" class="form-control" name="txtPassword" required />
                        <hr />
						<button type="submit" style="outline:none" class="btn btn-success" name="btnLogin"><span class="glyphicon glyphicon-user"></span> &nbsp;Log Me In</button>
						
                        <!--END !-->

                        <!--Error Message Section !-->
                        <!--START !-->
                        <div id="msg" style="color:#F00; text-align:center;">
                        	<?php
                            		if(isset($error) && $error!="")
									{
										echo $error;
									}
							?>
                        </div>
                        <!--END !-->
					</form>
                </div>
				<br/>
                <div class="col-md-6">
                    <div class="alert alert-success">
                         <strong> Instructions To Login:</strong>
                        <ul>
                            <li>
								Login with your Admin Username & Password.
                            </li>
                            <li>
                                Username & Password fields are case-sensitive.
                            </li>
                            <li>
                               Don't share your Admin Username or Password with anyone.
                            </li>
                            <li>
								If you're unable to Login or Register new account, kindly contact SA.
                            </li>
                        </ul>
                       
                    </div>                    
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
<?php
include_once "php/footer.php";
?>