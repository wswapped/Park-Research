<?php


	function check_user($userData, $dataType = 'farmerId'){
		///checking the existence of the farmer with $userData of $dataType
		global $conn;
		$sql = "SELECT * FROM farmer WHERE `$dataType` = \"$userData\" ";
		$query = $conn->query($sql) or trigger_error($conn->error);

		return $query->fetch_assoc();
	}

	function login($username, $password, $keep_cookie=true){
		//function to login a user
		//if $keep_cookie is true then we could keep record for future usage
		global $conn;
		//check if username is phone or email
		if(is_numeric(trim($username, '+'))){
			//here there is phone number
		}else if(filter_var($username, FILTER_VALIDATE_EMAIL)){
			//email address
			$column = 'email';
		}else{
			echo "No format specified";
			return false;
		}

		$sql = "SELECT id FROM users WHERE `$column` = \"$username\" AND password = \"$password\" LIMIT 1 ";
		$query = $conn->query($sql) or trigger_error("Error loggin in $conn->error");
		$data = $query->fetch_assoc();

		if($keep_cookie){
			if(!session_id()){
				session_start();
			}

			$_SESSION['id'] = $data['id'];
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
		}	
		return $data['id'];
	}
	function dateDiff ($d1, $d2) {
		// Return the number of days between the two dates:
		 return round(abs(strtotime($d1)-strtotime($d2))/86400);
	}
	function get_user($user){
		global $conn;
		//returns details on the user
		$query = $conn->query("SELECT * FROM users WHERE id = \"$user\" LIMIT 1 ") or trigger_error("Can't get the user "+$conn->error);

		$user_data = $query->fetch_assoc();
		return $user_data;
	}

	function logout(){
		if(!session_id()){
			session_start();
		}

		session_destroy();
		header("location:login");
	}

	function current_season(){
		//determines the current current_season
		return 1;
	}
?>