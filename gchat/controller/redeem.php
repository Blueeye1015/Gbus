<?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$id = $_POST['id'];
if (empty($id)) {
	die('<h1>非法访问！</h1>');
}
$check = mysql_query("SELECT * FROM `tickets` WHERE `id` = {$id}");
$result = mysql_fetch_object($check);
if($result->state == 1) {
	die('<h1>车票已经被使用！</h1>');
}
$updated = mysql_query("UPDATE `tickets` SET `state` = '1' WHERE `id` = {$id}");

$auth = new Auth();
$user = $auth->getUser();
if (empty($user)) {
	return $auth->login('route');
}

$config = [
	'app_id' => 'wxaa24b8c26ef8c218',
	'secret' => '456840b01100991311951e2ddbdfa066'
];
$js = new \Overtrue\Wechat\Js($config);
?><!DOCTYPE html>
<html>
<head>
	<title>吉巴士车票验证</title>
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
			padding-left: 5%;
			padding-right: 5%;
			text-align: center;
		}
		.redeem-icon {
			padding-top: 10%;
			max-width: 30%;
		}
		.redeem-text {
			color: #DC0032;
			margin-bottom: 10%;
		}
		.text2 {
			margin: 10px;
			color: #AAA;
		}
		#bg {
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.share-img {
			float: right;
			margin-right: 20px;
			max-width:60%;
			height:auto;
		}
		.mybtn.btn-danger {
			font-size: 15px;
			line-height: 250%;
			margin-top: 20px;
			background-color: #DC0032;
		}
	</style>
</head>
<body>
	<?php if ($updated) {?>
		<div class="head">
			<img src="/static/img/wap-logo.jpg" alt="">
		</div>
		<div class="main">
			<img class="redeem-icon" src="/static/img/redeem.png" alt=""/>
			<h1 class="redeem-text">确认已上车</h1>
			<h3 class="text2">和我一起</h3>
			<h3 class="text2">坐免费巴士回家吧！</h3>
			<button class="btn mybtn btn-block btn-danger btn-lg" id="btn-share">分享赚取积分</button>
		</div>
		<div id="bg">
			<img class="share-img" src="/static/img/share.png" alt=""/>
		</div>
	<?php }?>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
	<script src="../wap/js/share.js"></script>
	<script>
		$(function () {
			$('#btn-share').on('click', function () {
				$('#bg').show();
			})
			$('#bg').on('click', function () {
				$('#bg').hide();
			})
			var leanconfig = {
				APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
				APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
			}
			var openid = '<?php echo $user->openid; ?>';
			AV.initialize(leanconfig.APPID, leanconfig.APPKEY);
			var busUser = AV.Object.extend("gbusUser")
			var query = new AV.Query(busUser)
			query.equalTo("openId", openid)
			query.find({
				success: function (users) {
					if(users[0]) {
						var thisUser = users[0]
						$('#score').append(thisUser.attributes.score)
						$('.main').show()
					}
					else {
						location.href = './_login.php?refer=info'
					}
				},
				error: function (e) {
					alert(e)
				}
			})

			wx.config(<?php echo $js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage'), false, true) ?>);
			share(openid)

			var busUser = AV.Object.extend("gbusUser")
			var query = new AV.Query(busUser)
			query.equalTo("openId", openid)
			query.find({
				success: function (users) {
					if(users[0].attributes.scorePerDay < 300) {
						users[0].set("score", users[0].attributes.score + 50)
						users[0].set("scorePerDay", users[0].attributes.scorePerDay + 50)
						users[0].save()

						var data = AV.Object.extend("dataCount")
						var query = new AV.Query(data)
						query.get('55a3a3e1e4b06d11d38bcb5a', {
							success: function (data) {
								data.set("shareNum", data.attributes.shareNum + 1)
								data.save()
							},
							error: function (e) {
								console.log(e)
							}
						})
						alert('感谢您乘坐我们的巴士!您已经获得50积分!');
					} else {
						alert('每天只可以赚取300积分噢，明天再来吧！');
					}
				},
				error: function (e) {
					console.log(e)
				}
			})
		})
	</script>
</body>
</html>
