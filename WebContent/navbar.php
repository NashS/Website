<?php
require('constants.php');
require('login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cordelia Sequeira Piano Lessons</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-multiselect.css" rel="stylesheet">
<link href="bootstrap/css/my-bootstrap-custom.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<header>
		<!--  Top-bar content  -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<ul class="nav navbar-nav">
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Home.php') ? "class='active'" : ""; ?>><a href="Home.php">Home</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'About.php') ? "class='active'" : ""; ?>><a href="About.php">About</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Blog.php') ? "class='active'" : ""; ?>><a href="Blog.php">Blog</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Links.php') ? "class='active'" : ""; ?>><a href="Links.php">Links</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Resources.php') ? "class='active'" : ""; ?>>
						<?php 
							if(empty($_SESSION['LoggedIn']) || empty($_SESSION['username']))
							{
						?>
						<div class="inverse-tooltip" data-toggle="tooltip" data-placement="bottom" title="Please login to view">
							<a class="btn disabled" href="Resources.php">Resources</a>
						</div>	
						<?php 
							}else{
						?>
							<a href="Resources.php">Resources</a>
						<?php 
							}
						?>
					</li>
				<?php 
					if(!empty($_SESSION['role']) && $_SESSION['role'] == 'teacher')
					{
				?>	
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Admin.php') ? "class='active'" : ""; ?>><a href="Admin.php">Admin</a></li>
				<?php 
					}	
				?>
				</ul>
				
				
				<?php
					if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username']))
					{
			     ?>
					 
						<!-- User logged in --> 
				<ul class="nav navbar-nav navbar-right">
				   	<li><p class="navbar-text">Logged in as <?php echo ($_SESSION['username']) ?></p></li>
				   	<li><button id="settings-btn" type="button" class="btn btn-primary btn-navbar" data-backdrop="static" data-toggle="modal" data-target="#settingsModal"><i class="glyphicon glyphicon-user"></i> Account Settings</button></li>
				   	<li><a class="btn btn-primary btn-navbar" href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Sign Out</a></li>
			   	</ul>	      
			     <?php
					}
					elseif(!empty($_POST['email']) && !empty($_POST['password']))
					{
					    $email = mysql_real_escape_string($_POST['email']);
					    $password = md5(mysql_real_escape_string($_POST['password']));
					     
					    $checklogin = mysql_query("SELECT * FROM members WHERE email = '".$email."' AND password = '".$password."'");
					     
					    if(mysql_num_rows($checklogin) == 1)
					    {
					        $row = mysql_fetch_array($checklogin);
					        $username = $row['username'];
					        $uid = $row['id'];
							$role = "unknown";
							$resources = [];
							$enrollmentsResult = [];
							$resourcesResult = [];
							$enrollments = [];
							$resources = [];
							
					        $checkpriv = mysql_query("SELECT uid, eid, role FROM enrollments e left outer join roles r on e.eid = r.id WHERE uid='".$uid."'");
					        for($i = 0; $enrollmentsResult[$i] = mysql_fetch_assoc($checkpriv); $i++) ;
					        array_pop($enrollmentsResult);
					        
					        for($i = 0; $i < sizeof($enrollmentsResult);$i++)
					        {
					        	$enrollments[$i] = $enrollmentsResult[$i]['role'];
					        	$eids[$i] = $enrollmentsResult[$i]['eid'];
					        }
					        
					        $idx = array_search("teacher", $enrollments);
					        if(!is_bool($idx))
					        {
					        	unset($enrollments[$idx]);
					        	array_values($enrollments);
					        	$role = "teacher";
					        }
					        else 
					        {
					        	$role = "student";
					        }
					        /*
				        	$checkres = mysql_query("SELECT distinct resource, path FROM resources WHERE eid in ('".implode("','",$eids)."')");
				        	for($i = 0; $resourcesResult[$i] = mysql_fetch_assoc($checkres); $i++) ;
				        	array_pop($resourcesResult);
				        	for($i = 0; $i < sizeof($resourcesResult);$i++)
				        	{
					        	$resources[$i] = $enrollmentsResult[$i];
				        	}
					    	*/
					        
					        $_SESSION['username'] = $username;
					        $_SESSION['email'] = $email;
					        $_SESSION['LoggedIn'] = 1; 
					        $_SESSION['role'] = $role;
					        //$_SESSION['resources'] = $resources;
					        $_SESSION['enrollments'] = $enrollments;
					        header('Location: '.$_SERVER['PHP_SELF']);  
					    }
					    else
					    {
		        ?>
							<!-- invalid login credentials -->    	
				<ul class="nav navbar-nav navbar-right">
				   	<li> 	
						<form id="form-signin" class="navbar-form" role="form" method="post" novalidate autocomplete="off">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 
								<input id="email" type="email" class="form-control bg-danger inverse-tooltip" name="email" value="" placeholder="Email Address" data-toggle="tooltip" data-placement="bottom" title="invalid username and password">
							</div>

							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="password" type="password" class="form-control bg-danger inverse-tooltip" name="password" value="" placeholder="Password" data-toggle="tooltip" data-placement="bottom" title="invalid username and password">
							</div>
							<button type="submit" class="btn btn-primary">Login</button>
						</form>
					</li>
					<li>	      
					   	<button id="register-btn" type="button" class="btn btn-primary btn-navbar" data-backdrop="static" data-toggle="modal" data-target="#registerModal">Register</button>  
				   	</li>
			   	</ul>
		    	<?php
					    }
					}
					else
					{
				?>
					    <!-- User has not logged in -->
				<ul class="nav navbar-nav navbar-right">
				   	<li> 	
						<form id="form-signin" class="navbar-form" role="form" method="post" novalidate autocomplete="off">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span> 
								<input id="email" type="email" class="form-control" name="email" value="" placeholder="Email Address">
							</div>

							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="password" type="password" class="form-control" name="password" value="" placeholder="Password">
							</div>
							<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-log-in"></i> Login</button>
						</form>
					</li>
					<li>	      
					   	<button id="register-btn" type="button" class="btn btn-primary btn-navbar" data-backdrop="static" data-toggle="modal" data-target="#registerModal">Register</button>  
				   	</li>
				</ul>
			   <?php
					}
				?>
				
			</div>
		</nav>

	</header>

<?php
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['username']))
	{
?>	
<!-- Modal account settings form -->	
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="settingsModalLabel">Account Settings</h4>
	        </div>
	        <div id="accountSettingsDiv">
	        	<form data-toggle="validator" role="form" class="form-horizontal" id="accountSettingsForm" method="post" novalidate autocomplete="off">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="accountSettingsUsername">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="accountSettingsUsername" placeholder="<?php echo $_SESSION['username']?>">
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group disabled">
						<label class="col-sm-2 control-label" for="accountSettingsEmail">Email</label>
						<div class="col-sm-10">
							<div class="inverse-tooltip" data-toggle="tooltip" data-placement="bottom" title="Your email address is permanently attached to your account and is unmodifiable.">
								<input type="email" class="form-control" name="accountSettingsEmail" placeholder="<?php echo $_SESSION['email']?>" data-error="Bruh, that email address is invalid" readonly>
							</div>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="accountSettingsEnrollment">Enrollment(s):</label>
						<div class="col-sm-10">
							<select id="registerEnrollment" name="accountSettingsEnrollment[]" class="multiselect" multiple required>
							<?php 
								$availEnrollmentsResult = mysql_query("SELECT distinct id, role FROM roles WHERE role != 'teacher'");
								for($i = 0; $availEnrollments[$i] = mysql_fetch_row($availEnrollmentsResult); $i++) ;
								array_pop($availEnrollments);
								foreach($availEnrollments as $enrollment)
								{
							?>
								<option value = "<?php echo $enrollment[0]; ?>" <?php if(in_array($enrollment[1], $_SESSION['enrollments'])){?>selected<?php }?>><?php echo $enrollment[1]; ?></option>
							<?php 
								}
							?>
							</select>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="accountSettingsPassword">Reset Password</label>
						<div class="col-sm-5">
							<input type="password" class="form-control" name="accountSettingsPassword" id="accountSettingsPassword" placeholder="Password" data-minlength="4">
							<div class="help-block with-errors">Minimum of 4 characters</div>
						</div>
						<div class="col-sm-5">
							<input type="password" class="form-control" name="accountSettingsPasswordConfirm" placeholder="Confirm Password" data-minlength="4" data-match="#accountSettingsPassword"  data-match-error="Bruh, these passwords don't match">
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<input type="submit" class="btn btn-default" id="accountSettingsSubmit" value="submit">
				        </div>
				        <div class="col-sm-8">
				        	<span id="accountSettingsError" class="errorText"></span>
				        	<span id="accountSettingsSuccess" class="successText"></span>
				        </div>
					</div>
				</form>
	        </div>
        </div>
	</div>
</div>
<?php 
	}
?>
		        
<!-- Modal registration form -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="registerModalLabel">Registration</h4>
			</div>
			<div id="registerDiv">
				<form class="form-horizontal" id="registerForm" method="post" novalidate autocomplete="off">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="registerUsername">Username</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="registerUsername" placeholder="Username" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="registerEmail">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" name="registerEmail" placeholder="Email" data-error="Bruh, that email address is invalid" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="registerEnrollment">Enrollment(s):</label>
						<div class="col-sm-10">
							<select id="registerEnrollment" name="registerEnrollment[]" class="multiselect" multiple required>
							<?php 
								$availEnrollmentsResult = mysql_query("SELECT distinct id, role FROM roles WHERE role != 'teacher'");
								for($i = 0; $availEnrollments[$i] = mysql_fetch_row($availEnrollmentsResult); $i++) ;
								array_pop($availEnrollments);
								foreach($availEnrollments as $enrollment)
								{
							?>
								<option value = "<?php echo $enrollment[0]; ?>"><?php echo $enrollment[1]; ?></option>
							<?php 
								}
							?>
							</select>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="registerPassword">Password</label>
						<div class="col-sm-5">
							<input type="password" class="form-control" name="registerPassword" id="registerPassword" placeholder="Password" data-minlength="4" required>
							<div class="help-block with-errors">Minimum of 4 characters</div>
						</div>
						<div class="col-sm-5">
							<input type="password" class="form-control" name="registerPasswordConfirm" placeholder="Confirm Password" data-minlength="4" data-match="#registerPassword"  data-match-error="Bruh, these passwords don't match" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<input type="submit" class="btn btn-default" id="registerSubmit" value="submit">
				        </div>
				        <div class="col-sm-8">
				        	<span id="registerError" class="errorText"></span>
				        	<span id="registerSuccess" class="successText"></span>
				        </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>		
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="<?php echo $JS_ROOT?>bootstrap.min.js"></script>
	<script src="<?php echo $JS_ROOT?>bootstrap-multiselect.js"></script>
	<script src="<?php echo $JS_ROOT?>validator.js"></script>
	<script src="<?php echo $JS_ROOT?>my-bootstrap-custom.js"></script>
	
</body>
</html>