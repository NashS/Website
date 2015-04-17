
<!-- TODO: When making website compatible with MySQL, make sure SQL input is escaped string to prevent injection vulnerability -->

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
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">Cordelia Sequeira</a>
					<ul class="nav">
						<li><a href="index.php">Home</a></li>
						<li><a href="About.php">About</a></li>
						<li><a href="Blog.php">Blog</a></li>
						<li><a href="Links.php">Links</a></li>
						<li class="active"><a href="Resources.php">Resources</a></li>

					</ul>
					<form id="signin" class="navbar-form navbar-right" role="form">
						<div class="input-group">
							<span class="input-group-addon"><i
								class="icon-user"></i></span> <input id="email"
								type="email" class="form-control" name="email" value=""
								placeholder="Email Address">
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i
								class="icon-lock"></i></span> <input
								id="password" type="password" class="form-control"
								name="password" value="" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary">Login</button>
					</form>
				</div>

			</div>
		</div>

	</header>
	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="./bootstrap/js/bootstrap.min.js"></script>
	<script src="./bootstrap/js/my-bootstrap-custom.js"></script>

</body>
</html>