<?php
require('../db/db.php');
$orderData = $_POST['orderData'];
$orderId = '00000000';
$query = "INSERT INTO `busorder`(`startPoint`, `endPoint`, `startTime`,
									 `endTime`, `sitNumber`, `busNumber`, `toDo`, `tips`) 
			  VALUES ('{$orderData['startPoint']}', '{$orderData['endPoint']}', '{$orderData['startTime']}',
			  		  '{$orderData['endTime']}', '{$orderData['sitNumber']}', '{$orderData['busNumber']}',
			  		  '{$orderData['toDo']}', '{$orderData['tips']}')";
if(mysql_query($query)) {
    echo substr($orderId, 0, 8 - strlen(mysql_insert_id())).mysql_insert_id();
} else {
    echo "fail";
}