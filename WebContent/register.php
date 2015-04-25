<?php 
require "login.php"; 

	if(!empty($_POST['registerUsername']) && !empty($_POST['registerPassword']) &&  !empty($_POST['registerEmail']))
	{
	    $username = mysql_real_escape_string($_POST['registerUsername']);
	    $password = md5(mysql_real_escape_string($_POST['registerPassword']));
	    $email = mysql_real_escape_string($_POST['registerEmail']);
	    
	     $checkusername = mysql_query("SELECT * FROM members WHERE email = '".$email."'");
	      
	     if(mysql_num_rows($checkusername) == 1)
	     {
	        echo "1";
	     	echo "Sorry, that email is already registed. Please go back and try again.";
	     }
	     else
	     {
	        $registerquery = mysql_query("INSERT INTO members (username, password, email) VALUES('".$username."', '".$password."', '".$email."')");
	        if($registerquery)
	        {
				echo "0";
	            echo "Your account was successfully created.";
	        }
	        else
	        {
	        	echo "1";
	            echo "Sorry, your registration failed. Please go back and try again.";    
	        }       
	     }
	}
	else
	{
?>
	     
<?php
	}
?>