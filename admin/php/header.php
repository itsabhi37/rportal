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
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
	<!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="assets/css/bootstrap-select.css">
	
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css"/>
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<script>
	$(function() {
		$( ".cal" ).datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "1980:2025",
		});
	});    
	</script>
	<script type="text/javascript">
	//Function for Accepting Only Integer Value
			var specialKeys = new Array();
			specialKeys.push(8); //Backspace
			function IsNumeric(e,spanname) {
				var keyCode = e.which ? e.which : e.keyCode
				var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
				document.getElementById(spanname).style.display = ret ? "none" : "inline";
				return ret;
			}
	</script>
    <script>
	//Function for Accepting Only Float Value
	$(function () {
		$('.filterme').keypress(function(eve) {
		  if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
			eve.preventDefault();
		  }
			 
		// this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
		 $('.filterme').keyup(function(eve) {
		  if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
		  }
		 });
		});
	});
	</script> 
</head>
<body>
    <header>
        <div class="container text-left">
            <div class="row">
                <div class="col-md-12">				
					<img src="assets/img/logo.png"/>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END-->
	<header>
        <div class="row">
            <div class="col-md-12">