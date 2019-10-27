<?php
ob_start();
require_once '../class/crud.php';
if(!isset($_COOKIE['_role']) && !isset($_COOKIE['_super'])){
  header("Location: ../register/login.html");
}else{
	$username = preg_replace("#[^0-9a-zA-Z@. ]#","",$_COOKIE['_super']);
  $role = preg_replace("#[^0-9a-zA-Z@. ]#","",$_COOKIE['_role']);

}
?>
