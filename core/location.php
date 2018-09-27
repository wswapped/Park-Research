<?php
	//Location class
	class Location
	{
		public static function get_provinces()
		{
			global $conn;
			$query = $conn->query("SELECT * FROM provinces") or trigger_error($conn->error);

			$provs = array();

			while ($data = $query->fetch_assoc()) {
				$provs[] = $data;
			}
			return $provs;
		}

		public static function get_districts($province = "")
		{
			global $conn;
			if($province){
				//district in a province are needed

				//province id is specified
				if(is_numeric($province)){
					//here we have to query with province ID
					$query = $conn->query("SELECT * FROM districts WHERE provincecode = '$province' ") or trigger_error($conn->error);
				}else{
					$query = $conn->query("SELECT d.* FROM districts as d JOIN provinces as p ON d.provincecode = p.provincecode WHERE p.provincename  = '$province' ") or trigger_error($conn->error);
				}

			}else{
				//all dists
				$query = $conn->query("SELECT * FROM districts") or trigger_error($conn->error);
			}
			

			$dists = array();

			while ($data = $query->fetch_assoc()) {
				$dists[] = $data;
			}
			return $dists;
		}

		public static function get_sectors($district = "")
		{
			global $conn;
			if($district){
				//sectors in a district are needed

				//district id is specified
				if(is_numeric($district)){
					//here we have to query with district ID
					$query = $conn->query("SELECT * FROM sectors WHERE districtcode = '$district' ") or trigger_error($conn->error);
				}else{
					$query = $conn->query("SELECT s.* FROM sectors as s JOIN districts as d ON d.districtcode = s.districtcode WHERE d.namedistrict  = '$district' ") or trigger_error($conn->error);
				}

			}else{
				//all sects
				$query = $conn->query("SELECT * FROM sectors") or trigger_error($conn->error);
			}
			

			$dists = array();

			while ($data = $query->fetch_assoc()) {
				$dists[] = $data;
			}
			return $dists;
		}

		function get_location($location_id){
			//return names of location
			global $conn;
			$query = $conn->query("SELECT (SELECT provincename FROM provinces WHERE provincecode = L.province ) as province,
				(SELECT namedistrict FROM districts WHERE districtcode = L.district ) as district,
				(SELECT namesector FROM sectors WHERE sectorcode = L.sector ) as sector,
				(SELECT namecell FROM cells WHERE codeCell = L.cell ) as cell,
				(SELECT VillageName FROM villages WHERE CodeVillage = L.village ) as village
				FROM location as L WHERE id = \"$location_id\" ") or trigger_error($conn->error);
			return $query->fetch_assoc();
		}
	}
?>