 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<style>
		* {
			font-family: '黑体';
			border-radius: 0!important;
		}
		.head {
			height: 60px;
			text-align: center;
			background-color: #CE0F31;
			margin-bottom: 25%;
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
			margin: 0 auto;
			width: 90%;
		}
		.main .icon {
			font-weight: bold;
			font-size: 25px;
			color: #DC0032;
			text-align: center;
		}
		.main .icon p {
			margin-bottom: 30px;
			margin-top: 10px;
		}
		.main .success-icon {
			max-width: 250px;
		}
	</style>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
		<a href="../wap/route.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
	</div>
	<div class="main">
		<?php
			require_once('../../module/db/db.php');
			$startPoint = $_POST['sp'];
			$endPoint = $_POST['ep'];
			$phone = $_POST['phone'];
			$time = $_POST['time'];
			function templateIcon($status) {
				echo "<div class='icon'><img class='success-icon' src='/static/img/book-success.jpg'><p>{$status}</p></div>";
			}
			$query = "INSERT INTO `busroute`(`startpoint`, `endpoint`, `starttime`, `phone`)
					  VALUES ('{$startPoint}', '{$endPoint}', '{$time}', '{$phone}')";

			if(mysql_query($query)) {
				templateIcon('申请成功');
				echo "<p>感谢您对吉巴士的支持。我们已经收到了您的路线开通请求，我会根据需求量陆续开通相关路线，届时您将受到相关通知！</p>";
			} else {
				templateIcon('出错了...');
				echo "发生异常，请稍后再试！";
			}
		 ?>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>