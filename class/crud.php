<?php
require_once("dbconfig.php");

class Crud extends DbCOnfig {
	public function __construct() {
		parent::__construct();
	}

	public function login($username,$password){
     $response = false;
		$login = "SELECT `user_id`,`username`,`password`,`role`,`status` FROM `login` WHERE `username`='$username' AND `password`='$password' AND `status`='1' LIMIT 1";
    $run = $this ->conn->prepare($login);
		$run->execute();
    if($run ->rowCount()){
			$response = true;
			while ($info = $run->fetchObject()) {
				$user_id = preg_replace("#[^0-9a-zA-Z-]#","",$info ->user_id);
				$role = preg_replace("#[^0-9a-zA-Z-]#","",$info ->role);
				$username = preg_replace("#[^0-9a-zA-Z-]#","",$info ->username);
				$vars = array(
	        'user_id'=>$user_id,
	        'role'=>$role,
	        'username'=>$username
	      );
	    }
	     $json = json_encode($vars);
    }
		return array("response"=>$response,"data"=>$json);
}

public function companyregister($username,$password){
	 $response = false;
	$login = "SELECT `user_id`,`username`,`password`,`role`,`status` FROM `login` WHERE `username`='$username' AND `password`='$password' AND `status`='1' LIMIT 1";
	$run = $this ->conn->prepare($login);
	$run->execute();
	if($run ->rowCount()){
		$response = true;
		while ($info = $run->fetchObject()) {
			$user_id = preg_replace("#[^0-9a-zA-Z-]#","",$info ->user_id);
			$role = preg_replace("#[^0-9a-zA-Z-]#","",$info ->role);
			$username = preg_replace("#[^0-9a-zA-Z-]#","",$info ->username);
			$vars = array(
				'user_id'=>$user_id,
				'role'=>$role,
				'username'=>$username
			);
		}
		 $json = json_encode($vars);
	}
	return array("response"=>$response,"data"=>$json);
}
}
