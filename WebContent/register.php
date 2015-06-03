<?php 
require('login.php'); 

	if(!empty($_POST['registerUsername']) && !empty($_POST['registerPassword']) && !empty($_POST['registerEmail']) && !empty($_POST['registerEnrollment']))
	{
	    $username = mysql_real_escape_string($_POST['registerUsername']);
	    $password = md5(mysql_real_escape_string($_POST['registerPassword']));
	    $email = mysql_real_escape_string($_POST['registerEmail']);
	    
	     $checkusername = mysql_query("SELECT * FROM members WHERE email = '".$email."'");
	      
	     if(mysql_num_rows($checkusername) == 1)
	     {
	        echo "1";
	     	echo "Sorry, that email is already registered.";
	     }
	     else
	     {
	     	mysql_query("START TRANSACTION");
	        $registeruser = mysql_query("INSERT INTO members (username, password, email) VALUES('".$username."', '".$password."', '".$email."')");
	        $uid = mysql_insert_id();
	        //for($i = 0; $registerenrollment[$i] = mysql_query("INSERT INTO enrollments (uid,eid) VALUES('".$uid."', '".$_POST['registerEnrollment'][$i]."')"); $i++) ;
	        //array_pop($registerenrollment);
	        $registerenrollment = [];
	        for($i = 0; $i < count($_POST['registerEnrollment']); $i++){
	        	$registerenrollment[$i] = mysql_query("INSERT INTO enrollments (uid,eid) VALUES('".$uid."', '".$_POST['registerEnrollment'][$i]."')");
	        }
	        
	        if($registeruser && !in_array(false, $registerenrollment,true))
	        {
	        	mysql_query("COMMIT");
				echo "0";
	            echo "Your account was successfully created.";
	        }
	        else
	        {
	        	mysql_query("ROLLBACK");
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