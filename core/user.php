<?php
	class user{
		public function add($name, $phone, $email, $profile_picture = '', $gender='')
		{
			# adds system user
			global $conn;
			$query = $conn->query("INSERT INTO users(name, phoneNumber, email, profilePicture, gender) VALUES (\"$name\", \"$phone\", \"$email\", \"$profile_picture\", \"$gender\") ");

			if($query){
				return WEB::respond(true, '', array('id'=>$conn->insert_id));
			}else{
				return WEB::respond(false, 'Error: '.$conn->error);
			}			
		}


		public function attachRole($userId, $roleName)
		{
			# attachs user with a system role
			global $conn;

			//check if user is attached to that role already
			$check = $conn->query("SELECT * FROM system_roles WHERE user = \"$userId\" AND role = \"$roleName\" AND archived = 'no' ");
			if($check){
				if($check->num_rows){
					//role already exist
				}else{
					//we can add role
					$sql = "INSERT INTO system_roles(user, role) VALUES(\"$userId\", \"$roleName\")";
					$check = $conn->query($sql);
					if($check){
						//successfully added a role
						return WEB::respond(true, '', array('id'=>$conn->insert_id));
					}else{
						//error
						return WEB::respond(false, "Error adding role $conn->error");
					}
				}
			}else{
				//errror
				return WEB::respond(false, 'Can not check user roles '.$conn->error);
			}		
		}


		public function details($userId)
		{
			# returns user details
			global $conn;
			$query = $conn->query("SELECT * FROM users WHERE id = \"$userId\" LIMIT 1 ") or trigger_error("Error $conn->error");

			$data = $query->fetch_assoc();

			return $data;
		}


		public function list()
		{
			# lists users
			global $conn;
			$query = $conn->query("SELECT * FROM users WHERE archived = \"no\" ORDER BY createdDate DESC ") or trigger_error("Error $conn->error");
			$data = $query->fetch_all(MYSQLI_ASSOC);
			return $data;
		}

		public function can($userId, $action){
			//checks if user is permitted to do something

			//get user types
			$roles = $this->types($userId);
			if(array_keys($roles, 'parkingAdmin') || array_keys($roles, 'admin')){
				return true;
			}else{
				return false;
			}
		}

		public function types($userId){
			//finds the types of the user
			global $conn;
			$types = array();

			#!this searching function not select in user
			$details = $this->details($userId);

			$q = $conn->query("SELECT role FROM system_roles WHERE user = \"$userId\" AND archived = 'no' ") or trigger_error($conn->error);
			if($q){
				while ($data = $q->fetch_assoc() ) {
					$types = array_merge($types, array($data['role']));
				};
			}

			return $types;
		}

		public function creatableRoles(){
			//Roles which can be created
			global $conn;
			$types = array();

			$q = $conn->query("SELECT name, printname FROM role_names WHERE name != 'admin' AND archived = 'no' ") or trigger_error($conn->error);
			if($q){
				while ($data = $q->fetch_assoc() ) {
					$types = array_merge($types, array($data['name']=>$data['printname']));
				};
			}
			return $types;
		}



		public function getTypeUsers($type){
			//finds the types of the user
			global $conn;

			$users = array();

			//check admins
			if($type == 'admin'){
				$query = $conn->query("SELECT id FROM users WHERE account_type = 'admin' ") or trigger_error("Error $conn->error");
				while ($data = $query->fetch_assoc()) {
					$users = array_merge($users, array($data['id']));
				}

			}else if($type == 'supplier'){
				WEB::loadClass('supplier');
				global $Supplier;

				$allSuppliers = $Supplier->list();
				foreach ($allSuppliers as $key => $supplier) {
					$users = array_merge($users, array($supplier['supplierId']));
				}
			}else{
				//user not recognized so far
			}
			
			return $users;
		}

		public function updatePassword($userId, $password)
		{
			# TODO: make secure
			global $conn;


			$query = $conn->query("UPDATE users SET password  = \"$password\" WHERE id = \"$userId\"") or trigger_error("Error $conn->error");

			if($query)
				return true;
			else
				return false;
		}
		public function updateProfilePicture($userId, $profile_picture)
		{
			# TODO: make secure
			global $conn;


			$query = $conn->query("UPDATE users SET profile_picture  = \"$profile_picture\" WHERE id = \"$userId\"") or trigger_error("Error $conn->error");

			if($query)
				return true;
			else
				return false;
		}
	}

	$User = new user();
?>