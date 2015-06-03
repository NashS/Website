<?php 
/* Short and sweet */
define('WP_USE_THEMES', false);
require('blog/wordpress/wp-blog-header.php');
require('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<body>
	<!--  Main content area  -->
	<div class="container">
	  <div class="row-fluid">
	    <div class="col-md-2">
	      	<!--Sidebar content-->
	    	<div id="sidebar" class="well sidebar-nav affix">
		      	<ul class="nav nav-list">
	      		<?php 	if ( have_posts() ) : 
							while ( have_posts() ) : the_post();?>
		      		<li><a href="#<?php the_title(); ?>"><?php the_title(); ?><i class="icon-chevron-right"></i></a></li>
  				<?php 		endwhile;
						endif; ?>
		      	</ul>
	    	</div>
	    </div>
	    <div class="col-md-10">
	       	<!--main content info-->
	       	<div id="content-info">
	       	
       		<?php 	if ( have_posts() ) : 
						while ( have_posts() ) : the_post();?>
					<span id="<?php the_title(); ?>" class="anchor"></span>
					<section class="well well-small">
						<h1><?php the_title(); ?></h1>
						<p><?php the_time(); ?></p>
						<p><?php the_content(); ?></p>
					</section>
			<?php 		endwhile;
					endif; ?>
	   
		    </div>	
	    </div>
	  </div>
	</div>
	
	    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./bootstrap/js/my-bootstrap-custom.js"></script>
	
</body>
</html>