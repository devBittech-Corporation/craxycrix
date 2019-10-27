<?php
ob_start();
require_once '../../class/crud.php';
$crud = new Crud();

// Set post values to avoid undefined Index error
if (isset($_POST['email']) && isset($_POST['password'])) {
  // Now call set info
  $username = preg_replace("#[^0-9a-zA-z@. ]#","",$_POST['email']);
  $password = md5($_POST['password']);

  if (!empty($username) && !empty($password)) {
    // send data

  	$result = $crud->login($username,$password);
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
      }elseif ($role == 'company') {
        // code...
        $_SESSION['_role'] = $role;
        $_SESSION['_com'] = $username;
  	    setcookie("_com",$username, time()+ (80 * 30), "/");
        setcookie("_role",$role, time()+ (80 * 30), "/");
        echo 2;
      }else{
        // code...
        echo "Null";
      }

    }

  }
}


?>
