<?php 
require('constants.php');
require('login.php');
require('util.php'); 

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_GET['enrollment']) && !empty($_GET['isSingleFile']))
{
	if(in_array($_GET['enrollment'],$_SESSION['enrollments']))
	{
		$dl_file = NULL;
		if($_GET['isSingleFile']=='true')
		{
			if(strrpos(realpath($_GET['path']),realpath($RESOURCES_ROOT))===0)
			{
				ignore_user_abort(true);
				set_time_limit(120);
				$dl_file = mysql_escape_string($_GET['path']);
			}
		}
		else 
		{
			$dl_file = create_zip($RESOURCES_ROOT.$_GET['enrollment'],$RESOURCES_ROOT.$_GET['enrollment'].".zip",true);
		}
		if (file_exists($dl_file)) {
		
			$fsize = filesize($dl_file);
			$path_parts = pathinfo($dl_file);
			header('Content-Description: File Transfer');
			header("Content-Type: application/octet-stream");
			header('Content-Transfer-Encoding: binary');
			header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
			header('Expires: 0');
			header("Cache-control: no-cache, must-revalidate"); //use this to open files directly
			header('Pragma: public');
			header("Content-length: ".$fsize);
			ob_clean();
			flush();
			readfile($dl_file);
		
		}
	}
}
?>