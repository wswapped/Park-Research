<?php
	class WEB{
		public static function loadClass($name)
		{
			//loads standard class
			$filename = $_SERVER['DOCUMENT_ROOT']."/core/$name.php";
			if(file_exists($filename) && !class_exists($name)){
				require_once($filename);
			}else{
				return false;
			}
		}

		public static function respond($status, $msg='', $data = array())
		{
			//Standard interface communication response creation
			$ret = array('status'=>$status, 'msg'=>$msg, 'data'=>$data);
			return (object)$ret;
		}

		public static function sanitize($variable, $type="")
		{
			//makes a variable safe to communicate with dabase
			global $conn;

			if($type == 'int'){
				//here we want to remove non-int stuffs
			}

			//normal cleaning/protection application
			return $conn->real_escape_string($variable);
		}

		public static function gendername($gender){
			if(strtolower($gender) == 'f'){
				return 'Female';
			}else{
				return 'Male';
			}
		}

		public static function validatePhone($phoneNumber, $loc='')
		{
			//validates phone against given locality or international phone format
			$len = strlen($phoneNumber);
			if($loc == 'rw'){
				if($len == 12){
					//here we can continue
					//check the format
					if(preg_match("^\d{3}(8|3|2)\d{7}^", $phoneNumber)){
						return WEB::respond(false, 'Phone number is in wrong format.');
					}else{
						return WEB::respond(false, 'Phone number is in wrong format.');
					}
				}else{
					//the phone number is small
					return WEB::respond(false, 'Phone number is small. It should be 12 characters long in 250xx format');
				}
			}else{
				if($len == 12){
					//here we can continue
					//check the format
					if(preg_match("^\d{12}^", $phoneNumber)){
						return WEB::respond(false, 'Phone number is in wrong format.');
					}else{
						return WEB::respond(false, 'Phone number is in wrong format.');
					}
				}else{
					//the phone number is small
					return WEB::respond(false, 'Phone number is small. It should be 12 characters long in 250xx format');
				}
			}
		}
	}
?>