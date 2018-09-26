<?php
	$request = array_merge($_POST, $_GET); //Storing request variables
	$response ='';
	include_once "../admin/db.php";
	include_once "../functions.php";
	if(!empty($request['action'])){
		$action = $request['action'];

		if($action == 'login'){
			$username = !empty($request['username'])?$request['username']:"";
			$password = !empty($request['password'])?$request['password']:"";

			if(!empty($username) && !empty($password)){
				//Going to validate
				//should we use the hashing??
				$query = mysqli_query($conn, "SELECT * FROM users WHERE username = \"$username\" AND password = \"$password\" LIMIT 1");
				if($query){
					//Query executed successfully
					if(mysqli_num_rows($query))
						$response = array('status'=>1);
					else $response = array('status'=>0, 'error'=>'Incorrect username or password');
				}else{
					$response = array('status'=>0, 'error'=>mysqli_error($conn));
				}

			}else{
				$response = array('status'=>0, 'error'=>"Specify both username and password");
			}
		}else if($action == 'signup'){
			$name = !empty($request['name'])?$request['name']:"";
			$username = !empty($request['username'])?$request['username']:"";
			$password = !empty($request['password'])?$request['password']:"";
			$location = !empty($request['location'])?$request['location']:"";


			if(!empty($name) && !empty($username) && !empty($password) && !empty($location)){
				//Inserting data
				$query = mysqli_query($conn, "INSERT INTO users(name, username, password, location) VALUES (\"$name\", \"$username\", \"$password\", \"$location\")");
				if($query){
					$id = mysqli_insert_id($conn);
					$response = array('status'=>1, 'id'=>$id);
				}else{
					$response = array('status'=>0, 'error'=>"Error in data saving to database ".mysqli_error($conn));
				}
			}else{
				$response = array("status"=>0, 'error'=>'Provide all details(name, username, password and location)');
			}
		}else if($action == 'get_data'){
			$data = mysqli_query($conn, "SELECT *, sys.location as location FROM data JOIN systems as sys ON sys.id = data.DeviceID");
			if($data){

				$ret = array();
				while ($temp = mysqli_fetch_assoc($data) ){
					$ret[]=$temp;
				}
				$response = $ret;
			}else{
				$response = "Error".mysqli_error($conn);
			}
		}else if($action == 'record'){
			$mode = !empty($request['mode'])?$request['mode']:"";
			if(!empty($mode)){
				//Recording the mode
				$query = mysqli_query($conn, "INSERT INTO pipedata(mode) VALUES (\"$mode\")");
				if($query){
					$response = array('status'=>1);
				}else{
					$response = array('status'=>0, 'msg'=>mysqli_error($conn));
				}
			}else{
				$response = array('status'=>0);
			}
		}else if($action == 'get_pipe'){
			$query = mysqli_query($conn, "SELECT * FROM pipedata ORDER BY time DESC LIMIT 1");
			if($query){
				$data = mysqli_fetch_assoc($query);
				$response = array('status'=>1, 'mode'=>$data['mode'], 'time'=>$data['time']);
			}else{
				$response = array('status'=>0, 'msg'=>mysqli_error($conn));
			}
		}else if($action == 'geocode'){
			//Geocoding
			//We get data and type of datas

			$data = !empty($request['data'])?$request['data']:"";
			$type = !empty($request['type'])?$request['type']:"";

			if(!empty($data) && !empty($type)){

			}else{}
		}else if($action == 'field_info'){
			//Getting data on field
			$field = $request['field']??"";

			$sql = "SELECT * FROM fields WHERE id = \"$field\" LIMIT 1 ";
			$query = $conn->query($sql);
			if($query){
				$data = $query->fetch_assoc();
				$response = array('status'=>true, $data);
			}else{
				$response = array('status'=>false, 'msg'=>"Error: $conn->error");
			}
		}else if($action == 'send_sms'){
			//Getting data on field
			$phone = $request['phone']??0;
			$message = $request['message']??"";

			if($phone && $message){
				//Sending the message
				$sms = sendsms($phone, $message);
				var_dump($sms);
			}
		}else if($action == 'add_user'){
			//Setting user to the subscriptions
			$phone = $request['phone']??0;
			$name = $request['name']??"";
			$location = $request['location'];

			//Intro message
			$mq = $conn->query("SELECT * FROM messages WHERE name = 'location' LIMIT 1");
			$md = $mq->fetch_assoc();
			$ms = $md['text'];

			$message = str_ireplace("\$name", $name, str_ireplace("\$date_today", date("D-M-Y"), str_ireplace("\$fert_kg", rand(6, 9), str_ireplace("\$temperature", rand(19, 29), $ms))));

			if($phone && $name){
				//Adding user
				$conn->query("INSERT INTO farmer(name, phone) VALUES(\"$name\", \"$phone\")");

				$id = $conn->insert_id;

				$sms = sendsms($phone, $message);

				$ok = "INSERT INTO location_subscribers(location, username, phone, subscribed) VALUES(\"$location\", \"$name\", \"$phone\", 'true')  ";
				echo($ok);
				$query = $conn->query("INSERT INTO location_subscribers(location, username, phone, subscribed) VALUES(\"$location\", \"$name\", \"$phone\", 'true')  ");
				if($query){
					$response = array("status"=>true);
				}else{
					$response = array("status"=>false, "msg database error $db->error");
				}
			}
		}else{
			$response = array("status"=>0, 'error'=>'Action specified is unrecognized');
		}
	}else{
		$response = array('status'=>0, 'error'=>"Specify action");
	}
	$new_response = array("data"=>$response);
	echo json_encode($new_response);
?>
