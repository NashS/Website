<?php
require('constants.php');
require('login.php');

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_POST['accountSettingsEnrollment']))
{
	mysql_query("START TRANSACTION");
	$uidResult = mysql_query("SELECT id FROM members WHERE email='".$_SESSION['email']."'");
	$uid;
	if($uidResult)
	{
		$uid = mysql_fetch_row($uidResult)[0];
		$username = "Something is wrong";
		$accountSettingsUsername = true;
		$accountSettingsPassword = true;
		$accountSettingsInsertEnrollments = true;
		$accountSettingsDeleteEnrollments = true;
		$currentEnrollments = [];
		
		if(!empty($_POST['accountSettingsUsername']))
		{
			$username = mysql_real_escape_string($_POST['accountSettingsUsername']);
			$accountSettingsUsername = mysql_query("UPDATE members SET username='".$username."' WHERE email='".$_SESSION['email']."'");
		}
		
		if(!empty($_POST['accountSettingsPassword']))
		{
			$password = md5(mysql_real_escape_string($_POST['accountSettingsPassword']));
			$accountSettingsPassword = mysql_query("UPDATE members SET password='".$password."' WHERE email='".$_SESSION['email']."'");
		}
		
		$currentEnrollmentsResult = mysql_query("SELECT id FROM roles WHERE role IN ('".implode("','",$_SESSION['enrollments'])."')");
		for($i = 0; $currentEnrollments[$i] = mysql_fetch_row($currentEnrollmentsResult)[0]; $i++) ;
		array_pop($currentEnrollments);
		$insertEnrollments = array_values(array_diff($_POST['accountSettingsEnrollment'],$currentEnrollments));
		$deleteEnrollments = array_values(array_diff($currentEnrollments,$_POST['accountSettingsEnrollment']));
		
		
		if(count($insertEnrollments) > 0)
		{
			$insertQuery = "INSERT INTO enrollments (uid,eid) VALUES ";
			for($i = 0; $i < count($insertEnrollments); $i++)
			{
				$enrollment = mysql_real_escape_string($insertEnrollments[$i]);
				$insertQuery .= "('".$uid."', '".$enrollment."'),";
			}
			$insertQuery = rtrim($insertQuery,",");
			$accountSettingsInsertEnrollments = mysql_query($insertQuery);
		}
		if(count($deleteEnrollments) > 0)
		{
			$accountSettingsDeleteEnrollments = mysql_query("DELETE FROM enrollments WHERE uid='".$uid."' AND eid in ('".mysql_real_escape_string(implode("','",$deleteEnrollments))."')");
		}



		if($accountSettingsUsername && $accountSettingsPassword && $accountSettingsInsertEnrollments && $accountSettingsDeleteEnrollments)
		{
			$sanitizedEnrollments = [];
			for($i=0;$i<count($_POST['accountSettingsEnrollment']);$i++)
			{
				$sanitizedEnrollments[$i] = mysql_escape_string($_POST['accountSettingsEnrollment'][$i]);
			}
			$selectedEnrollmentNamesResult = mysql_query("SELECT role FROM roles WHERE id IN ('".implode("','",$sanitizedEnrollments)."')");
			if($selectedEnrollmentNamesResult)
			{
				$selectedEnrollmentNames = [];
				for($i=0;$selectedEnrollmentNames[$i]=mysql_fetch_row($selectedEnrollmentNamesResult)[0];$i++);
				array_pop($selectedEnrollmentNames);
				mysql_query("COMMIT");
				$_SESSION['enrollments'] = $selectedEnrollmentNames;
				if($accountSettingsUsername && !empty($_POST['accountSettingsUsername']))
				{
					$_SESSION['username'] = $username;
				}
				echo "0";
				echo "Successfully Modifed Account Settings";
				die();
			}
		}
	}	
	mysql_query("ROLLBACK");
	echo "1";
	echo "Error Modifying Account Settings";
}

?>
