<?
session_start();

 
session_destroy();
$_SESSION["login"]=false;
echo "<meta http-equiv='refresh' content='0;url=login.php'>";
?>