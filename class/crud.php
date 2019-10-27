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

public function companyregister($email,$comname,$comnum,$compasss,$chk){
	        $response = false; $status = '0';
					$ex = explode(" ",$comname);
					$id = $ex[0];
					//creates a unique id
				 $a = uniqid($id);

			   $serial = ""; $date = Date('Y'); $day = Date('d');
         $con = 'CM-'.$a.$date.'-'.$day;
	       $inser = "INSERT INTO `courier_co` (ccid,name,email,phone,agree) values(:ccid,:name,:email,:phone,:agree)";
         $run = $this ->conn ->prepare($inser);
				 $run ->bindParam(":ccid",$con, PDO::PARAM_STR);
         $run ->bindParam(":name",$comname, PDO::PARAM_STR);
         $run ->bindParam(":email",$email, PDO::PARAM_STR);
         $run ->bindParam(":phone",$comnum, PDO::PARAM_STR);
         $run ->bindParam(":agree",$chk, PDO::PARAM_STR);
         $run ->execute();
         //print_r($run ->errorInfo());
         if($run ->rowCount()){
           $response = true;
          return $this->insertlogin($con,$email,$compasss,$status,$comnum);
				}

     }

		 public function insertlogin($con,$email,$compasss,$status,$comnum){
		 	       $response = false; $role="company";
		 	       $inser = "INSERT INTO `login` (user_id,username,password,role,status) values(:user_id,:username,:password,:role,:status)";
		          $run = $this ->conn ->prepare($inser);
		          $run ->bindParam(":user_id",$con, PDO::PARAM_STR);
		          $run ->bindParam(":username",$email, PDO::PARAM_STR);
		          $run ->bindParam(":password",$compasss, PDO::PARAM_STR);
							$run ->bindParam(":role",$role, PDO::PARAM_STR);
		          $run ->bindParam(":status",$status, PDO::PARAM_STR);
		          $run ->execute();
		          //print_r($run ->errorInfo());
		          if($run ->rowCount()){
		            $response = true;
		            return $this->insertcode($con,$comnum);
		          }
		 }

		 public function insertcode($con,$comnum){
		 	       $response = false; $code = rand(1000,9999); $confirmed = '0';
		 	       $inser = "INSERT INTO `confirmcode` (user_id,confirm_code,confirmed) values(:user_id,:confirm_code,:confirmed)";
		          $run = $this ->conn ->prepare($inser);
		          $run ->bindParam(":user_id",$con, PDO::PARAM_STR);
		          $run ->bindParam(":confirm_code",$code, PDO::PARAM_STR);
							$run ->bindParam(":confirmed",$confirmed, PDO::PARAM_STR);
		          $run ->execute();
		          //print_r($run ->errorInfo());
		          if($run ->rowCount()){
		            $response = true;
								$key = 'gI8VAfdTixNqRGOWio5w6TZMh';
			          $sender_id = 'PICKAPP';
			          $serial = "Verification Code. \n\n $code";
			          $message = urlencode($serial);
			          $url="https://apps.mnotify.net/smsapi?key=$key&to=$comnum&msg=$message&sender_id=$sender_id";
			          $result=file_get_contents($url); //call url and store result;

			              switch($result){
			                  case "1000":
			                           $res = "Verification code sent successfully";
			                  break;
			                  case "1002":
			                           $res = "Verification code not sent";
			                  break;
			                  case "1003":
			                           $res = "You don't have enough balance";
			                  break;
			                  case "1004":
			                           $res =  "Invalid API Key";
			                  break;
			                  case "1005":
			                           $res =  "Phone number not valid";
			                  break;
			                  case "1006":
			                           $res = "Invalid Sender ID";
			                  break;
			                  case "1008":
			                           $res = "Empty message";
			                  break;
			             }

		            return array("response"=>$response);
		          }else{

								return array("response"=>$response);
							}
		 }

		 public function verify_me($code){
             $response = false; $confirm = "1";
             // verify verification code sent to user
            $updatecode = "UPDATE `confirmcode` SET `confirmed`='$confirm' WHERE `confirm_code` = '$code'";
            $run = $this ->conn ->prepare($updatecode);
            $run->execute();
            //print_r($run ->errorInfo());
            if($run ->rowCount()){
                $response = true;
						 return $this->getuser_id($code);
            }
     }
		 public function getuser_id($code){
             $response = false; $confirm = "1";
             // verify verification code sent to user
						 $login = "SELECT `user_id` FROM `confirmcode` WHERE `confirm_code`='$code' AND `confirmed`='1' LIMIT 1";
 				    $run = $this ->conn->prepare($login);
 						$run->execute();
						//print_r($run ->errorInfo());
 				    if($run ->rowCount()){
 							$response = true;
 							while ($info = $run->fetchObject()) {
 								$user_id = preg_replace("#[^0-9a-zA-Z-]#","",$info ->user_id);
								return $this->confirmlogin($user_id);
 					    }
							//return array('response'=>$response);
			 }

}
		 public function confirmlogin($user_id){
             $response = false; $status = "1";
             // verify verification code sent to user
            $updatelogin = "UPDATE `login` SET `status`='$status' WHERE `user_id` = '$user_id'";
            $run = $this ->conn ->prepare($updatelogin);
            $run->execute();
            //print_r($run ->errorInfo());
            if($run ->rowCount()){
                $response = true;
              return array('response'=>$response);
            }
     }
}
