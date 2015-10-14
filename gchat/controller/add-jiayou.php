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
			$flag = false;
			function templateIcon($status) {
				echo "<div class='icon'><img class='success-icon' src='/static/img/book-success.jpg'><p>{$status}</p></div>";
			}
			$phone = $_POST['phone'];
			if(isset($_POST['time'])) {
				$time = $_POST['time'];
			} else {
				$time = '';
			}
			if($phone == NULL) {
				$flag = true;
			}
			$query = "INSERT INTO `jiayou`(`rid`, `phone`, `time`)
					  VALUES ('{$_GET['d']}', '{$phone}', '{$time}')";
			$check = mysql_query("SELECT * FROM `jiayou` WHERE `rid` = {$_GET['d']} AND `phone` = {$_POST['phone']}");
			if($flag || mysql_num_rows($check)) {
				templateIcon('抱歉');
				echo "感谢您对本线路的支持，您可能重复投票或未输入手机号！您可以将本公众号推荐给您的朋友来为该线路获得更多的支持率！";
			} else {
				if(mysql_query($query)){
					templateIcon('投票成功');
					echo "<p>感谢您对吉巴士的支持。</p>";
				}
			}
		 ?>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	</script>
</body>
</html>