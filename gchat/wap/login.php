<?php session_start();

require_once('../../vendor/autoload.php');

$auth = new Auth();
$auth->setUser();
?>
<!DOCTYPE html>
<html>
<head>
	<title>登录</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		.welcome {
			padding: 30px 0;
			text-align: center;
			color: gray;
		}
		.login-btn {
			display: block;
			margin: auto;
			width: 90%;
			height: 46px;
			line-height: 46px;
			font-size: 22px;
			color: #fff;
			text-align: center;
			text-decoration: none;
			border: none;
			border-radius: 3px;
			background: rgb(255, 30, 30);
		}
	</style>
</head>
<body>
	<h3 class="welcome">
		<?php if (!empty($_SESSION['user']->nickname)){
				echo "欢迎回来" . $_SESSION['user']->nickname;
			} else {
				echo "进行下一步操作需要您先登录";
			}
		?>
	</h3>

	<a class="login-btn" href="http://<?php if (isset($_SESSION['redirect'])) echo $_SESSION['redirect'];?>">确定</a>
</body>
</html>