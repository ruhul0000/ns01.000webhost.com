<?php

session_start();

define('IN_ADMIN', true);

 
require_once('header.php');


//If the form is submitted
if(isset($_POST['submit'])) {



//Check to make sure that the name field is not empty
if(trim($_POST['name']) == '') {
$hasError = true;
} else {
$name = trim($_POST['name']);
}

//Check to make sure sure that a valid email address is submitted
if(trim($_POST['email']) == '') {
$hasError = true;
}else {
$email = trim($_POST['email']);
}


//Check to make sure that the subject field is not empty
if(trim($_POST['subject']) == '') {
$hasError = true;
} else {
$subject = trim($_POST['subject']);
}


//Check to make sure comments were entered
if(trim($_POST['message']) == '') {
$hasError = true;
} else {
if(function_exists('stripslashes')) {
$comments = stripslashes(trim($_POST['message']));
} else {
$comments = trim($_POST['message']);
}
}

//If there is no error, send the email
if(!isset($hasError)) {
	
			//Email information
            $query = "SELECT * FROM site_config WHERE id='1'";
            $result = mysqli_query($connection, $query);
            
            while ($row = mysqli_fetch_array($result))
            {
                $email_site = Trim($row['email']);
            }
			
$emailTo = $email_site; // Put your own email address here
$subject = $subject;
$body = "Your Name: $name \n\nYour Email: $email \n\nYour Subject: $subject \n\nYour Comments:\n $comments";
$headers = "From: Seo Stats Contact \r\n" ;

mail($emailTo, $subject, $body, $headers);
$emailSent = true;


   if (mail($emailTo, $subject, $body, $headers))
    {
    $emailSent = true;
    }
  else 
    {
    $emailSent = false;
    }

			
}
}

?>
<script src="<?php echo $theme_path;?>js/jquery.validate.pack.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		// validate signup form on keyup and submit
		var validator = $("#contactform").validate({
		errorClass:'error',
		validClass:'success',
		errorElement:'span',
		highlight: function (element, errorClass, validClass) {
		$(element).parents("div[class='clearfix']").addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function (element, errorClass, validClass) {
		$(element).parents(".error").removeClass(errorClass).addClass(validClass);
		},
		rules: {
		name: {
		required: true,
		minlength: 2
		},
		email: {
		required: true,
		email: true
		},
		
		
		subject: {
		required: true
		},
		message: {
		required: true,
		minlength: 10
		}
		},
		messages: {
			name: {
			required: '<span class="help-inline"><?php echo $lang['55']; ?></span>',
			minlength: jQuery.format('<span class="help-inline">Your name needs to be at least {0} characters.</span>')
			},
			email: {
			required: '<span class="help-inline"><?php echo $lang['56']; ?></span>',
			minlength: '<span class="help-inline"><?php echo $lang['57']; ?></span>'
			},
			
			subject: {
			required: '<span class="help-inline"><?php echo $lang['58']; ?></span>'
			},
			message: {
			required: '<span class="help-block"><?php echo $lang['59']; ?></span>',
			minlength: jQuery.format('<span class="help-block">Enter at least {0} characters.</span>')
			}
		}
		});
		});
	
	</script>
  <div class="container main-container">
	<div class="row">
    
          	<div class="col-md-9" style="min-height:700px">


                        
        <h1 class="text-center">Contact Us</h1>
<div class="row text-center">
 <h4> <?php echo $lang['37']; ?></h4>
        <?php echo $lang['38']; ?>
</div>
<br></br>

				<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">

				<?php if(isset($hasError)) { //If errors are found ?>
				<div class="alert alert-danger text-center" role="alert">
						<?php echo $lang['39']; ?>
				</div>
				<?php } ?>
				
				<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
				<div class="alert alert-success text-center" role="alert">
						<?php echo $lang['40']; ?>
				</div>

				<?php } ?>

					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" >
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" >
						</div>
					</div>

					<div class="form-group">
						<label for="subject" class="col-sm-2 control-label">Subject</label>
						<div class="col-sm-10">
							<input type="subject" class="form-control" id="subject" name="subject" placeholder="subject" >
						</div>
					</div>

					<div class="form-group">
						<label for="message" class="col-sm-2 control-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="4" name="message" placeholder="message"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
						<?php
						if(isset($error)){
							echo $error;
						}?>
					<br />
						</div>
					</div>
				</form> 



</div>              
            
<?php
// Sidebar
require_once("sidebar.php");
?>     		
        </div>
    </div> <br />
	
		<?php
require_once('footer.php');
?>