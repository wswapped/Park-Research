<?php
ob_start();

//specify JSON as content type
header('Content-Type: application/json');

include_once '../../core/conn.php';
include_once '../../core/web.php';
include_once '../../core/user.php';
include_once '../../core/parking.php';
include_once '../../core/movements.php';

define('DB_DATE_FORMAT', 'Y-m-d H:i:s');

$standard_date = "Y-m-d h:i:s";

//gather all requests together
$request = array_merge($_GET, $_POST);

//cleaning all the post variables against attacks
foreach ($request as $key => $value) {
	// $request[$key] = $conn->real_escape_string($value);
}

//getting requested action
$action = $request['action']??"";

//return wrapper
$response = array();
if($action == 'carEntry'){
	//MArk entry of the car
	$carPlate = $request['carPlate']??"";
	$parkId = $request['parkId']??"";
	$cameraId = $request['cameraId']??"";

	//marking the entry of a car
	$query = $conn->query("INSERT INTO `movement` (`car`, `type`, `parking`, `camera`, `time`) VALUES (\"$carPlate\", 'entry', \"$parkId\", \"$cameraId\", CURRENT_TIMESTAMP)");
	if($query){
		//check if the user has some money
		$response = form_response(true);
	}else{
		$response = form_response(false, 'DB error '.$conn->error);
	}
}else if($action == 'carExit'){
	//Mark the exit of the car
	$carPlate = $request['carPlate']??"";
	$parkId = $request['parkId']??"";
	$cameraId = $request['cameraId']??"";

	//check if the entry time
	// $c = $conn->query("SELECT * FROM movement WHERE car = \"$carPlate\" AND parkId = \'\' ")

	//marking the exit of a car
	$query = $conn->query("INSERT INTO `movement` (`car`, `type`, `parking`, `camera`, `time`) VALUES (\"$carPlate\", 'exit', \"$parkId\", \"$cameraId\", CURRENT_TIMESTAMP)");
	if($query){
		//check if the user has some money
		$response = form_response(true);
	}else{
		$response = form_response(false, 'DB error '.$conn->error);
	}
}else if($action == 'lastMovement'){
	//returns the last movement of the car
	$plate = $request['plate'];
	$type = $request['type']??""; //type of preferred movement

	$cooperative = $request['cooperative']??"";

	$name = $request['name']??"";
	$phone = $request['phone']??"";
	$NID = $request['NID']??"";
	$gender = $request['gender']??"";
	$location = $request['location']??"";
	$birth_date = date("Y-m-d", strtotime($request['birth_date']))??false;
	$date = $request['date']??date($standard_date);
	// $date = $request['']??date($standard_date);

	if(!empty($_FILES['picture'])){
		$pic = $_FILES['picture'];
		$ext = strtolower(pathinfo($pic['name'], PATHINFO_EXTENSION)); //extension
		if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg')
		{
			$filename = "images/farmer/$name".time().".$ext";
			if(move_uploaded_file($pic['tmp_name'], "../$filename")){

			}else{
				//set the default image
				$filename = "images/farmer/default.jpg";

			}
		}
	}else{
		$filename = "images/farmer/default.jpg";
	}
	

	// checking if essential details ares et
	if(!($name && $NID && $gender)){
		$response = array('status'=>false, 'msg'=>"Provide all member details");		
	}else{

		//insert the user in DB
		$userId = $Cooperative->add_user($name , $phone , $NID , $gender, $birth_date, $filename);

		if($userId){
			add_farmer_cooperative($userId, $cooperative);
			$response = array('status'=>true, 'data'=>array('memberId'=>$userId));
		}else{
			$response = array('status'=>false, 'msg'=>"$conn->error");
		}
	}
}else if($action == 'addUser'){
	//Adding user to the system
	$name = $request['name']??"";
	$email = $request['email']??"";
	$role = $request['role']??"";
	$parking = $request['parking']??"";
	$phone = $request['phone']??"";
	$gender = $request['gender']??"";
	$password = $request['password']??"";

	//check if all parameters were set
	if($name && (($email && (filter_var($email, FILTER_VALIDATE_EMAIL)) || ($phone && WEB::validatePhone($phone))) && $role && $parking && $gender && $password)){
		//create a user in system
		$userCreation = $User->add($name, $phone, $email, '', $gender);
		if($userCreation->status){
			//creation was successful
			$userId = $userCreation->data['id'];
			
			//Let's add system role
			$systemId = $User->attachRole($userId, $role);

			if($systemId->status){
				//adding to parking
				$roleAddition = $Parking->addRole($systemId->data['id'], $parking);
				if($roleAddition->status){
					$response = WEB::respond(true, '', array('id'=>$userId));
				}else
					$response = $roleAddition;
				
			}else{
				//response from systemId
				$response = $systemId;
			}

			

			
		}else{
			//error creating user is returned
			$response = $userCreation;
		}
	}else{
		//somethng was wrong
		$response = WEB::response(false, 'Form was not filled well. Please check if all fields are filled and with correct values');
	}
}
else{
	$response = array('status'=>false, 'msg'=>"Specifiy action");
}

echo json_encode($response);

//Utility functions
function form_response($status, $msg='', $data= array()){
	// header("Content-Type: application/html");
	//removing nulls from response dataa
	$data = checknull($data);
	return array('status'=>$status, 'msg'=>$msg, 'data'=>$data);
}

function checknull($array){
	$cool_array  = array();
	//checks array again null

	// $depth = array_depth($array);

	// for($n=0; $n<$depth; $n++){
	// 	foreach ($variable as $key => $value) {
	// 		# code...
	// 	}
	// }

	// if($depth == 1){
	// }

	// if(is_array($value)){
	// 	cool_array[$key] = checknull($value);
	// }else{
	// 	$cool_array[$key] = $array[$key]??"";
	// }

	return $array;
}
function array_depth(array $array) {
	$max_depth = 1;

	foreach ($array as $value) {
		if (is_array($value)) {
			$depth = array_depth($value) + 1;

			if ($depth > $max_depth) {
				$max_depth = $depth;
			}
		}
	}

	return $max_depth;
}
?>