<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cordelia Sequeira Piano Lessons</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
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
				<form id="signin" class="navbar-form navbar-right" role="form">
					<div class="input-group">
						<span class="input-group-addon"><i
							class="glyphicon glyphicon-user"></i></span> <input id="email"
							type="email" class="form-control" name="email" value=""
							placeholder="Email Address">
					</div>

					<div class="input-group">
						<span class="input-group-addon"><i
							class="glyphicon glyphicon-lock"></i></span> <input id="password"
							type="password" class="form-control" name="password" value=""
							placeholder="Password">
					</div>

					<button type="submit" class="btn btn-primary">Login</button>
				</form>

			</div>
		</nav>

	</header>
</body>
</html>