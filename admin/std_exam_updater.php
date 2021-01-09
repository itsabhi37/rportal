<?php
	require_once("php/session.php");	
	require_once("php/class.user.php");
	$update_exam_data = new USER();
	
	if(empty($_POST["applicants"])){
		?>
		<script type="text/javascript">
		alert("Atlest One Applicant Should be selected For Mapping...!");
		window.location.href = "admin-exam-map.php";
		</script>
		<?php
	}
	else if($_POST["cmbExamSlotName"]==0){
		?>
		<script type="text/javascript">
		alert("Please select any Examintaion Slot!");
		window.location.href = "admin-exam-map.php";
		</script>
		<?php
	}
	else{
		$rowCount = count($_POST["applicants"]);
		$ExamSlotName=$_POST["cmbExamSlotName"];
		for($i=0;$i<$rowCount;$i++){
			// For Getting Max Exam map Details
			$stmt = $update_exam_data->runQuery("SELECT MAX(id) id FROM exammapdetails");
			$stmt->execute();
			$count = $stmt->rowCount();
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
			if($count== 1)
			{
				if($userRow['id']=="")
				{
					$exmpid=1;	
				}
				else 
				{
					$exmpid=$userRow['id']+1;	
				}
			}
			$stmt = $update_exam_data->runQuery("INSERT into exammapdetails (id,applicantid,slotid)values(:id,:aid,:slottid)");
			$stmt->execute(array(":id"=>$exmpid,":aid"=>$_POST["applicants"][$i],":slottid"=>$ExamSlotName));
			
			//echo $_POST["applicants"][$i];
		}
		?>
		<script type="text/javascript">
		alert("Applicant Mapped Successfully for Examination...!");
		window.location.href = "admin-exam-map.php";
		</script>
		<?php
	}
?>