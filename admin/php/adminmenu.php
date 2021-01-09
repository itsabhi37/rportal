<?php
//Include Commnon Header Part
require_once("session.php");	
require_once("class.user.php");

$menu = new USER();
$admin_type=$_SESSION['admin_type'];
?>

<style>
.navbar-default {
    background-color:#02a67d;
    border-color:#02a67d;
	border-radius:0;
}
/* title */
.navbar-default .navbar-brand {
    color: #ffffff;
}
.navbar-default .navbar-brand:hover,
.navbar-default .navbar-brand:focus {
    color: #d9d9d9;
}
/* link */
.navbar-default .navbar-nav > li > a {
    color: #ffffff;
}
.navbar-default .navbar-nav > li > a:hover,
.navbar-default .navbar-nav > li > a:focus {
    color: #333;
}
.navbar-default .navbar-nav > .active > a, 
.navbar-default .navbar-nav > .active > a:hover, 
.navbar-default .navbar-nav > .active > a:focus {
    color: #fff;
    background-color: #000;
}
.navbar-default .navbar-nav > .open > a, 
.navbar-default .navbar-nav > .open > a:hover, 
.navbar-default .navbar-nav > .open > a:focus {
    color: #fff;
    background-color: #000;
}
/* caret */
.navbar-default .navbar-nav > .dropdown > a .caret {
    border-top-color: #fff;
    border-bottom-color: #fff;
}
.navbar-default .navbar-nav > .dropdown > a:hover .caret,
.navbar-default .navbar-nav > .dropdown > a:focus .caret {
    border-top-color: #333;
    border-bottom-color: #333;
}
.navbar-default .navbar-nav > .open > a .caret, 
.navbar-default .navbar-nav > .open > a:hover .caret, 
.navbar-default .navbar-nav > .open > a:focus .caret {
    border-top-color: #555;
    border-bottom-color: #555;
}
/* Dropdown Background */
.navbar-default .navbar-nav .open .dropdown-menu>li>a, .navbar-default .navbar-nav .open .dropdown-menu {
    background-color: #fff;
    color:#333;
  }
  	.navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
        color: #fff;
		background-color: #02a67d;
    }
/* mobile version */
.navbar-default .navbar-toggle {
    border-color: #fff;
}
.navbar-default .navbar-toggle:hover,
.navbar-default .navbar-toggle:focus {
    background-color: #777;
}
.navbar-default .navbar-toggle .icon-bar {
    background-color: #fff;
}
@media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
        background-color: #fff;
    	color:#333;
    }
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
        color: #fff;
		background-color: #02a67d;
    }
}
body { overflow-x: hidden;}
	.carousel-inner > .item > img,
  	.carousel-inner > .item > a > img {
      width: 100%;
      margin: auto;
	}
</style>
	<div id="menu">
			<nav class="col-lg-offset-1 col-lg-10 navbar navbar-light navbar-default">
			  <div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				  </button>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
				  <ul class="nav navbar-nav">
					<li><a href="admin-dashboard.php">Home</a></li>
					<li class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Details <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="admin-applicationverifier.php">Applications Verifier</a></li>						
						<li><a href="admin-applicationfinder.php">Applications Finder</a></li>
						<hr/>						
						<li><a href="admin-exam-map.php">Applicant Exam Mapper</a></li>
						<li><a href="admin-admitcarddownloader.php">Admit Card Downloader</a></li>
					  </ul>
					</li>					
					<li class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Master <span class="caret"></span></a>
					  <ul class="dropdown-menu">
					  <?php
						if($admin_type=="Super Admin")
						{
							echo '<li><a href="admin-dist.php">Master District</a></li>';
						}					
						?>
						<li><a href="admin-recruitment.php">Master Recruitment</a></li>
						<li><a href="admin-post.php">Master Post</a></li>
						<li><a href="admin-exam.php">Master Exam</a></li>
						<li><a href="admin-advertisement.php">Advertisement Uploader</a></li>
						<li><a href="admin-result.php">Result Uploader</a></li>
					  </ul>
					</li>
					<?php
						if($admin_type=="Super Admin")
						{
							echo '<li><a href="admin-accountmanager.php">Account Manager</a></li>';
						}					
						?>
                    <li class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Offline Mode <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="admin-sampledownload.php">Sample Download</a></li>						
						<li><a href="admin-sampleupload.php">Upload Data</a></li>
					  </ul>
					</li>
				  </ul>
				  <ul class="nav navbar-nav navbar-right">
					<li><a href="logout.php?logout=true">Logout</a></li>
				  </ul>
				</div>
			  </div>
			</nav>
	</div>