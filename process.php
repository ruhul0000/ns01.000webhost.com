<?php
ob_start();

define('D_S',DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath(dirname(__FILE__)) .D_S);
define('INCLUDE_DIR', ROOT_DIR .'include'.D_S);


require(ROOT_DIR.'config.php');
require(INCLUDE_DIR.'application.php');

require(INCLUDE_DIR.'lang_en.php');
 
$url = strtolower(Trim($_POST['url']));

$site = getDomainName($url);

header('Location: /domain/'.$site);

?>