<?php
ob_start();
//getallheaders
header('Access-Control_Allow-Origin: *');
header('Content-Type: application/json');

//require_once '../class/crud.php';
require_once 'login_code.php';
$crud = new Crud();

   $result = $crud->login($login);

   $response = false;
   $result ->num_rows;
  if(num_rows > 0){
    $response = true;
    while ($info = $run -> fetch_assoc()) {
      $user_id  = $info['user_id'];
      $role     = $info['role'];
      $username = $info['username'];
      $vars = array(
        'user_id'=>$user_id,
        'role'=>$role,
        'username'=>$username
      );
    }
     echo json_encode($vars);
  }








?>
