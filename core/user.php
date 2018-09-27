<?php
	class user{
		public function add($name, $username, $phone, $email, $profile_picture = '', $gender='')
		{
			# adds system user
			global $conn;
			$query = $conn->query("INSERT INTO users(names, username, phone, email, profile_picture, gender) VALUES (\"$name\", \"$username\", \"$phone\", \"$email\", \"$profile_picture\", \"$gender\") ") or trigger_error("Error  $conn->error");
			return $conn->insert_id;
		}

		public function details($userId)
		{
			# returns user details
			global $conn;
			$query = $conn->query("SELECT * FROM users WHERE id = \"$userId\" LIMIT 1 ") or trigger_error("Error $conn->error");

			$data = $query->fetch_assoc();

			return $data;
		}


		public function types($userId){
			//finds the types of the user
			global $conn;
			$types = array();

			#!this searching function not select in user
			$details = $this->details($userId);

			
			//check if there admin type
			
			if($details['account_type'] == 'admin')
				$types = array_merge($types, array('admin'));
			else if($details['account_type'] == 'client')
				$types = array_merge($types, array('client'));

			//check if He's a supplier
			WEB::loadClass('supplier');
			global $Supplier;
			$supplierStatus = $Supplier->isSupplier($userId);
			if(is_bool($supplierStatus) && $supplierStatus == true){
				$types = array_merge($types, array('supplier'));
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