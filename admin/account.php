<?php
session_start();

define('IN_ADMIN', true);

 
require_once('header.php');


?>


<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $passPage = true;

    $query = "SELECT * FROM user";

    $result = mysqli_query($connection,$query);

    while ($row = mysqli_fetch_array($result))

    {

    $admin_oldPass = Trim($row['password']);

    }



    $username = Trim($_POST['username']);

    $name = Trim($_POST['name']);
	
	$password = Trim($_POST['pass']);

	$new_pass = md5(sha1(addslashes($password)));

    $repass = md5(sha1(addslashes($_POST['repass'])));

    $oldpass = md5(sha1(addslashes($_POST['oldpass'])));

    

    if($new_pass == $repass){

    if($oldpass == $admin_oldPass){

        

    $query = "UPDATE user SET username='$username', password='$new_pass', name='$name' WHERE id='1'";

 



     if (!mysqli_query($connection, $query))

    {

        $msg = '<div class="alert alert-danger" role="alert">
						Change Passwors error!
					</div>';

    } else

    {

        $msg = '
<div class="alert alert-success" role="alert">
						New Passwors saved successfully!
					</div>
       ';

    }

    }else{

                        $msg = '<div class="alert alert-danger" role="alert">
						Old admin panel password is wrong!
					</div>';

    }

    }else{

                $msg = '<div class="alert alert-danger" role="alert">
						New Password field / Retype password field can\'t matched!
					</div>
					';

    }

    



  }







$query = "SELECT * FROM user";

$result = mysqli_query($connection,$query);

while ($row = mysqli_fetch_array($result))

{
	$id = Trim($row['id']);
	
    $username = Trim($row['username']);

    $password = Trim($row['password']);

    $name = Trim($row['name']);

}

?>
 <div class="content-wrapper" style="min-height: 360px;">
        <!-- Content Header (Page header) -->
       <section class="content-header">

          <h1>

            Manage Account 

            <small>Control panel</small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="/admincp/index.php">Admin</a></li>

            <li class="active">Manage Account </li>

          </ol>

        </section>

        <!-- Main content -->
        <section class="content">
			<div class="box box-primary">
			 <div class="box-header with-border">

                  <h3 class="box-title">Account Settings</h3>

                </div><!-- /.box-header -->

				<form class="form-horizontal" method="post">
				<div class="box-body">
						 <?php

						if(isset($msg)){

							echo $msg;

						}?>
						</br>				
						<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Admin Name</label>
						<div class="col-sm-10">
						<input type="text" class="form-control" id="name" value="<?php echo $name; ?>" name="name" placeholder="Your Name">
						</div>
						</div>								
						
						<div class="form-group">
						<label for="username" class="col-sm-2 control-label">Admin Email</label>
						<div class="col-sm-10">
						<input type="username" class="form-control" id="username" value="<?php echo $username; ?>" name="username" placeholder="Your Email">
						</div>
						</div>
						
					<fieldset>
					<legend>Change Password</legend>
						<div class="form-group">
						<label for="pass" class="col-sm-2 control-label">New Password</label>
						<div class="col-sm-10">
						<input type="password" class="form-control" id="pass" value="" name="pass" autocomplete="off" placeholder="New Password">
						</div>
						</div>
						
						<div class="form-group">
						<label for="repass" class="col-sm-2 control-label">Re Enter Password</label>
						<div class="col-sm-10">
						<input type="password" class="form-control" id="repass" value="" name="repass" autocomplete="off" placeholder="Re Enter Password">
						</div>
						</div>
						
						<div class="form-group">
						<label for="oldpass" class="col-sm-2 control-label">Old Password</label>
						<div class="col-sm-10">
						<input type="password" class="form-control" id="oldpass" value="" name="oldpass" autocomplete="off" placeholder="Re Enter Password">
						</div>
						</div>
						
					</fieldset>		
					<div class="box-footer">
						<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
						</div>
						</div>
					</div>
					</div>
					</form>
			</div>

        </section><!-- /.content -->
      </div>   
<?php
require_once(ADMIN_DIR.'footer.php');
?>