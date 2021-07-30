<?php
if (!defined('IN_ADMIN')) die("Hacking attempt");

 
if(!isset($_SESSION['login'])){

header("Location: login.php");

exit();

}


 
define('D_S',DIRECTORY_SEPARATOR);
define('ADMIN_DIR', realpath(dirname(__FILE__)) .D_S);
define('ROOT_DIR', realpath(dirname(dirname(__FILE__))) .D_S);
define('INCLUDE_DIR',realpath(dirname(dirname(__FILE__))) .D_S.'include'.D_S);

define('VERSION','1.0');

require(ROOT_DIR.'config.php');
require(INCLUDE_DIR.'application.php');


//Database Connection

$connection = dbConncet($dbHost,$dbUser,$dbPass,$dbName);


$query =  "SELECT * FROM user where id='1'";

$result = mysqli_query($connection,$query);

        

while($row = mysqli_fetch_array($result)) {

$adminUser =  Trim($row['username']);

$adminPssword = Trim($row['password']);

$adminName =   Trim($row['name']);

} 

?>

<!DOCTYPE html>



<html>

  <head>

    <meta charset="UTF-8">

    <title>SEO Stats | Admin Panel</title>


    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />


    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />


    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />

 

    <link href="assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />


    <link href="assets/dist/css/skins/default.css" rel="stylesheet" type="text/css" />



  </head>



  <body class="skin-blue sidebar-mini">

    <div class="wrapper">



      <!-- Main Header -->

      <header class="main-header">



        <!-- Logo -->

        <a href="/admincp/" class="logo">

          <span class="logo-mini"><b>S</b>EO</span>


          <span class="logo-lg"><b>Admin Panel</b></span>

        </a>



        <!-- Header Navbar -->

        <nav class="navbar navbar-static-top" role="navigation">

          <!-- Sidebar toggle button-->

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

          </a>

          <!-- Navbar Right Menu -->

          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
			
<li>
                        <a href="account.php">
                            <i class="fa fa-cog"></i>
                            <span class="sr-only">Settings</span>
                        </a>
                        
                    </li>
<li>
                        <a href="logout.php">
                            <i class="fa fa-power-off"></i>
                            <span class="sr-only">Logout</span>
                        </a>
                    </li>
                  
			  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $adminName; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                       
                        <li>
                            <a href="/" target="_blank"><i class="glyphicon glyphicon-globe"></i> View Site</a>
                        </li>
                        <li>
                            <a href="account.php"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>

            </ul>

          </div>

        </nav>

      </header>

           
	<aside class="main-sidebar">
			<section class="sidebar">       
			  <ul class="sidebar-menu">
				<li><a href="index.php"><i class="fa fa-cogs"></i> <span>Website Settings</span></a></li>
				<li><a href="domain.php"><i class="fa fa-wrench"></i> <span>Manage Domain </span></a></li>
				<li><a href="pages.php"><i class="fa fa-files-o"></i> <span>Manage Pages</span></a></li>
				<li><a href="ads.php"><i class="fa fa-puzzle-piece"></i> <span>Manage Ads</span></a></li>
				<li><a href="account.php"><i class="fa fa-user"></i> <span>Account Settings</span></a></li>
			  </ul>
			</section>
		  </aside>