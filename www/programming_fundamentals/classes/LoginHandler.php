<?php
class LoginHandler {
	
	public function __construct() {
		switch (@$_POST["action"]) {
			case "login":
				$this->login();
				break;
			case "logout":
				$this->logout();
				break;
			default:
				if (!@$_SESSION["uid"]) {
					utils_302(WEB_ROOT . '/');
				}
		}
		/*$phone =  Shared::preparePhone(@$_SESSION['phone']);
		if (strlen($phone) < 5) {
			$this->stopSql = true;
		} else {
			$this->filter = " WHERE phone = '$phone' AND m.is_deleted != 1 ";
		}
		$this->exec();*/
	}
	
	private function logout(){
		$_SESSION = array();
		utils_302(WEB_ROOT . '/');
	}
	
	private function login(){
		//$phone = Shared::preparePhone(@$_POST["phone"]);
		$email = @$_POST['email'];
		$password = md5(str_replace("'", '&quot;', trim(@$_POST["password"])));
		$data = query("SELECT u.id FROM users AS u
		WHERE u.email = '$email' AND u.pwd = '$password'", $nR);
		$id = 0;
		if ($nR) {
			$row = $data[0];
			$id = $row['id'];
		}
		if ($id) {
			$_SESSION["authorize"] = true;
			$_SESSION["uid"] = $id;
			$_SESSION["email"] = $email;
			print json_encode(array("success"=>'1'));
		} else {
			print json_encode(array("success"=>'0'));
		}
		exit;
	}
}
