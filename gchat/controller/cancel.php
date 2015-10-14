<?php
/**
 * Created by PhpStorm.
 * User: Dante
 * Date: 2015.06.22
 * Time: 21:20
 */
require_once('../../module/db/db.php');

$addsit = mysql_query("UPDATE `lines` SET `sitnum`=`sitnum` + 1 WHERE `id` = {$_GET['line_id']}");
$deleteTickte = mysql_query("DELETE FROM `tickets` WHERE `id` = {$_GET['id']}");
?>
<!DOCTYPE html>
<html>
<head>
	<title>吉巴士车票验证</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<style>
		* {
			font-family: '黑体'!important;
			border-radius: 0!important;
		}
		.head {
			height: 60px;
			text-align: center;
			background-color: #CE0F31;
			margin-bottom: 15%;
		}
		.head img {
			margin-top: 15px;
			height: 30px;
		}
		.head span{
			position: absolute;
			float: left;
			color: #FFF;
			font-size: 20px;
			top: 20px;
			left: 10px;
		}
		.main {
			text-align: center;
		}
		.redeem-icon {
			padding-top: 10%;
			max-width: 30%;
		}
		.redeem-text {
			color: #DC0032;
			margin-bottom: 20%;
		}
		.text2 {
			margin: 10px;
			color: #AAA;
		}
	</style>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
		<!--			<a href="../wap/route.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>-->
	</div>
	<div class="main">
		<img class="redeem-icon" src="/static/img/cancel.png" alt=""/>
		<h1 class="redeem-text">订单已取消</h1>
		<h3 class="text2">下次再约哦！</h3>
	</div>
</body>
</html>