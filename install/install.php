<?php
ob_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>Seo Stats | Installer Script</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<?php
$check ='1';
$step = (isset($_GET['step']) && $_GET['step'] != '') ? $_GET['step'] : '';
switch($step){
case '1':
step_1();
break;
case '2':
step_2();
break;
default:
step_1();
}
?>
<body>

<?php 

function step_1(){
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] ==''){
header('Location: install.php?step=1');
exit;
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] != ''){
echo $_POST['pre_error'];
}
if (!phpversion() >= '5.3.0') {
$pre_error = 'You need to use PHP5 or above for our site!<br />';
$check = '0';
}
if (!function_exists('mysqli_connect')) {
$pre_error .= 'Our site will not work with mysqli_connect enabled!<br />';
$check = '0';
}
if (!extension_loaded('gd')) {
$pre_error .= 'GD extension needs to be loaded for our site to work!<br />';
$check = '0';
}
if (!ini_get('allow_url_fopen')) {
$pre_error .= 'allow_url_fopen() needs to be loaded for our site to work!<br />';
$check = '0';
}
if (!function_exists('mcrypt_module_open')) {
$pre_error .= 'mcrypt_module_open() needs to be loaded for our site to work!<br />';
$check = '0';
}
if(!function_exists("curl_init")) {
$pre_error .= 'PHP cURL plugin/addon is missing. Nothing will work without it!';
$check = '0';
}
if (!is_writable('../config.php')) {
$pre_error .= 'config.php needs to be writable for our site to be installed!';
$check = '0';
}
  ?>
  <div class="col-md-6 col-md-offset-3">
  <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title text-center">Checking your system configuration</h3>
                </div><!-- /.box-header -->

                <div class="box-body">
				
				<table class="table table-hover">
  <tr>
   <td>PHP Version (<?php echo phpversion(); ?>)</td>
 
   <td><?php echo (phpversion() >= '5.3.0') ? '<span class="label label-success">Ok</span>' : '<span class="label label-danger">Not Ok</span>'; ?></td>
  </tr>
  <tr>
   <td>Mysqli extension</td>
   <td><?php echo function_exists('mysqli_connect') ? '<span class="label label-success">On</span>' : '<span class="label label-danger">Off</span>'; ?></td>
  </tr>
  <tr>
   <td>GD</td>
   <td><?php echo extension_loaded('gd') ? '<span class="label label-success">On</span>' : '<span class="label label-danger">Off</span>'; ?></td>
  
  
  </tr>
  <tr>
   <td>file_get_contents()</td>
   <td><?php echo ini_get('allow_url_fopen') ? '<span class="label label-success">On</span>' : '<span class="label label-danger">Off</span>'; ?></td>
  
  
  </tr>
  <tr>
   <td>Mcrypt extension</td>
   <td><?php echo function_exists('mcrypt_module_open') ? '<span class="label label-success">On</span>' : '<span class="label label-danger">Off</span>'; ?></td>
  
  
  </tr>
  <tr>
   <td>curl_init()</td>
   <td><?php echo function_exists('curl_init') ? '<span class="label label-success">On</span>' : '<span class="label label-danger">Off</span>'; ?></td>
  
  
  </tr>
  <tr>
   <td>config.php</td>
   <td><?php echo is_writable('../config.php') ? '<span class="label label-success">Writable</span>' : '<span class="label label-danger">Unwritable</span>'; ?></td>
  
  </tr>
  </table>
             
                
                </div><!-- /.box-body -->
      
</div><!-- /.box -->
  <form action="install.php?step=2" method="post">
    <input type="hidden" name="pre_error" id="pre_error" value="<?php echo $pre_error;?>" />
   
	<?php  if($check== '0') { ?>
		  <input type="submit" name="continue" value="Continue" disabled/>
	<?php } else { ?>                                      
			  <input type="submit" name="continue" value="Continue To Next Step"/>
	 <?php } ?>   
	</div>
  </form>
</div>
<?php
}

function step_2(){
	
if (!phpversion() >= '5.3.0') {
$pre_error = 'You need to use PHP5 or above for our site!<br />';
$check = '0';
}
if (!function_exists('mysqli_connect')) {
$pre_error .= 'Our site will not work with mysqli_connect enabled!<br />';
$check = '0';
}
if (!extension_loaded('gd')) {
$pre_error .= 'GD extension needs to be loaded for our site to work!<br />';
$check = '0';
}
if (!ini_get('allow_url_fopen')) {
$pre_error .= 'allow_url_fopen() needs to be loaded for our site to work!<br />';
$check = '0';
}
if (!function_exists('mcrypt_module_open')) {
$pre_error .= 'mcrypt_module_open() needs to be loaded for our site to work!<br />';
$check = '0';
}
if(!function_exists("curl_init")) {
$pre_error .= 'PHP cURL plugin/addon is missing. Nothing will work without it!';
$check = '0';
}
if (!is_writable('../config.php')) {
$pre_error .= 'config.php needs to be writable for our site to be installed!';
$check = '0';
}

if($check =='0'){
header('Location: install.php?step=1');
exit;
}

if (isset($_POST['submit']) && $_POST['submit']=="Install!") {
  

$database_host=isset($_POST['database_host'])?$_POST['database_host']:"";
$database_name=isset($_POST['database_name'])?$_POST['database_name']:"";
$database_username=isset($_POST['database_username'])?$_POST['database_username']:"";
$database_password=isset($_POST['database_password'])?$_POST['database_password']:"";
$admin_name=isset($_POST['ad_name'])?$_POST['ad_name']:"";
$admin_user=isset($_POST['ad_user'])?$_POST['ad_user']:"";
$admin_password=isset($_POST['ad_pass'])?$_POST['ad_pass']:"";
$admin_password = md5(sha1(addslashes($admin_password)));

if (empty($admin_name) || empty($admin_user)  || empty($admin_password) || empty($database_host) || empty($database_username) || empty($database_name)) {
$err = '<div class="alert alert-danger" role="alert">
					All fields are required! Please re-enter.<br />
				</div>';
} else {

$connection = @mysqli_connect($database_host,$database_username,$database_password,$database_name);

if(!$connection)
{
die('<center>Database Connection failed.</center>');
}

  
   
$sql = "CREATE TABLE IF NOT EXISTS user (
  id int(11) NOT NULL AUTO_INCREMENT,
  username text NOT NULL,
  password text NOT NULL,
  name text NOT NULL,
  PRIMARY KEY (id)
)";

mysqli_query($connection,$sql);
     
$query = "INSERT INTO user (username,password,name) VALUES ('$admin_user','$admin_password','$admin_name')"; 
mysqli_query($connection,$query);
  

$sql = "CREATE TABLE IF NOT EXISTS site_config (
  id int(11) NOT NULL AUTO_INCREMENT,
  title text NOT NULL,
  description text NOT NULL,
  keyword text NOT NULL,
  email text NOT NULL,
  verify_code text NOT NULL,
  domain_name text NOT NULL,
  facebook text NOT NULL,
  twitter text NOT NULL,
  google text NOT NULL,
  PRIMARY KEY (id)
)";
    
mysqli_query($connection,$sql);


$query = "INSERT INTO site_config (id, title, description, keyword, email, verify_code, domain_name, facebook, twitter, google) VALUES
(1, 'SEO Stats and Site Analysis', 'SEO Stats is a free online seo tool for checking all free search engine optimization online tools. ', 'seo stats,  domain info, top keyword, google page rank', 'admin@admin.com', '', 'SEO Stats and Site Analysis', 'https://www.facebook.com/', 'https://twitter.com/', 'https://plus.google.com/');"; 
mysqli_query($connection,$query);


$sql = "CREATE TABLE IF NOT EXISTS site_ads (
  id int(11) NOT NULL AUTO_INCREMENT,
  ads_spot1 text NOT NULL,
  ads_spot2 text NOT NULL,
  ads_spot3 text NOT NULL,
  PRIMARY KEY (id)
)";

mysqli_query($connection,$sql);
     
$query = "INSERT INTO site_ads (id, ads_spot1, ads_spot2, ads_spot3) VALUES
(1, '<img src=\"assets/img/728x90.png\">', '<img src=\"assets/img/728x90.png\">', '<img src=\"assets/img/400x300.png\">');"; 
mysqli_query($connection,$query);



$sql = "CREATE TABLE IF NOT EXISTS pages (
  id int(11) NOT NULL AUTO_INCREMENT,
  pagename text,
  permalink text,
  pagetitle text,
  pagedescription text,
  pagecontent text,
  PRIMARY KEY (id)
)";

mysqli_query($connection,$sql);
     
$query = "INSERT INTO pages (id, pagename, permalink, pagetitle, pagedescription, pagecontent) VALUES
(1, 'Terms Of Service', 'terms-of-service', 'Terms Of Service', 'Terms Of Service', '<p><strong>It is a sample term of services page!</strong></p>'),
(2, 'About US', 'about-us', 'About US', 'About US', '<p><strong>It is a sample about us&nbsp;page!</strong></p>');"; 
mysqli_query($connection,$query);


$sql = "CREATE TABLE IF NOT EXISTS domain (
  id int(11) NOT NULL AUTO_INCREMENT,
  domain text,
  ip text,
  https text NOT NULL,
  alexa_global_rank text NOT NULL,
  alexa_pop text NOT NULL,
  alexa_regional_rank text NOT NULL,
  alexa_web text NOT NULL,
  alexa_flag text NOT NULL,
  pr_rank text NOT NULL,
  safe_value text NOT NULL,
  get_top_keyword_data text NOT NULL,
  get_top_country_data text NOT NULL,
  header text NOT NULL,
  rec text NOT NULL,
  ip_host_info text NOT NULL,
  block int(11) NOT NULL,
  date text,
  PRIMARY KEY (id)
)";

mysqli_query($connection,$sql);

$f=fopen("../config.php","w");

$database_inf = '<?php
 
// Report all errors
error_reporting(E_ALL);

// Database Hostname
$dbHost = \''.$database_host.'\';

// Database Username
$dbUser = \''.$database_username.'\';

// Database Password
$dbPass = \''.$database_password.'\';

// Domain Name
$dbName = \''.$database_name.'\';

?>';
  if (fwrite($f,$database_inf)>0){
   fclose($f);
  }
echo '<div class="col-md-6 col-md-offset-3">
<div class="alert alert-success" role="alert">
Installation Seo Stats Complete!					
</div></div>
';

echo "<meta http-equiv='refresh' content='2;url=/admin/login.php'>";
unlink('install.php');
  }
  }
?>
  <div class="col-md-6 col-md-offset-3">
<div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title text-center">Database Connection</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
								  <form method="post" action="install.php?step=2">
								  <?php
									if(isset($err)){
										echo $err;
									}?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="data_host">Database Host</label> &nbsp; <small>(Mostly "localhost")</small>
                                            <input type="text" placeholder="Enter your database hostname" name="database_host" id="database_host" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="data_name">Database Name</label>
                                            <input type="text" placeholder="Enter your database name" name="database_name" id="database_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="data_user">Database Username</label>
                                            <input type="text" placeholder="Enter your database username" name="database_username" id="database_username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="data_pass">Database Password</label>
                                            <input type="password" placeholder="Enter your database password" name="database_password" id="database_password" class="form-control">
                                        </div>
										<hr>
										<div class="form-group">
                                            <label for="data_pass">Admin Name</label>
                                            <input type="text" placeholder="Enter your admin name" name="ad_name" id="ad_name" class="form-control">
                                        </div>
										<div class="form-group">
                                            <label for="data_pass">Admin Username</label>
                                            <input type="text" placeholder="Enter your admin username" name="ad_user" id="ad_user" class="form-control">
                                        </div>
										<div class="form-group">
                                            <label for="data_pass">Admin Password</label>
                                            <input type="password" placeholder="Enter your admin password" name="ad_pass" id="ad_pass" class="form-control">
                                        </div>
                                        
                               <?php  if($check== '0') { ?>
								<input type="submit" name="submit" value="Install!" disabled>
									<?php } else { ?>                                      
											  <input type="submit" name="submit" value="Install!">
									 <?php } ?>  
                                
                                         </div><!-- /.box-body -->
									</form>
                                  

                            </div> 
							</div>
  
<?php
}
?>
