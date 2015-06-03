<?php
require('constants.php');
require ('login.php');

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_POST['addFolderName']) && !empty($_POST['selectedFolderPath']))
{
	if($_SESSION['role']=='teacher')
	{
	$addFolderName = basename(mysql_escape_string($_POST['addFolderName']));
	$selectedFolderPath = realpath(mysql_escape_string($_POST['selectedFolderPath']));
		if(strrpos($selectedFolderPath,realpath($RESOURCES_ROOT))===0)
		{
			if(!file_exists($selectedFolderPath."/".$addFolderName) && mkdir($selectedFolderPath."/".$addFolderName))
			{
				echo "0";
				echo "Folder successfully added.";
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