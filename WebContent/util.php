<?php
/* creates a compressed zip file */
function create_zip($rootPath,$destination,$overwrite = false) {
	// Get real path for our folder
	$rootPath = realpath($rootPath);
	// Initialize archive object
	$zip = new ZipArchive();
	$zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE);
	
	
	// Create recursive directory iterator
	$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath),RecursiveIteratorIterator::LEAVES_ONLY);
	foreach ($files as $name => $file)
	{
		// Skip directories (they would be added automatically)
		if (!$file->isDir())
		{
			// Get real and relative path for current file
			$filePath = $file->getRealPath();
			$relativePath = substr($filePath, strlen($rootPath) + 1);
			//echo $filePath.'<br></br>';
			//echo $relativePath;
			// Add current file to archive
			$zip->addFile($filePath, $relativePath);
		}
	}
	
	// Zip archive will be created only after closing object
	$zip->close();
	return $destination;
}

function rrmdir($dir) 
{
	if (is_dir($dir)) 
	{
		$objects = array_diff(scandir($dir),array(".",".."));
		foreach ($objects as $object) 
		{
			if (filetype($dir."/".$object) == "dir") 
			{
				rrmdir($dir."/".$object); 
			}
			else 
			{
				unlink($dir."/".$object);
			}
		}
	}
	reset($objects);
	return rmdir($dir);
}

?>