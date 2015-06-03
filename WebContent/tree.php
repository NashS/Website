<?php 
require('constants.php');
require('login.php'); 

/**
 * Converts bytes into human readable file size.
 *
 * @param string $bytes
 * @return string human readable file size
 * @author Mogilev Arseny
 */
function FileSizeConvert($bytes)
{
	$bytes = floatval($bytes);
	$arBytes = array(
			0 => array(
					"UNIT" => "TB",
					"VALUE" => pow(1024, 4)
			),
			1 => array(
					"UNIT" => "GB",
					"VALUE" => pow(1024, 3)
			),
			2 => array(
					"UNIT" => "MB",
					"VALUE" => pow(1024, 2)
			),
			3 => array(
					"UNIT" => "KB",
					"VALUE" => 1024
			),
			4 => array(
					"UNIT" => "B",
					"VALUE" => 1
			),
	);

	foreach($arBytes as $arItem)
	{
		if($bytes >= $arItem["VALUE"])
		{
			$result = $bytes / $arItem["VALUE"];
			$result = strval(round($result, 2))." ".$arItem["UNIT"];
			break;
		}
	}
	return $result;
}

function sortFiles(&$array,$rootPath)
{
	$dirs = [];
	$files = [];
	foreach($array as $file)
	{
		if(is_dir($rootPath."/".$file))
		{
			array_push($dirs, $file);
		}
		else 
		{
			array_push($files, $file);
		}
	}
	$array = array_unique(array_merge($dirs,$files));
}

function recursiveFileSearch(&$array, $rootPath)
{
	$it = array_diff(scandir($rootPath),array('..','.'));
	sortFiles($it,$rootPath);
	for($i=0,$array['nodes'] = [];$i<count($it);$i++)
	{
		$file = $it[$i];
		if(is_dir($rootPath."/".$file))
		{
			$nestedarray = [];
			$nestedarray['text']=$file;
			$nestedarray['icon']="glyphicon glyphicon-folder-close";
			$nestedarray['path']=$rootPath."/".$file;
			recursiveFileSearch($nestedarray,$rootPath."/".$file);
			array_push($array['nodes'],$nestedarray);
		}
		else
		{"\n";
			${"nodearray".$i}['text']=$file;
			${"nodearray".$i}['icon']="glyphicon glyphicon-file";
			${"nodearray".$i}['path']=$rootPath."/".$file;
			${"nodearray".$i}['tags']=[FileSizeConvert(filesize($rootPath."/".$file))];
			${"nodearray".$i}['file']=true;
			array_push($array['nodes'],${nodearray.$i});
		}
	}
}

	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['username']) && !empty($_SESSION['enrollments']) && !empty($_POST['enrollment']))
	{
		if(in_array($_POST['enrollment'],$_SESSION['enrollments']))
		{
			$json = [];
			$resourcePaths['text']=$_POST['enrollment'];
			$resourcePaths['icon']="glyphicon glyphicon-folder-close";
			$resourcePaths['path']=$RESOURCES_ROOT.$_POST['enrollment'];
			$resourcePaths['root']=true;
			recursiveFileSearch($resourcePaths,$RESOURCES_ROOT.$_POST['enrollment']);
			array_push($json, $resourcePaths);
			$jsonString = json_encode($json);
			echo $jsonString;
		}
		
	} 
?>