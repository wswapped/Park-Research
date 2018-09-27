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
	}
?>