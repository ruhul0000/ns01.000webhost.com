<?php

if (!defined('IN_ADMIN')) die("Hacking attempt");

 
define('D_S',DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath(dirname(__FILE__)) .D_S);
define('INCLUDE_DIR', ROOT_DIR .'include'.D_S);


require(ROOT_DIR.'config.php');
require(INCLUDE_DIR.'application.php');

require(INCLUDE_DIR.'lang_en.php');


// Check installation
$filename = 'install/install.php';

if (file_exists($filename)) {
    echo "<br /> <br />  <center>Redirecting to installer panel...</center>";
    echo '<meta http-equiv="refresh" content="1;url=/install/install.php">';
    exit();
} 

//Database Connection

$connection = dbConncet($dbHost,$dbUser,$dbPass,$dbName);


$query =  "SELECT * FROM site_config";

$result = mysqli_query($connection,$query);

        

while($row = mysqli_fetch_array($result)) {

    $title = Trim($row['title']);

    $description= Trim($row['description']);

    $keyword = Trim($row['keyword']);

    $contact_email = Trim($row['email']);
	
	$verify_code =  Trim($row['verify_code']);

	$domain_name =  Trim($row['domain_name']);
	
	$facebook =  Trim($row['facebook']);
	
	$twitter =  Trim($row['twitter']);
	
	$google =  Trim($row['google']);


}


//Get Ads Settings

$query = "SELECT * FROM site_ads";

$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_array($result))

{

    $ads_spot1 = Trim($row['ads_spot1']);

    $ads_spot2 = Trim($row['ads_spot2']);

    $ads_spot3 = Trim($row['ads_spot3']);

}




?>

<!DOCTYPE html>

<html>

    <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

      <base href="/" />      

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <meta http-equiv="Content-Language" content="en" />

        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Meta Data-->

        <title><?php if(isset($title)) { echo $title; } ?></title>

              
        <meta name="description" content="<?php echo $description; ?>" />

        <meta name="keywords" content="<?php echo $keyword; ?>" />

        <?php echo html_entity_decode($verify_code); ?>

        <link href="assets/css/theme.css" rel="stylesheet" />

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		<script type='text/javascript' src='https://www.google.com/jsapi'></script>

</head>



<body>   


<div class="navbar-more-overlay"></div>
	<nav class="navbar navbar-inverse navbar-fixed-top animate">
		<div class="container navbar-more visible-xs">
			<form class="navbar-form navbar-left" action="process.php" method="post">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" name="url" id="url" placeholder="<?php echo $lang['8']; ?>">
						<span class="input-group-btn">
							<button type="submit" class="btn seo" id="check"><span class="fa fa-check-circle-o" aria-hidden="true"></span> Check Up!</button>
						</span>
					</div>
				</div>
			</form>
			<ul class="nav navbar-nav">
<?php
		  
			$query = "SELECT * FROM pages"; 
			
			$result = mysqli_query($connection, $query);
			$numResults = mysqli_num_rows($result);
			while($row = mysqli_fetch_array($result)) {
				$permalink = Trim($row['permalink']);
				$pagename = Trim($row['pagename']);
?>
<li>
					<a href="page/<?php echo $permalink; ?>/">
						<span class="menu-icon fa fa-angle-double-right"></span>
						<?php echo $pagename; ?>
					</a>
				</li>
<?php				
			}
	
?>

<li>
					<a href="/contact/">
						<span class="menu-icon fa fa-angle-double-right"></span>						
						Contact Us</span>
					</a>
				</li>

			</ul>
		</div>
		<div class="container">
			<div class="navbar-header hidden-xs">
				<a class="navbar-brand" href="/" title="SeoStats"><img src="assets/img/logo_seostats.png" class="img-responsive" alt="SeoStats"></a>

			</div>

			<ul class="nav navbar-nav navbar-right mobile-bar">
				<li>
					<a href="/">
						<span class="menu-icon fa fa-home"></span>
						<span class="hidden-xs"><span class="fa fa-home" aria-hidden="true"></span> <?php echo $lang['1']; ?></span>
<span class="visible-xs"> <?php echo $lang['1']; ?></span>
						
					</a>
				</li>
				<li>
					<a href="/recent/">
						<span class="menu-icon fa fa-bar-chart"></span>
						<span class="hidden-xs"><span class="fa fa-clock-o" aria-hidden="true"></span> <?php echo $lang['2']; ?></span>
						<span class="visible-xs"><?php echo $lang['3']; ?></span>
					</a>
				</li>
				<li class="hidden-xs">
					<a href="/contact/"><span class="fa fa-envelope"></span>
                                                <span class="hidden-xs"><?php echo $lang['4']; ?></span>
						  
					</a>
				</li>

				<li>
					<a href="#" data-target="#Modal_My_History_Site" data-toggle="modal">

						<span class="menu-icon fa fa-star"></span>
                                                <span class="hidden-xs"><span class="fa fa-clock-o" aria-hidden="true"></span> <?php echo $lang['5']; ?></span>
						<span class="visible-xs"><?php echo $lang['6']; ?></span>
						  
					</a>
				</li>
				
				
				<li class="visible-xs">
					<a href="#navbar-more-show">
						<span class="menu-icon fa fa-bars"></span>
						<?php echo $lang['7']; ?>
					</a>
				</li>
			</ul>
		</div>
	</nav>