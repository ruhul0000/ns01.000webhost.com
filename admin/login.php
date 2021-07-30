<?php
session_start();

define('IN_ADMIN', true);


define('D_S',DIRECTORY_SEPARATOR);
define('ADMIN_DIR', realpath(dirname(__FILE__)) .D_S);
define('ROOT_DIR', realpath(dirname(dirname(__FILE__))) .D_S);

define('INCLUDE_DIR',realpath(dirname(dirname(__FILE__))) .D_S.'include'.D_S);
define('VERSION','1.3');


require(ROOT_DIR.'config.php');
require(INCLUDE_DIR.'application.php');


$connection = dbConncet($dbHost,$dbUser,$dbPass,$dbName);


if(isset($_SESSION['login'])){

header("Location: /admin/");


exit();

} 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = addslashes($_POST['username']);
		$password = $_POST['password'];
		$password = md5(sha1(addslashes($password)));

	
	$query = mysqli_query($connection, "SELECT * FROM user WHERE username ='$username' AND password = '$password'");

    if (mysqli_num_rows($query) > 0)

    {

    $row = mysqli_fetch_array($query);

    $get_Password =   Trim($row['password']);

    $admin_Name =   Trim($row['name']);
	
	$user_Name =   Trim($row['username']);

    if ($get_Password == $password) {

        

    $_SESSION['login'] = true;

    $_SESSION['name'] = $admin_Name;
	
	$_SESSION['username'] = $user_Name;
	
	$_SESSION['password'] = $get_Password;

header("Location: /admin/");
    }

    else

    {

    $msg = '  <div class="alert alert-danger alert-dismissable">

                                        <i class="fa fa-ban"></i>

                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>

                                        <b>Alert!</b> Password is Wrong. Try Again! 

                                    </div> ';

    }

  }

  else

  {

    $msg = ' <div class="alert alert-danger alert-dismissable">

                                        <i class="fa fa-ban"></i>

                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>

                                        <b>Alert!</b> Login Failed. Try Again! 

                                    </div> ';

  }
}
				
?>

<!DOCTYPE html>

<html>

  <head>

    <meta charset="UTF-8" />

    <title>Admin Login</title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme style -->

    <link href="assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />


  </head>

  <body class="login-page">

    <br />

    <div class="login-box">

      <div class="login-logo">
        <b>Admin</b> Login
      </div>

      <div class="login-box-body">

        <p class="login-box-msg"><strong>Admin Section</strong> <br/> Sign in to start your session</p>

        <?php 

        if(isset($msg))

        echo $msg;

        ?>

        <form action="#" method="POST">

          <div class="form-group has-feedback">

            <input type="username" name="username" class="form-control" placeholder="Username" />

            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

          </div>

          <div class="form-group has-feedback">

            <input type="password" name="password" class="form-control" placeholder="Password" />

            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

          </div>


          <div class="row">


            <div class="col-xs-4">

              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

            </div><!-- /.col -->

          </div>

        </form>

        <br />

	<div class="login-extra">
	<center>Copyright &copy; 2016 <a href="http://smallseostats.com/">SmallSeoStats.Com.</a> </center>
	</div> <!-- /login-extra -->


      </div>

    </div>



    <script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>


    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


   </body>

</html>