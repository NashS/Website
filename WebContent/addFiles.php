<?php
require('constants.php');
require('login.php');

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments'])  && !empty($_REQUEST['path']))
{
	if($_SESSION['role']=='teacher')
	{
		$filePath = mysql_escape_string($_REQUEST['path']);
		$fileName = basename(mysql_escape_string($_REQUEST['name']));
		if(strrpos(realpath($filePath),realpath($RESOURCES_ROOT))===0)
		{
		
			if (empty($_FILES) || $_FILES["file"]["error"]) {
				 die('{"OK": 0, "info": "Failed to upload file"}');
			}
			
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $filePath."/".$fileName))
			{
				 die('{"OK": 1, "info": "File successfully uploaded"}');
			}
		}
	}
}
die('{"OK": 0, "info": "Faulty request passed"}');
?>