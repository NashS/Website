<?php
require('constants.php');
require ('login.php');

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_POST['selectedFilePath']))
{
	if($_SESSION['role']=='teacher')
	{
		$selectedFilePath = realpath(mysql_escape_string($_POST['selectedFilePath']));
		if(strrpos($selectedFilePath,realpath($RESOURCES_ROOT))===0 && file_exists($selectedFilePath))
		{
			if(unlink($selectedFilePath))
			{
				echo "0";
				echo "File successfully added.";
			}
			else 
			{
				echo "1";
				echo "Cannot create folder.";
			}			
		}
	}
}
?>