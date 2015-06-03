<?php 
require('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>	
	<?php
		if(empty($_SESSION['LoggedIn']) || empty($_SESSION['username']) || empty($_SESSION['role']))
		{
     ?>
     		<!--  Main content area  -->
	<div class="container text-center">
		<div class="well well-small">
			<p>Please log in to view contents</p>
		</div>
	</div>
     
	<?php 
		}
		else 
		{
	?>
	<div class="container">
		<div class="row-fluid">
			<div class="col-md-2">
				<div id="sidebar" class="well sidebar-nav affix">
		      		<ul class="nav nav-list">
	<?php 
			foreach($_SESSION['enrollments'] as $enrollment)
			{
	?>
						<li><a href="#<?php echo $enrollment; ?>" onclick="contentListeners.replaceContentResources(this)"><?php echo $enrollment;?><i class="icon-chevron-right"></i></a></li>
	<?php 
			}					
	?>
					</ul>
				</div>
			</div>
			<div class="col-md-10">
					<div id='content-resources' class="well well-small">
						<p id="noResourceSelected">Please select an option on the left pane to view resources</p>
						<div id="actions" class="fileBroswe" style="display:none">
							<button id="download-btn" class="btn btn-primary btn-node-action" onclick="fileActions.downloadFile()"><i class="glyphicon glyphicon-download"></i> Download</button>
							<button id="downloadAll-btn" class="btn btn-primary" onclick="fileActions.downloadAll()"><i class="glyphicon glyphicon-download-alt"></i> Download All</button>
						<?php 
							if($_SESSION['role']=='teacher')
							{	
						?>
							<button id="addFiles-btn" class="btn btn-primary btn-node-action" data-backdrop="static" data-toggle="modal" data-target="#addFilesModal" onclick="fileActions.addFiles()"><i class="glyphicon glyphicon-file"></i> Add File(s)</button>
							<button id="addFolder-btn" class="btn btn-primary btn-node-action" data-backdrop="static" data-toggle="modal" data-target="#addFolderModal" onclick="fileActions.addFolder()"><i class="glyphicon glyphicon-folder-close"></i> Add Folder</button>
							<button id="removeFile-btn" class="btn btn-primary btn-node-action" onclick="fileActions.removeFile()"><i class="glyphicon glyphicon-trash"></i> Remove File</button>
							<button id="removeFolder-btn" class="btn btn-primary btn-node-action" onclick="fileActions.removeFolder()"><i class="glyphicon glyphicon-trash"></i> Remove Folder</button>
						<?php
							} 
						?>
						</div>
						<div id="tree" class="fileBroswe"></div>
					</div>
			</div>
		</div>
	</div>
	<?php 
		}
	?>
	<script src="<?php echo $JS_ROOT?>bootstrap-treeview.min.js"></script>

<!-- Modal add Files form -->
<div class="modal fade" id="addFilesModal" tabindex="-1" role="dialog" aria-labelledby="addFilesModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="settingsModalLabel">Add File(s)</h4>
	        </div>
	        <div id="addFilesDiv">
	        	<ul class="list-group" id="fileList"></ul>
        		<button id="addFiles-modal-btn" type="button" class="btn btn-primary">Add Files</button>
        		<button id="startUpload-modal-btn" type="button" class="btn btn-primary">Start Upload</button>
	        </div>
        </div>
	</div>
</div>		

<!-- Modal add Folder form -->
<div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="addFolderModalLabel">Add Folder</h4>
	        </div>
	        <div id="addFolderDiv">
	        	<form data-toggle="validator" role="form" class="form-horizontal" id="addFolderForm" method="post" novalidate="true" autocomplete="off">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="addFolderName">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="addFolderName" placeholder="Folder Name" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<input type="submit" class="btn btn-default" id="addFolderSubmit" value="submit">
				        </div>
				        <div class="col-sm-8">
				        	<span id="addFolderError" class="errorText"></span>
				        	<span id="addFolderSuccess" class="successText"></span>
				        </div>
					</div>
				</form>
	        </div> 
        </div>  
	</div>
</div>	

	<script src="<?php echo $JS_ROOT?>plupload.full.min.js"></script>


</body>
</html>