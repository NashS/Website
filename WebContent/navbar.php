<?php
require('login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cordelia Sequeira Piano Lessons</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/my-bootstrap-custom.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<header>
		<!--  Top-bar content  -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<ul class="nav navbar-nav">
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? "class='active'" : ""; ?>><a href="index.php">Home</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'About.php') ? "class='active'" : ""; ?>><a href="About.php">About</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Blog.php') ? "class='active'" : ""; ?>><a href="Blog.php">Blog</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Links.php') ? "class='active'" : ""; ?>><a href="Links.php">Links</a></li>
					<li <?php echo (basename($_SERVER['PHP_SELF']) == 'Resources.php') ? "class='active'" : ""; ?>><a href="Resources.php">Resources</a></li>
				</ul>
				<?php
					if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
					{
			     ?>
					 
						<!-- User logged in --> 
					      
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
					         
					        $_SESSION['username'] = $username;
					        $_SESSION['email'] = $email;
					        $_SESSION['LoggedIn'] = 1; 
		        ?>
					        <!-- valid login credentials --> 
				<ul class="nav navbar-nav navbar-right">
				   	<li><p class="navbar-text">Logged in as <?php echo ($_SESSION['username']) ?></p></li>
				   	<li>
			   			<button id="signout-btn" type="button" class="btn btn-primary btn-navbar">Sign Out</button>
		   			</li>
			   	</ul>
		        <?php
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
							<button type="submit" class="btn btn-primary">Login</button>
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
	
<!-- Modal registration form -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
    		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="registerModalLabel">Registration</h4>
			</div>
			<div id="registerDiv">
				<form data-toggle="validator" class="form-horizontal" id="registerForm" method="post" novalidate autocomplete="off">
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
							<button type="submit" class="btn btn-default" id="registerSubmit">Submit</button>
				        </div>
				        <div class="col-sm-8">
				        	<span id="responseError" class="errorText"></span>
				        	<span id="responseSuccess" class="successText"></span>
				        </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>		
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<script src="./bootstrap/js/validator.min.js"></script>
	<script src="./bootstrap/js/my-bootstrap-custom.js"></script>
	
</body>
</html>