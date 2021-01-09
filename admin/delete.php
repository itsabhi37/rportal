<?php
	require_once("php/session.php");	
	require_once("php/class.user.php");
	$delete_data = new USER();
	
	//DELETE District 
	if(isset($_GET['del_dist_id'])&& $session->is_loggedin())
	{
		$delete_district_id=$_GET['del_dist_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM masterdist WHERE id=:delete_district_id");
		$delstmt->execute(array(":delete_district_id"=>$delete_district_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-dist.php";
		</script>
		<?php
	}
	
	//DELETE Recruitment 
	if(isset($_GET['del_rec_id'])&& $session->is_loggedin())
	{
		$delete_recruitment_id=$_GET['del_rec_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM masterrecruitment WHERE id=:delete_recruitment_id");
		$delstmt->execute(array(":delete_recruitment_id"=>$delete_recruitment_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-recruitment.php";
		</script>
		<?php
	}
	
	//DELETE Post 
	if(isset($_GET['del_post_id'])&& $session->is_loggedin())
	{
		$delete_post_id=$_GET['del_post_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM masterpost WHERE id=:delete_post_id");
		$delstmt->execute(array(":delete_post_id"=>$delete_post_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-post.php";
		</script>
		<?php
	}
	//DELETE Account 
	if(isset($_GET['del_acnt_id'])&& $session->is_loggedin())
	{
		$delete_account_id=$_GET['del_acnt_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM adminlogin WHERE adminid=:delete_acnt_id");
		$delstmt->execute(array(":delete_acnt_id"=>$delete_account_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-accountmanager.php";
		</script>
		<?php
	}
	
	//DELETE Exam 
	if(isset($_GET['del_exam_id'])&& $session->is_loggedin())
	{
		$delete_exam_id=$_GET['del_exam_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM masterexam WHERE id=:delete_exam_id");
		$delstmt->execute(array(":delete_exam_id"=>$delete_exam_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-exam.php";
		</script>
		<?php
	}
	
	//DELETE Result 
	if(isset($_GET['del_result_id'])&& $session->is_loggedin())
	{
		$delete_result_id=$_GET['del_result_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM resultdetails WHERE id=:delete_result_id");
		$delstmt->execute(array(":delete_result_id"=>$delete_result_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-result.php"; 
		</script>
		<?php
	}
	
	//DELETE Result 
	if(isset($_GET['del_advrtsmnt_id'])&& $session->is_loggedin())
	{
		$delete_advertisement_id=$_GET['del_advrtsmnt_id'];
		
		$delstmt = $delete_data->runQuery("DELETE FROM advertisementdetails WHERE id=:delete_advertisement_id");
		$delstmt->execute(array(":delete_advertisement_id"=>$delete_advertisement_id));	
		
		?>
		<script type="text/javascript">
		window.location.href = "admin-advertisement.php"; 
		</script>
		<?php
	}
	
?>