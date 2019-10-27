<?php
ob_start();
require_once '../../class/crud.php';
$crud = new Crud();

// Set post values to avoid undefined Index error
if (isset($_POST['comemail']) && isset($_POST['comname']) && isset($_POST['comnum']) && isset($_POST['compasss'])) {
  // Now call set info
  $email = preg_replace("#[^0-9a-zA-z@.]#","",$_POST['email']);
  $comname = preg_replace("#[^a-zA-z.' ]#","",$_POST['comname']);
  $comnum = preg_replace("#[^0-9-]#","",$_POST['comnum']);
  $compasss = $_POST['compasss'];

  if (!empty($email) && !empty($comname) && !empty($comnum) && !empty($compasss)) {
    // send data

  	$result = $crud->companyregister($email,$comname,$comnum,$compasss);
    if ($result['response']){
      // code...
      //$user_id = $crud ->login($username,$password)['user_id'];
      $res = json_decode($result['data'], true);
      $user_id = $res['user_id'];
      $role = $res['role'];
      $username = $res['username'];
      if ($role == 'admin') {
        // code...
        $_SESSION['_role'] = $role;
        $_SESSION['_super'] = $username;
  	    setcookie("_super",$username, time()+ (80 * 30), "/");
        setcookie("_role",$role, time()+ (80 * 30), "/");
        echo $result['response'];
      }else {
        // code...
        echo "Null";
      }

    }

  }
}


?>
