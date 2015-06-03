<?php 
require('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>

	<?php
		if(empty($_SESSION['LoggedIn']) || empty($_SESSION['username']) ||  empty($_SESSION['role']) || $_SESSION['role']!='teacher')
		{
	?>
	<!--  Main content area  -->
	<div class="container text-center">
		<div class="well well-small">
			<p>Unauthorized access to this page</p>
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
		      			<li><a href="#EnrollmentSettings" onclick="contentListeners.replaceContentAdmin(this)">Enrollment Settings<i class="icon-chevron-right"></i></a></li>
		      		</ul>
				</div>
			</div>
			<div class="col-md-10">
				<div id='content-admin' class="well well-small">
					<section id="chooseSettings" class="settings">
						<p>Please select an option on the left pane to view settings</p>
					</section>
					<section id="EnrollmentSettings" style="display:none" class="settings">
						<h1>Enrollment Settings</h1>
						<select name="adminEnrollment" class="multiselect" onchange="contentListeners.replaceEnrollmentSettings(this)">
						<?php 
							foreach($_SESSION['enrollments'] as $enrollment)
							{
						?>
							<option value = "<?php echo $enrollment?>"><?php echo $enrollment?></option>
						<?php 
							}
						?>
						</select>
						<button id="add-enrollment-btn" type="button" class="btn btn-primary" data-backdrop="static" data-toggle="modal" data-target="#addEnrollmentModal">Add Enrollment</button>
						<hr></hr>
						<div id="content-enrollmentsettings"></div>
					</section>					
				</div>
			</div>
		</div>
	</div>
	<?php 
		}
	?>
	
<!-- Modal account settings form -->	
<div class="modal fade" id="addEnrollmentModal" tabindex="-1" role="dialog" aria-labelledby="addEnrollmentModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="settingsModalLabel">Add Enrollment</h4>
	        </div>
	        <div id="addEnrollmentDiv">
				<form data-toggle="validator" class="form-horizontal" id="addEnrollmentForm" method="post" novalidate autocomplete="off">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="addEnrollmentName">Enrollment</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="addEnrollmentName" placeholder="Enrollment" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<button type="submit" class="btn btn-default" id="addEnrollmentSubmit">Submit</button>
				        </div>
				        <div class="col-sm-8">
				        	<span id="addEnrollmentError" class="errorText"></span>
				        	<span id="addEnrollmentSuccess" class="successText"></span>
				        </div>
					</div>
				</form>
			</div>
		</div> 
	</div>
</div>
	
</body>
</html>