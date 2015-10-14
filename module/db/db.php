<?php
	// $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS);
	$con = mysql_connect("localhost","greatbus","Jia19870107");
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_query("SET NAMES 'utf8'",$con);
	mysql_select_db("gbus", $con);
?>