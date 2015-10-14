<?php session_start();
	require_once('../../vendor/autoload.php');
	$auth = new Auth();
	$auth->setUser();

	if(!isset($_COOKIE['openid'])) {
		setcookie('openid', $_SESSION['user']->openid, time()+3600*24);
		setcookie('nickname', $_SESSION['user']->nickname, time()+3600*24);
	}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/login.css"/>
</head>
<body>
<div class="head">
	<img src="/static/img/wap-logo.jpg" alt="">
</div>
<div class="main">
	<p>您好，吉巴士欢迎新用户的加入！</p><p>在这里请您先完善您的资料！</p>
	<form>
		<input class="form-control phone-input input-lg" placeholder="您的手机号" type="text" name="phone">
		<input class="form-control check-input input-lg" placeholder="验证码" type="text" name="token">
		<button class="btn mybtn btn-default" id="btn-check" type="button">获取验证码</button>
		<button class="btn mybtn btn-block btn-danger" type="button" id="btn-submit">提交资料</button>
		<a href="./route.php" class="btn mybtn btn-block btn-default">返回</a>
	</form>
</div>
<script src="/lib/jquery/jquery.min.js"></script>
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="../../lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
<script>
	var config = {
		APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
		APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
	}
	var openid = '<?php echo $_COOKIE['openid'] ?>'
	var nickname = '<?php echo $_COOKIE['nickname'] ?>'

	AV.initialize(config.APPID, config.APPKEY);

	var busUser = AV.Object.extend("gbusUser")
	var query = new AV.Query(busUser)
	var refer = '<?php echo $_GET['refer']; ?>'
	query.equalTo("openId", openid)
	query.find({
		success: function (users) {
			if(users[0]) {
				if (refer.indexOf('?') !== -1) {
					location.href = './' + refer;
				} else if (refer === 'weizhan') {
					location.href = 'http://mp.weixin.qq.com/bizmall/malldetail?id=&pid=pGxU1s_dDNswzCspg9ZNOdCYJFm0&biz=MzAwNjYwMDQ3NQ==&scene=&action=show_detail&showwxpaytitle=1#wechat_redirect'
				} else if (refer === 'weidian') {
					location.href = 'http://weidian.com/?userid=481177961';
				} else {
					location.href = './' + refer +'.php';
				}
			} else {
				$('.main').show();
			}
		},
		error: function (e) {
			alert(e)
		}
	})

	$(function() {
		$('#btn-submit').on('click', function () {
			var isFullInfo = true;
			$('.mybtn').attr('disabled', 'disabled') // 按钮disabled

			$('input').each(function() {
				if($(this).val() == "") { // 有空数据直接提示错误
					isFullInfo = false;
					$('.mybtn').removeAttr('disabled')
					alert("请填写完整信息!");
				}
			})
			if(isFullInfo) { // 数据完整
				var smsCode = $('.check-input').val();
				var phone = $('.phone-input').val();
				if(smsCode == 'wearegbus') {
					location.href = '../controller/register.php?refer=' + refer + '&phone=' + phone; // 后门验证码，测试用
				}
				AV.Cloud.verifySmsCode(smsCode, phone).then(function(){
					$('.mybtn').removeAttr('disabled')
					location.href = '../controller/register.php?refer=' + refer + '&phone=' + phone; // 验证成功 && 数据正确
				}, function(err){
					alert('验证码错误')
					$('.mybtn').removeAttr('disabled')
				})
			}
		})

		$('#btn-check').on('click', function () {
			var phone = $('.phone-input').val();
			if(phone.length != 11) {
				alert('请输入正确的手机号码！');
				return false;
			} else {
				AV.Cloud.requestSmsCode(phone).then(function(){
					alert('验证码已经发送至您手机，请耐心等待！（可能存在一定延迟，请勿重复点击）');
				}, function(err){
					console.error(err);
				});
			}
		})
	})
</script>
</body>
</html>