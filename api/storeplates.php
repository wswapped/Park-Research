<?php
	$f = fopen("serverlogs.txt", 'a') or die("Unable to open file!");
	fwrite($f, date("d-m-Y i:s")."\n".json_encode($_POST)."\nfile:".json_encode($_FILES)."\n\n");
	fclose($f);
?>