<?php
ob_start();
require_once '../../class/crud.php';
$crud = new Crud();

// Set post values to avoid undefined Index error
if (isset($_POST['veri'])) {
  // Now call set info
  $verification = preg_replace("#[^0-9]#","",$_POST['veri']);

  if (!empty($verification)) {
    // send data
   $result = $crud->verify_me($verification);
   if ($result['response']){
      // code...
      echo $result['response'];
    }
  }
}


?>
