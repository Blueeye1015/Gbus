<?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$auth = new Auth();
$user = $auth->getUser();
if (empty($user)) {
	return $auth->login('info');
}

$config = [
	'app_id' => 'wxaa24b8c26ef8c218',
	'secret' => '456840b01100991311951e2ddbdfa066'
];
$js = new \Overtrue\Wechat\Js($config);
?><!DOCTYPE html>
<html>
<head>
	<title>个人信息</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/info.css"/>
</head>
<body>
	<div id="bg">
		<img class="share-img" src="/static/img/share.png" alt=""/>
	</div>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
	</div>
	<div class="main">
		<p id="score"></p>
		<p id="has-score">您目前拥有的积分</p>
		<p>想赚取更多的积分？</p>
		<p>赶快把这份福利分享给你的朋友吧</p>
		<button class="btn mybtn btn-block btn-danger btn-lg" id="btn-share">分享赚取积分</button>
		<p class="tips">1、每次分享赚取100积分，每天可赚取一次</p>
		<p class="tips">2、每次订票将消耗您100积分</p>
	</div>
<script src="/lib/jquery/jquery.min.js"></script>
<script src="../../lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script src="./js/share.js"></script>
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
	})
</script>
</body>
</html>
