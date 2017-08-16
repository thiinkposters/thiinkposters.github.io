<?php 
if(isset($_POST['email'])) {
      
    	// relevant email instructions
 
    	$email_to = "requests@thiinkposters.com"; 
    	$email_subject = "Thiink Poster Request";
    	$email_master = "thiiwaym@thiinkposters.com";
    	
    	// error screen
      
    	function died($error) { 
    		// meta, fonts, and stylesheets
        	echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
        	echo "<link href=\"http://www.thiinkposters.com/img/thiink-favicon.png\" rel=\"icon\" type=\"image/png\">";
        	echo "<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400' rel='stylesheet' type='text/css' />";
		echo "<link href='http://fonts.googleapis.com/css?family=Rokkitt:700' rel='stylesheet' type='text/css' />";
		echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:400' rel='stylesheet' type='text/css' />";
        	echo "<link rel=\"stylesheet\" href=\"css/request-styles.css\" type=\"text/css\" />";
        	echo "<link rel=\"stylesheet\" href=\"css/submit-button.css\" type=\"text/css\" />";
        	// start page
        	echo "<title>Issue Found</title></head><body><center><h1>Oops!</h1>";
		echo "<p align=\"center\">Part of your request doesn't look quite right. ";
		echo "Please check the following:<br /><br />";
		// print error message as h2
		echo "<h2>".$error."</h2><br /><br />";
		// button to return to form
		echo "<button class=\"subbutton\" onClick=\"history.back()\">BACK TO FORM</button>";
		echo "</center></body></html>";
        	die(); 
   	} 
     
	// validate that expected data exists 
	
	if(!isset($_POST['name']) || 
	        !isset($_POST['email']) || 
	        !isset($_POST['description'])) { 
	        died('There appears to be an issue with the form submission on the server side. So sorry! Please try again later. :(');  
	} 
	
	$name = $_POST['name']; // required 
	$email_from = $_POST['email']; // required 
	$description = $_POST['description']; // required     
 
 	// variable for error messge (default blank)
	$error_message = "";
 
 	// check input characters
 
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
	if(!preg_match($email_exp, $email_from) || preg_match("/[\r\n]/", $email_from)) { 
    		$error_message .= 'The email address that you submitted is invalid.<br />'; 
  	}
 
	$name_exp = "/^[A-Za-z ][A-Za-z0-9.,-_&* ]*+$/";
 
  	if(!preg_match($name_exp, $name) || preg_match("/[\r\n]/", $name)) { 
    		$error_message .= 'There are invalid characters in the name you submitted.<br />'; 
  	}
 
 	// check input length
 
  	if(strlen($description) < 50) { 
   		$error_message .= 'The description you entered is too short. Please elaborate a little more.<br />'; 
  	}
  
  	if(strlen($description) > 1000) {
    		$error_message .= 'The description you entered is a bit long. Please condense it a little. You can always give me more details later!<br />';
    	}
 
 	// if error message is not default blank, go to error screen
 	
  	if(strlen($error_message) > 0) { 
    		died($error_message); 
  	}
 
    	// begin composing email content
    	
    	$email_message = "REQUEST DETAILS BELOW.\n\n";
 
 	// clean any injections
 	    	
    	function clean_string($string) { 
      		$bad = array("content-type","bcc:","to:","cc:","href"); 
      		return str_replace($bad,"",$string); 
    	}
    
    	$email_message .= "Name: ".clean_string($name)."\n";
    	$email_message .= "Email: ".clean_string($email_from)."\n"; 
    	$email_message .= "Description: ".clean_string($description)."\n";
  
	// create email headers
 
	$headers = 'From: '.$email_master."\r\n". 
	'Reply-To: '.$email_from."\r\n" . 
	'X-Mailer: PHP/' . phpversion();
	
	// send email
	
	mail($email_to, $email_subject, $email_message, $headers);
	
?>
 
<!--SUCCESS SCREEN-->
<html>
	<head>
	<!--META, FONTS, AND STYLESHEETS-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="http://www.thiinkposters.com/img/thiink-favicon.png" rel="icon" type="image/png">
	<link href='http://fonts.googleapis.com/css?family=Playfair+Display:400' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Rokkitt:700' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/request-styles.css" type="text/css" />
        <link rel="stylesheet" href="css/submit-button.css" type="text/css" />
	<title>Thank You!</title>
	</head>

	<body>
	<center>
		<h1>Thank you!</h1>
		<p align="center">Thank you for submitting your request with Thiink Posters! Your poster idea has been received. I will
		follow up with you within 48 hours to start discussing a design, timescale, and any other questions you have.<br /><br />
		<h2>Have a great day!</h2><br /><br />
	        <button class="subbutton" onClick="history.back()">BACK TO SITE</button>
	</center>
	</body>
</html>
 
<?php 

}

?>