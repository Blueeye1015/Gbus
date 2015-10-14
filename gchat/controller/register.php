<?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$auth = new Auth();
$user = $auth->getUser();
if (empty($user)) {
	return $auth->login();
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士会员注册</title>
</head>
<body>
	<p>注册成功，跳转中...</p>
</body>
<script src="../../lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
<script>
	var config = {
		APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
		APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
	}
	var phone = '<?php echo $_GET['phone']; ?>'
	var nickname = '<?php echo $user->nickname; ?>'
	var openid = '<?php echo $user->openid; ?>'
	var refer  = '<?php echo $_GET['refer']; ?>'

	AV.initialize(config.APPID, config.APPKEY);
	var busUser = AV.Object.extend("gbusUser")

	var query = new AV.Query(busUser) //检测有没有重复注册
	query.equalTo("openId", openid)
	query.find({
		success: function (users) {
			if(users[0]) {
				if(refer === 'weizhan') {
					location.href = 'http://mp.weixin.qq.com/bizmall/malldetail?id=&pid=pGxU1s_dDNswzCspg9ZNOdCYJFm0&biz=MzAwNjYwMDQ3NQ==&scene=&action=show_detail&showwxpaytitle=1#wechat_redirect';
				} else if (refer === 'weidian') {
					location.href = 'http://weidian.com/?userid=481177961';
				} else {
					location.href = '../wap/' + refer + '.php';
				}
			} else {
				var user = new busUser()
				user.set('openId', openid)
				user.set('mobile', phone)
				user.set('wxNickname', nickname)
				user.save(null, {
					success: function () {
						if(refer === 'weizhan') {
							location.href = 'http://mp.weixin.qq.com/bizmall/malldetail?id=&pid=pGxU1s_dDNswzCspg9ZNOdCYJFm0&biz=MzAwNjYwMDQ3NQ==&scene=&action=show_detail&showwxpaytitle=1#wechat_redirect';
						} else if (refer === 'weidian') {
							location.href = 'http://weidian.com/?userid=481177961';
						} else {
							location.href = '../wap/' + refer + '.php';
						}
					},
					error: function (err) {
						alert(err)
					}
				})
			}
		},
		error: function (e) {
			alert(e)
		}
	})
</script>
</html>