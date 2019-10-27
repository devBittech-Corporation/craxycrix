<?php
ob_start();
require_once '../../class/crud.php';
$crud = new Crud();

// Set post values to avoid undefined Index error
if (isset($_POST['comemail']) && isset($_POST['comname']) && isset($_POST['comnum']) && isset($_POST['compasss']) && isset($_POST['chk'])) {
  // Now call set info
  $email = preg_replace("#[^0-9a-zA-z@.]#","",$_POST['comemail']);
  $comname = preg_replace("#[^a-zA-z.' ]#","",$_POST['comname']);
  $comnum = preg_replace("#[^0-9-]#","",$_POST['comnum']);
  $compasss = md5($_POST['compasss']);
  $chk = preg_replace("#[^0-9]#","",$_POST['chk']);

  if (!empty($email) && !empty($comname) && !empty($comnum) && !empty($compasss) && !empty($chk)) {
    // send data

  	$result = $crud->companyregister($email,$comname,$comnum,$compasss,$chk);
   if ($result['response']){
      // code...
      echo $result['response'];
    }
  }
}


?>
