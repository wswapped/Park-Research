<?php
	class parking{
		public function add($name, $username, $phone, $email, $profile_picture = '', $gender='')
		{
			# adds system user
			global $conn;
			$query = $conn->query("INSERT INTO users(names, username, phone, email, profile_picture, gender) VALUES (\"$name\", \"$username\", \"$phone\", \"$email\", \"$profile_picture\", \"$gender\") ") or trigger_error("Error  $conn->error");
			return $conn->insert_id;
		}

		public function addRole($systemRole, $parkingId){
			//addds system role to a parking
			global $conn;
			//check if user is already there
			$q = $conn->query("SELECT * FROM parking_roles WHERE systemRole = \"$systemRole\" AND parking = \"$parkingId\" AND archived = 'no'");
			if($q){
				//check if there is rows returned
				if($q->num_rows){
					return WEB::respond(false, "Parking role already exists and is active");
				}else{
					//here we can add role now
					$query = $conn->query("INSERT INTO parking_roles(systemRole, parking) VALUES(\"$systemRole\", \"$parkingId\")");
					if($query)
						return WEB::respond(true, '', array('id'=>$conn->insert_id));
					else
						return WEB::respond(false, "Error adding role $conn->error");
				}
			}else{
				return WEB::respond(false, "Error checking role existence $conn->error");
			}
		}

		public function details($id)
		{
			# returns parking details
			global $conn;
			$query = $conn->query("SELECT * FROM parking WHERE id = \"$id\" LIMIT 1 ") or trigger_error("Error $conn->error");
			$data = $query->fetch_assoc();
			$data['capacity'] = $this->totalCapacity($id);
			return $data;
		}

		public function totalCapacity($id)
		{
			# returns total capacity of the parking
			global $conn;
			$query = $conn->query("SELECT SUM(capacity) as capacity FROM parking_zones WHERE parking = \"$id\" LIMIT 1 ") or trigger_error("Error $conn->error");
			$data = $query->fetch_assoc();
			return $data['capacity']??0;
		}

		public function userList($userId){
			//finds user's parkings
			global $conn;
			$sql = "SELECT P.*, SR.role, RN.printName FROM parking AS P JOIN parking_roles AS PR ON PR.parking = P.id JOIN system_roles as SR ON PR.systemRole = SR.id JOIN role_names AS RN ON RN.name = SR.role WHERE user = \"$userId\" AND P.archived = 'no' ";
			$q = $conn->query($sql) or trigger_error($conn->error);
			if($q){
				return $q->fetch_all(MYSQLI_ASSOC);
			}else{
				return false;
			}
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

	$Parking = new parking();
?>