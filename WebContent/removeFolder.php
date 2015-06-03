<?php
require('constants.php');
require('login.php');
require('util.php');

function isRootFolder($selectedFolderPath)
{
	$availEnrollmentsResult = mysql_query("SELECT role FROM roles where role != 'teacher'");
	for($i = 0; $availEnrollments[$i] = mysql_fetch_row($availEnrollmentsResult); $i++) ;
	array_pop($availEnrollments);
	$enrollmentPaths = array();
	foreach($availEnrollments as $enrollment)
	{
		if($selectedFolderPath === realpath($$RESOURCES_ROOT."/".$enrollment[0]))
			return true;
	}
	return false;
}

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_POST['selectedFolderPath']))
{
	if($_SESSION['role']=='teacher')
	{
		$selectedFolderPath = realpath(mysql_escape_string($_POST['selectedFolderPath']));
		if(strrpos($selectedFolderPath,realpath($RESOURCES_ROOT))===0 && file_exists($selectedFolderPath) && !isRootFolder($selectedFolderPath))
		{
			if(rrmdir($selectedFolderPath))
			{
				echo "0";
				echo "Folder successfully removed.";
			}
			else 
			{
				echo "1";
				echo "Cannot remove folder.";
			}			
		}
	}
}
?>