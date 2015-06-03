<?php
require('constants.php');
require ('login.php');

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && $_SESSION['role']=='teacher' && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_POST['addEnrollmentName']))
{
	$enrollment = mysql_real_escape_string($_POST['addEnrollmentName']);
	 
	$checkenrollment = mysql_query("SELECT * FROM roles WHERE role = '".$enrollment."'");
	 
	if(mysql_num_rows($checkenrollment) == 1)
	{
		echo "1";
		echo "Sorry, that enrollment already registered.";
	}
	else
	{
		mysql_query("START TRANSACTION");
		
		$addenrollment = mysql_query("INSERT INTO roles (role) VALUES('".$enrollment."')");
		$eid = mysql_insert_id();
		$getTeacherIDs = mysql_query("SELECT distinct(uid) FROM enrollments WHERE eid = (SELECT id FROM roles where role = 'teacher')");
		for($i = 0; $teacherIDsResult[$i] = mysql_fetch_assoc($getTeacherIDs); $i++) ;
		array_pop($teacherIDsResult);
		for($i = 0; $i < sizeof($teacherIDsResult);$i++)
		{
			$teacherIDs[$i] = $teacherIDsResult[$i]['uid'];
		}
		$isTeacherIDsAddedForNewEnrollment = [];
		for($i = 0; $i < count($teacherIDs); $i++)
		{
			$isTeacherIDsAddedForNewEnrollment[$i] = mysql_query("INSERT INTO enrollments (uid,eid) VALUES('".$teacherIDs[$i]."', '".$eid."')");
		}
		$isDirCreated = mkdir($RESOURCES_ROOT.$enrollment);
		if($addenrollment && $isDirCreated && !in_array(false, $isTeacherIDsAddedForNewEnrollment))
		{
			mysql_query("COMMIT");
			array_push($_SESSION['enrollments'],$enrollment);
			echo "0";
			echo "Enrollment successfully created.";
		}
		else
		{
			mysql_query("ROLLBACK");
			echo "1";
			echo "Sorry, could not add enrollment.";
		}
	
	}
}
	
?>