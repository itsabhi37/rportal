<?php
date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Recruitment Portal</title>
    <link rel="icon" href="assets/img/logo.png" type="image/png">
    <!-- Additional Jquery file -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- custom styles -->
    <link href="assets/css/custom.css" rel="stylesheet">
    <link href="assets/css/prettify.css" rel="stylesheet">

    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/animate.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLE CSS -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/bootstrap-select.css">
    <!-- GOOGLE FONT CSS -->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <style>
        body {
            font-family: 'Droid Sans', sans-serif;
        }
    </style>
    <script>
        $(function() {
            $(".cal").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "1970:2025",
            });
        });
    </script>
</head>

<body>
    <section class="sec-logo">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="assets/img/logo.png" alt="Recruitment Portal" />
                </div>
                <!--<div class="col-md-6" style="text-align:right;">
				<a href="registration.php" class="label label-success"><span class="fa fa-user"></span> Applicant Login</a>
				<a href="admin/index.php" class="label label-danger"><span class="fa fa-lock"></span> Admin Login</a>
                </div>-->
                <div class="col-md-10">
                    <i class="pull-right quick-info"> <i class="fa fa-envelope " aria-hidden="true"></i> info.recruitmentportal@gmail.com</i> <br/><br/>
                    
                    <?php if(basename($_SERVER['PHP_SELF'])=='index.php'){?>
                    <div class="dropdown pull-right">
                        <button class="btn btn-sm btn-danger dropdown-toggle" type="button" data-toggle="dropdown"><span class="fa fa-lock"></span> Login
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="registration.php"><span class="fa fa-user"></span> Applicant Login</a></li>
                            <li><a href="admin/index.php"><span class="fa fa-lock"></span> Admin Login</a></li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!--LOGO SECTION END
     <section class="sec-menu" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				<i class="pull-right"> Welcome To The Online Recruitment Portal</i>   
                </div>
            </div>
        </div>
    </section>-->